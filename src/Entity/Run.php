<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as AcmeAssert;
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
      * @Assert\Date()
      * @Assert\Regex("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/")
      * @AcmeAssert\MyDate
      * @ORM\Column(type="date")
      */
     private $date;

     /**
      * @Assert\NotBlank()
      * @Assert\GreaterThan(0)
      * @ORM\Column(type="float")
      */
     private $distance;

     /**
      * @Assert\NotBlank()
      * @Assert\Time()
      * @ORM\Column(type="time")
      */
     private $time;

     /**
      * @Assert\LessThan(40)
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

    public function calculateSpeed()
    {
        $distance = $this->convertKmToMeters($this->getDistance());
        $time = $this->convertTimeToSeconds($this->getFormatedTime());

        $result = $distance / $time;
        $roundedResult = round($result, 2);

        return $this->convertMsToKmh($roundedResult);
    }

    private function convertMsToKmh($value)
    {
        $speedMultiplier = 3.6;
        $result = $value * $speedMultiplier;
        return round($result, 2);
    }

    private function convertKmToMeters($value)
    {
        return $value*1000;
    }

    public function convertTimeToSeconds($time)
    {
        $hours = 0;
        $minutes = 0;
        $seconds = 0;

        $time = str_replace(':', '', $time);
        $hours = substr($time, 0, 2);
        $minutes = substr($time, 2, 2);
        $seconds = substr($time, 4, 2);

        // if statements to check if none of the parts have a 0 before the actual value like 01 hours,
        // if so it will be converted in just the second value of the string, in this example 1
        if (substr($hours, 0, 1) == 0) {
            $hours = substr($hours, 1, 1);
        }
        if (substr($minutes, 0, 1) == 0) {
            $minutes = substr($minutes, 1, 1);
        }
        if (substr($seconds, 0, 1) == 0) {
            $seconds = substr($seconds, 1, 1);
        }

        $hours *= 3600; //60 * 60 = 3600
        $minutes *= 60; // 1 time * 60 for the minutes

        $time_in_seconds = $hours + $minutes + $seconds;

        return $time_in_seconds;
    }
}
