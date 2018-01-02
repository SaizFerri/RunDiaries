<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Run;

/**
 * @ORM\Entity
 * @UniqueEntity(fields="email", message="Email already in use")
 * @UniqueEntity(fields="username", message="Username already taken")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $roles = array();

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Run", mappedBy="user")
     */
    private $runs;


    public function getRuns()
    {
        return $this->runs;
    }

    public function getAllKm()
    {
        $runs = $this->getRuns();
        $distance = 0;

        foreach ($runs as $run) {
            $distance += $run->getDistance();
        }

        return $distance;
    }

    public function getAllDays()
    {
        $runs = $this->getRuns();
        $days = 0;

        foreach ($runs as $run) {
            $days++;
        }

        return $days;
    }

    public function getDaysUntilToday()
    {
        $runs = $this->getRuns();

        for ($i = 0; $i < sizeof($runs); $i++) {
            for ($j = 0; $j < sizeof($runs); $j++) {
                if (strtotime($runs[$i]->getFormatedDate()) < strtotime($runs[$j]->getFormatedDate())) {
                    $tmp = $runs[$i];
                    $runs[$i] = $runs[$j];
                    $runs[$j] = $tmp;
                }
            }
        }

        if (count($runs) > 0) {
            date_default_timezone_set('Europe/Berlin');
            $date = date('d-m-Y', time());

            $first = strtotime($runs[0]->getFormatedDate());
            $last = strtotime($date);

            $datediff = $last - $first;

            return floor($datediff / (60 * 60 * 24));
        } else {
            return null;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getSalt()
    {
        return null;
    }

    public function getRoles()
    {
        $tmpRoles = $this->roles;

        if (in_array('ROLE_USER', $tmpRoles) === false) {
            $tmpRoles[] = 'ROLE_USER';
        }

        return $tmpRoles;
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    public function eraseCredentials()
    {
    }
}
