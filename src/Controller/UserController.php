<?php
namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use App\Form\UserRegistrationType;

class UserController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authUtils, AuthorizationCheckerInterface $authChecker)
    {
        if ($authChecker->isGranted('IS_AUTHENTICATED_FULLY') === true) {
            return $this->redirectToRoute('overview');
        }

        $error = $authUtils->getLastAuthenticationError();

        $lastUsername = $authUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error
        ));
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder, AuthorizationCheckerInterface $authChecker)
    {
        if ($authChecker->isGranted('IS_AUTHENTICATED_FULLY') === true) {
            return $this->redirectToRoute('overview');
        }

        $em = $this->getDoctrine()->getManager();

        $user = new User();

        $form = $this->createForm(UserRegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('security/registration.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/user/{id}", name="show_user", requirements={"id"="\d+"})
     */
     public function index(User $user)
     {

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }

        return $this->render('user/user.html.twig', array(
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'runs' => $user->getRuns(),
            'response' => $user->getUsername(),
        ));

     }
}
