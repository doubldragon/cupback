<?php

// src/AppBundle/Entity/Orders.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ORM|Entity
 * ORM|Table(name="transaction")
 */

class Transaction
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */

    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */

    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     */

    private $email;

    /**
     * @ORM\Column(type="string", length=100)
     */

    private $street;

    /**
     * @ORM\Column(type="string", length=100)
     */

    private $city;

    /**
     * @ORM\Column(type="string", length=100)
     */

    private $state;

    /**
     * @ORM\Column(type="string", length=100)
     */

    private $zipcode;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="boolean)
     */
    private $isLocal;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $roast;
    /**
     * @ORM\Column(type="decimal", scale=2  )
     */
    private $total;

}