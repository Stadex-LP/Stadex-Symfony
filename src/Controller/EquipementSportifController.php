<?php

namespace App\Controller;

use App\Entity\EquipementSportif;
use App\Form\EquipementSportifType;
use App\Repository\EquipementSportifRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/equipement/sportif')]
class EquipementSportifController extends AbstractController
{
    #[Route('/', name: 'app_equipement_sportif_index', methods: ['GET'])]
    public function index(EquipementSportifRepository $equipementSportifRepository): Response
    {
        return $this->render('equipement_sportif/index.html.twig', [
            'equipement_sportifs' => $equipementSportifRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_equipement_sportif_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EquipementSportifRepository $equipementSportifRepository): Response
    {
        $equipementSportif = new EquipementSportif();
        $form = $this->createForm(EquipementSportifType::class, $equipementSportif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $equipementSportifRepository->save($equipementSportif, true);

            return $this->redirectToRoute('app_equipement_sportif_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('equipement_sportif/new.html.twig', [
            'equipement_sportif' => $equipementSportif,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_equipement_sportif_show', methods: ['GET'])]
    public function show(EquipementSportif $equipementSportif): Response
    {
        return $this->render('equipement_sportif/show.html.twig', [
            'equipement_sportif' => $equipementSportif,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_equipement_sportif_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EquipementSportif $equipementSportif, EquipementSportifRepository $equipementSportifRepository): Response
    {
        $form = $this->createForm(EquipementSportifType::class, $equipementSportif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $equipementSportifRepository->save($equipementSportif, true);

            return $this->redirectToRoute('app_equipement_sportif_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('equipement_sportif/edit.html.twig', [
            'equipement_sportif' => $equipementSportif,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_equipement_sportif_delete', methods: ['POST'])]
    public function delete(Request $request, EquipementSportif $equipementSportif, EquipementSportifRepository $equipementSportifRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$equipementSportif->getId(), $request->request->get('_token'))) {
            $equipementSportifRepository->remove($equipementSportif, true);
        }

        return $this->redirectToRoute('app_equipement_sportif_index', [], Response::HTTP_SEE_OTHER);
    }
}
