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
        dump($request->request->all());
        return $this->render('complete.html.twig', [
            'resp' => $resp,
        ]);
    }

    public function createAction() {

        $em = $this->getDoctrine()->getManager();

        $order = new Transaction();
        $order->setName('Keyboard');
        $order->setTotal(19.99);
        $order->setQuantity(3);
        $order->setStreet("104 place st");
        $order->setDescription('Ergonomic and stylish!');

        // tells Doctrine you want to (eventually) save the order (no queries yet)
        $em->persist($order);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();

        return new Response('Saved new order with id '.$order->getId());
    }
}
