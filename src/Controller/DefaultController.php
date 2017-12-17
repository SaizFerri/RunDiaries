<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Form\UserType;
use App\Entity\User;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="default")
     */
     public function index(UserInterface $user)
     {
          return $this->render('base.html.twig', array(
               'id' => $user->getId(),
          ));
     }

     /**
      * @Route("/overview", name="overview")
      */
     public function show(UserInterface $user = null)
     {
          $em = $this->getDoctrine()->getManager();
          $users = $em->getRepository(User::class)->findAll();

          if ($user === null) {
               $id = null;
          } else {
               $id = $user->getId();
          }

          return $this->render('overview.html.twig', array(
               'id' => $id,
               'users' => $users,
          ));
     }

     /**
      * @Route("/admin/dashboard", name="admin_dashboard")
      */
     public function dashboardAction(UserInterface $user)
     {
          $this->denyAccessUnlessGranted('ROLE_ADMIN');

          $em = $this->getDoctrine()->getManager();
          $users = $em->getRepository(User::class)->findAll();

          return $this->render('admin/dashboard.html.twig', array(
               'id' => $user->getId(),
               'users' => $users
          ));
     }

     /**
      * @Route("/admin/edit_user/{id}", name="edit_user")
      */
     public function editUserAction(Request $request, User $user, UserInterface $userLoggedIn)
     {
          $this->denyAccessUnlessGranted('ROLE_ADMIN');
          
          $em = $this->getDoctrine()->getManager();
          $form = $this->createForm(UserType::class, $user);
          $form->handleRequest($request);

          if ($form->isSubmitted() && $form->isValid()) {
               $em->persist($user);
               $em->flush();
          }

          return $this->render('admin/editUser.html.twig', array(
               'id' => $userLoggedIn->getId(),
               'user' => $user,
               'form' => $form->createView()
          ));
     }
}
