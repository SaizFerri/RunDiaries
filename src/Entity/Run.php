<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\User;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RunRepository")
 */
class Run
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="runs")
     * @ORM\JoinColumn(nullable=true)
     */
     private $user;

     /**
      * @Assert\NotBlank()
      * @ORM\Column(type="date")
      */
     private $date;

     /**
      * @Assert\NotBlank()
      * @ORM\Column(type="float")
      */
     private $distance;

     /**
      * @Assert\NotBlank()
      * @ORM\Column(type="time")
      */
     private $time;

     /**
      * @Assert\NotBlank()
      * @ORM\Column(type="float")
      */
     private $speed;


    public function getId()
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        return $this->user = $user;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getFormatedDate()
    {
        return date_format($this->date, 'd-m-Y');
    }

    public function setDate($date)
    {
        return $this->date = $date;
    }

    public function getDistance()
    {
        return $this->distance;
    }

    public function setDistance($distance)
    {
        return $this->distance = $distance;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function getFormatedTime()
    {
        return date_format($this->time, 'H:i:s');
    }

    public function setTime($time)
    {
        return $this->time = $time;
    }

    public function getSpeed()
    {
        return $this->speed;
    }

    public function setSpeed($speed)
    {
        return $this->speed = $speed;
    }
}
