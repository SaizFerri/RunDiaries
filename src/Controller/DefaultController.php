<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Form\UserType;
use App\Entity\User;

class DefaultController extends Controller
{
     /**
      * @Route("/", name="overview")
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
     public function editUserAction(Request $request, User $user, UserInterface $userLoggedIn = null)
     {
          $this->denyAccessUnlessGranted('ROLE_ADMIN');

          if ($userLoggedIn === null) {
               $id = null;
          } else {
               $id = $userLoggedIn->getId();
          }

          $em = $this->getDoctrine()->getManager();
          $form = $this->createFormBuilder($user)
               ->add('roles', ChoiceType::class, array(
                    'multiple' => true,
                    'expanded' => true,
                    'choices' => array(
                        'Admin' => 'ROLE_ADMIN',
                        'User' => 'ROLE_USER',
                        'Creator' => 'ROLE_CREATOR'
                    )
               ))
               ->add('save', SubmitType::class, array(
                    'label' => 'Save',
                    'attr' => array('class' => 'btn btn-success')
               ))
               ->remove('plainPassword')
               ->getForm();
          $form->handleRequest($request);

          if ($form->isSubmitted()) {
               $user->setRoles($form->getData()->getRoles());
               $em->persist($user);
               $em->flush();

               return $this->redirectToRoute('admin_dashboard');
          }

          return $this->render('admin/editUser.html.twig', array(
               'id' => $id,
               'user' => $user,
               'form' => $form->createView()
          ));
     }
}
