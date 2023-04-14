<?php

namespace App\Controller;

use App\Entity\MainOeuvre;
use App\Form\MainOeuvreType;
use App\Repository\MainOeuvreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/main_oeuvre')]
class MainOeuvreController extends AbstractController
{
    #[Route('/', name: 'app_main_oeuvre_index', methods: ['GET'])]
    public function index(MainOeuvreRepository $mainOeuvreRepository): Response
    {
        return $this->render('main_oeuvre/index.html.twig', [
            'main_oeuvres' => $mainOeuvreRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_main_oeuvre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MainOeuvreRepository $mainOeuvreRepository): Response
    {
        $mainOeuvre = new MainOeuvre();
        $form = $this->createForm(MainOeuvreType::class, $mainOeuvre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mainOeuvreRepository->save($mainOeuvre, true);

            return $this->redirectToRoute('app_main_oeuvre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('main_oeuvre/new.html.twig', [
            'main_oeuvre' => $mainOeuvre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_main_oeuvre_show', methods: ['GET'])]
    public function show(MainOeuvre $mainOeuvre): Response
    {
        return $this->render('main_oeuvre/show.html.twig', [
            'main_oeuvre' => $mainOeuvre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_main_oeuvre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MainOeuvre $mainOeuvre, MainOeuvreRepository $mainOeuvreRepository): Response
    {
        $form = $this->createForm(MainOeuvreType::class, $mainOeuvre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mainOeuvreRepository->save($mainOeuvre, true);

            return $this->redirectToRoute('app_main_oeuvre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('main_oeuvre/edit.html.twig', [
            'main_oeuvre' => $mainOeuvre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_main_oeuvre_delete', methods: ['POST'])]
    public function delete(Request $request, MainOeuvre $mainOeuvre, MainOeuvreRepository $mainOeuvreRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mainOeuvre->getId(), $request->request->get('_token'))) {
            $mainOeuvreRepository->remove($mainOeuvre, true);
        }

        return $this->redirectToRoute('app_main_oeuvre_index', [], Response::HTTP_SEE_OTHER);
    }
}
