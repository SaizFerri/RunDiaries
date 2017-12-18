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
     public function show()
     {
          $em = $this->getDoctrine()->getManager();
          $users = $em->getRepository(User::class)->findAll();

          return $this->render('overview.html.twig', array(
               'users' => $users
          ));
     }

     /**
      * @Route("/admin/dashboard", name="admin_dashboard")
      */
     public function dashboardAction()
     {
          $this->denyAccessUnlessGranted('ROLE_ADMIN');

          $em = $this->getDoctrine()->getManager();
          $users = $em->getRepository(User::class)->findAll();

          return $this->render('admin/dashboard.html.twig', array(
               'users' => $users
          ));
     }

     /**
      * @Route("/admin/edit_user/{id}", name="edit_user", requirements={"id"="\d+"})
      */
     public function editUserAction(Request $request, User $user)
     {
          $this->denyAccessUnlessGranted('ROLE_ADMIN');

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
               'user' => $user,
               'form' => $form->createView()
          ));
     }
}
