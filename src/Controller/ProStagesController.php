<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProStagesController extends AbstractController
{
    /**
     * @Route("/", name="pro_stages")
     */
    public function index(): Response
    {
        return $this->render('pro_stages/index.html.twig');
    }

    /**
     * @Route("/entreprises", name="entreprises")
     */
    public function entreprises(): Response
    {
        return $this->render('pro_stages/entreprises.html.twig');
    }

    /**
     * @Route("/formations", name="formations")
     */
    public function formations(): Response
    {
        return $this->render('pro_stages/formations.html.twig');
    }

    /**
     * @Route("/stages/{id}", name="formations")
     */
    public function stages($id): Response
    {
        return $this->render('pro_stages/stages.html.twig', ['idStage' => $id]);
    }
}
