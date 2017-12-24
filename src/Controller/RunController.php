<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Run;
use App\Entity\User;

class RunController extends Controller
{
    /**
     * @Route("/run/delete_run/{id}", name="delete_run")
     */
     public function new($id, Request $request)
     {
          $em = $this->getDoctrine()->getManager();

          $run = $this->getDoctrine()
              ->getRepository(Run::class)
              ->find($id);

          $em->remove($run);
          $em->flush();

          return $this->redirectToRoute('user_profile', array('id' => $run->getUser()->getId()));
     }
}
