<?php
namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authUtils, UserInterface $user = null)
    {
        if ($user === null) {
             $id = null;
        } else {
             $id = $user->getId();
        }

        $error = $authUtils->getLastAuthenticationError();

        $lastUsername = $authUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'id'            => $id,
            'last_username' => $lastUsername,
            'error'         => $error,
            'response'      => 'Ok',
        ));
    }

    /**
     *
     */

    /**
     * @Route("/user/{id}", name="show_user", requirements={"id"="\d+"})
     */
     public function index(User $user, UserInterface $userLoggedIn)
     {

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }

        return $this->render('user/user.html.twig', array(
            'id' => $userLoggedIn->getId(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'runs' => $user->getRuns(),
            'response' => $user->getUsername(),
        ));

     }
}
