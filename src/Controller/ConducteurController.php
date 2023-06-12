<?php

namespace App\Controller;

use App\Entity\Conducteur;
use App\Form\ConducteurType;
use App\Repository\ConducteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/conducteur')]
class ConducteurController extends AbstractController
{
    #[Route('/', name: 'app_conducteur_index', methods: ['GET'])]
    public function index(ConducteurRepository $conducteurRepository): Response
    {
        return $this->render('conducteur/index.html.twig', [
            'conducteurs' => $conducteurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_conducteur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ConducteurRepository $conducteurRepository)
    {
        $conducteur = new Conducteur();
        $form = $this->createForm(ConducteurType::class, $conducteur);
        $form->handleRequest($request);
        $data = $form->getData();

        if ($form->isSubmitted() && $form->isValid()) {
            // $conducteur->addRelationvehicule();
            
            $conducteurRepository->save($conducteur, true);

            return $this->redirectToRoute("app_conducteur_show",[
                "id" => $conducteur->getId(),
                'data' => $data
            ]);
        }

        else if ($form->isSubmitted() && !$form->isValid()){
             $this->addFlash("danger","Le conducteur <strong>{$conducteur->getNom()} {$conducteur->getPrenom()}</strong> n'a pas pu être créé !");
            }
        return $this->render('conducteur/new.html.twig', [
            'conducteur' => $conducteur,
            'form' => $form,
        ]);
    
}

    #[Route('/{id}', name: 'app_conducteur_show', methods: ['GET'])]
    public function show(Conducteur $conducteur): Response
    {
        return $this->render('conducteur/show.html.twig', [
            'conducteur' => $conducteur,
            'data' => null,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_conducteur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Conducteur $conducteur, ConducteurRepository $conducteurRepository): Response
    {
        $form = $this->createForm(ConducteurType::class, $conducteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $conducteurRepository->save($conducteur, true);

            $this->addFlash("success","Le conducteur <strong>{$conducteur->getPrenom()} {$conducteur->getNom()}</strong> a bien été modifié !");

            return $this->redirectToRoute('app_conducteur_index', [], Response::HTTP_SEE_OTHER);
        }

        else if ($form->isSubmitted() && !$form->isValid()){
            $this->addFlash("warning","Le conducteur <strong>{$conducteur->getPrenom()} {$conducteur->getNom()}</strong> n'a pas pu être modifié !");
        }

        return $this->render('conducteur/edit.html.twig', [
            'conducteur' => $conducteur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_conducteur_delete', methods: ['POST'])]
    public function delete(Request $request, Conducteur $conducteur, ConducteurRepository $conducteurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$conducteur->getId(), $request->request->get('_token'))) {
            $conducteurRepository->remove($conducteur, true);
        }

        return $this->redirectToRoute('app_conducteur_index', [], Response::HTTP_SEE_OTHER);
    }
}
