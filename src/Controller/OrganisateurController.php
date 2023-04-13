<?php

namespace App\Controller;

use App\Entity\Organisateur;
use App\Form\OrganisateurType;
use App\Repository\OrganisateurRepository;
use App\Service\CsvExportService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/organisateur')]
class OrganisateurController extends AbstractController
{
    #[Route('/', name: 'app_organisateur_index', methods: ['GET'])]
    public function index(OrganisateurRepository $organisateurRepository,Request $request,CsvExportService $csvService): Response
    {
        $organisateurs = $organisateurRepository->findAll();

        if ($request->query->get('export') == 'csv') {
            $response = new Response();
            $response->headers->set('Content-type', 'text/csv');
            $response->headers->set('Cache-Control', 'private');
            $response->headers->set('Content-Disposition', 'attachment; filename="' . "organisateur.csv" . '";');
            $response->sendHeaders();

            $response->setContent($csvService->exportOrganisateursToCsv($organisateurs));

            return $response;
        }
        return $this->render('organisateur/index.html.twig', [
            'organisateurs' => $organisateurs,
        ]);
    }

    #[Route('/new', name: 'app_organisateur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OrganisateurRepository $organisateurRepository): Response
    {
        $organisateur = new Organisateur();
        $form = $this->createForm(OrganisateurType::class, $organisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $organisateurRepository->save($organisateur, true);

            return $this->redirectToRoute('app_organisateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('organisateur/new.html.twig', [
            'organisateur' => $organisateur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_organisateur_show', methods: ['GET'])]
    public function show(Organisateur $organisateur): Response
    {
        return $this->render('organisateur/show.html.twig', [
            'organisateur' => $organisateur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_organisateur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Organisateur $organisateur, OrganisateurRepository $organisateurRepository): Response
    {
        $form = $this->createForm(OrganisateurType::class, $organisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $organisateurRepository->save($organisateur, true);

            return $this->redirectToRoute('app_organisateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('organisateur/edit.html.twig', [
            'organisateur' => $organisateur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_organisateur_delete', methods: ['POST'])]
    public function delete(Request $request, Organisateur $organisateur, OrganisateurRepository $organisateurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$organisateur->getId(), $request->request->get('_token'))) {
            $organisateurRepository->remove($organisateur, true);
        }

        return $this->redirectToRoute('app_organisateur_index', [], Response::HTTP_SEE_OTHER);
    }
}
