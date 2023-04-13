<?php

namespace App\Controller;

use App\Entity\Materiel;
use App\Form\MaterielType;
use App\Repository\MaterielRepository;
use App\Service\CsvExportService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[Route('/materiel')]
class MaterielController extends AbstractController
{
    #[Route('/', name: 'app_materiel_index', methods: ['GET'])]
    public function index(MaterielRepository $materielRepository, Request $request, CsvExportService $csvService): Response
    {
        $materiels = $materielRepository->findAll();

        if ($request->query->get('export') == 'csv') {
            $response = new Response();
            $response->headers->set('Content-type', 'text/csv');
            $response->headers->set('Cache-Control', 'private');
            $response->headers->set('Content-Disposition', 'attachment; filename="' . "materiel.csv" . '";');
            $response->sendHeaders();

            $response->setContent($csvService->exportMaterielsToCsv($materiels));

            return $response;
        }

        return $this->render('materiel/index.html.twig', [
            'materiels' => $materiels,
        ]);
    }

    #[Route('/new', name: 'app_materiel_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MaterielRepository $materielRepository): Response
    {
        $materiel = new Materiel();
        $form = $this->createForm(MaterielType::class, $materiel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $materielRepository->save($materiel, true);

            return $this->redirectToRoute('app_materiel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('materiel/new.html.twig', [
            'materiel' => $materiel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_materiel_show', methods: ['GET'])]
    public function show(Materiel $materiel): Response
    {
        return $this->render('materiel/show.html.twig', [
            'materiel' => $materiel,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_materiel_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Materiel $materiel, MaterielRepository $materielRepository): Response
    {
        $form = $this->createForm(MaterielType::class, $materiel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $materielRepository->save($materiel, true);

            return $this->redirectToRoute('app_materiel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('materiel/edit.html.twig', [
            'materiel' => $materiel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_materiel_delete', methods: ['POST'])]
    public function delete(Request $request, Materiel $materiel, MaterielRepository $materielRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$materiel->getId(), $request->request->get('_token'))) {
            $materielRepository->remove($materiel, true);
        }

        return $this->redirectToRoute('app_materiel_index', [], Response::HTTP_SEE_OTHER);
    }
}
