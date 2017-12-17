<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController
{
    /**
     * @Route("/", name="default")
     */
     public function index()
     {
          return new Response(
            '<html><body>OK</body></html>'
        );
     }
}
