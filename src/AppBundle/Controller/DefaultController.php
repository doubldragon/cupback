<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Transaction;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('cupback.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/submitOrder", name="submitOrder")
     */
    public function submitAction(Request $request)
    {
        $resp = $request->request->all();

        dump(in_array("isLocal", $resp));
        $stripeToken = $resp['stripeToken'];
        \Stripe\Stripe::setApiKey($this->getParameter('stripe_secret_key'));
        $charge = \Stripe\Charge::create(array(
            "amount" => $resp['gTotal'],
            "currency" => "usd",
            "description" => $resp['stripeShippingName'] . " - " . $resp['numBags'] . " bags",
            "source" => $stripeToken,
        ));

        $this->createAction($resp);
        $this->emailAction($resp);

        return $this->redirectToRoute('complete', [
            'resp' => $resp,
        ]);
    }

    public function emailAction($resp) {

        $resp['isLocal'] = in_array('isLocal', $resp);
        $message = \Swift_Message::newInstance()
            ->setSubject("Don't Call It a Cupback 2K17")
            ->setFrom($this->getParameter('mailer_user'))
            ->setBcc($this->getParameter('my_email'))
            ->setTo($resp['stripeEmail'], $resp['stripeBillingName'])
            ->setBody($this->renderView("email.html.twig", $resp), "text/html");

        $this->get("mailer")->send($message);


    }

    public function createAction($req) {
        dump($req);

        $em = $this->getDoctrine()->getManager();
        $isLocal = in_array("isLocal" , $req);

        $order = new Transaction();
        $order->setName($req['stripeShippingName']);
        $order->setEmail($req['stripeEmail']);
        $order->setTotal($req['gTotal']/100);
        $order->setQuantity($req['numBags']);
        $order->setRoast($req['roastLevel']);
        $order->setStreet($req['stripeShippingAddressLine1']);
        $order->setCity($req['stripeShippingAddressCity']);
        $order->setState($req['stripeShippingAddressState']);
        $order->setZipcode($req['stripeShippingAddressZip']);
        $order->setIsLocal($isLocal);
        $order->setComments($req['comments']);

        // tells Doctrine you want to (eventually) save the order (no queries yet)
        $em->persist($order);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();

        return new Response($order->getId());
    }

    /**
     * @Route("/complete", name="complete")
     */

    public function completeAction(Request $request) {
        $request = $request->query->all();
        $resp = $request['resp'];

        dump($resp);
        return $this->render("complete.html.twig", [
            "resp" => $resp
        ]);
    }
}
