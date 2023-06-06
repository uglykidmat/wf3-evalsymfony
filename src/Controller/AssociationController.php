<?php

namespace App\Controller;

use AssociationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/association')]
class AssociationController extends AbstractController
{
    #[Route('/', name: 'app_association_index')]
    public function index(): Response
    {
        return $this->render('association/index.html.twig', [
            'controller_name' => 'AssociationController'
        ]);
    }
}
