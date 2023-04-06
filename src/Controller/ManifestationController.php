<?php

namespace App\Controller;

use App\Entity\Manifestation;
use App\Form\ManifestationType;
use App\Repository\ManifestationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/manifestation')]
class ManifestationController extends AbstractController
{
    #[Route('/', name: 'app_manifestation_index', methods: ['GET'])]
    public function index(ManifestationRepository $manifestationRepository): Response
    {
        return $this->render('manifestation/index.html.twig', [
            'manifestations' => $manifestationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_manifestation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ManifestationRepository $manifestationRepository): Response
    {
        $manifestation = new Manifestation();
        $form = $this->createForm(ManifestationType::class, $manifestation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Set the price of the Materiel
            $manifestation->getManifestationMateriels()->forAll(function ($key, $manifestationMateriel) {
                $manifestationMateriel->setPrixUnitaireFact($manifestationMateriel->getMateriel()->getPrixUnitaire());

                return true;
            });
            $manifestationRepository->save($manifestation, true);

            return $this->redirectToRoute('app_manifestation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('manifestation/new.html.twig', [
            'manifestation' => $manifestation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_manifestation_show', methods: ['GET'])]
    public function show(Manifestation $manifestation): Response
    {
        return $this->render('manifestation/show.html.twig', [
            'manifestation' => $manifestation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_manifestation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Manifestation $manifestation, ManifestationRepository $manifestationRepository): Response
    {
        $form = $this->createForm(ManifestationType::class, $manifestation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Set the price of the Materiel
            $manifestation->getManifestationMateriels()->forAll(function ($key, $manifestationMateriel) {
                $manifestationMateriel->setPrixUnitaireFact($manifestationMateriel->getMateriel()->getPrixUnitaire());

                return true;
            });
            $manifestationRepository->save($manifestation, true);

            return $this->redirectToRoute('app_manifestation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('manifestation/edit.html.twig', [
            'manifestation' => $manifestation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_manifestation_delete', methods: ['POST'])]
    public function delete(Request $request, Manifestation $manifestation, ManifestationRepository $manifestationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$manifestation->getId(), $request->request->get('_token'))) {
            $manifestationRepository->remove($manifestation, true);
        }

        return $this->redirectToRoute('app_manifestation_index', [], Response::HTTP_SEE_OTHER);
    }
}
