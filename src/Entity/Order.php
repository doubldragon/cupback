<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
*/
class Product
{
    /**
    * @ORM\Id
    * @ORM\GeneratedValue
    * @ORM\Column(type="integer")
    */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var int
     *
     * @ORM\Column(name="zipcode", type="integer")
     */
    private $zipcode;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="bags", type="integer")
     */
    private $bags;

    /**
     *
     * @ORM\Column(name="roast", type="string", length=255, unique=true)
     */
    private $roast;

    /**
     * @ORM\Column(name="isLocal", type="boolean")
     */
    private $isLocal;

    /**
     *
     * @ORM\Column(name="comments", type="text")
     */
    private $comments;




}