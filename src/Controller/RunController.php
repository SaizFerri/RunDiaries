<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Entity\Run;
use App\Entity\User;

class RunController extends Controller
{
    /**
     * @Route("/run/{id}", name="run")
     */
     public function new($id, Request $request)
     {
          $em = $this->getDoctrine()->getManager();

          $run = $this->getDoctrine()
              ->getRepository(Run::class)
              ->find($id);

          dump($run);

           $em->remove($run);
           $em->flush();

           return new Response('<html><body>OK</body></html>');
     //     $run = new Run();
     //
     //     $form = $this->createForm();
     //
     //      $form->handleRequest($request);
     //
     //      if ($form->isSubmitted() && $form->isValid()) {
     //           $run = $form->getData();
     //           $user = $this->getDoctrine()->getManager()
     //                ->getRepository(User::class)
     //                ->findOneById($id);
     //
     //           $run->setUser($user);
     //           dump($run);
     //
     //           $em = $this->getDoctrine()->getManager();
     //           $em->persist($run);
     //           $em->flush();
     //
     //      }
     //
     //     return $this->render('form.html.twig', array(
     //         'form' => $form->createView(),
     //     ));
     }
}
