<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookingRepository")
 */
class Booking
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="integer")
     */
    private $event;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $phone;

    /**
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @ORM\Column(type="string")
     */
    private $from;

    /**
     * @ORM\Column(type="datetime")
     */
    private $arrivale;

    /**
     * @ORM\Column(type="datetime")
     */
    private $departure;

    /**
     * @ORM\Column(type="string")
     */
    private $note;

    /**
     * @ORM\Column(type="float")
     */
    private $deposit;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created  ;

    /**
     * @ORM\Column(type="integer")
     */
    private $usertype;

    /**
     * @ORM\Column(type="integer")
     */
    private $admin;

}
