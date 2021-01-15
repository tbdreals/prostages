<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;

class ProStagesController extends AbstractController
{
    /**
     * @Route("/", name="pro_stages")
     */
    public function index(): Response
    {
        // Récupérer le repository de l'entité Stage
        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);

        // Récupérer tous les stages enregistrés en BD
         $stages = $repositoryStage->findAll();

        // Envoyer les stages récupérés à la vue chargée de les afficher
        return $this->render('pro_stages/index.html.twig',
                              ['stages' => $stages]);
    }

    /**
     * @Route("/entreprises", name="prostages_entreprises")
     */
    public function entreprises(): Response
    {
        // On récupère le repository de l'entité entreprise
        $repositoryEntreprise = $this->getDoctrine()->getRepository(Entreprise::class);

        // Récupérer toutes les entreprises enregistrées en BD
        $entreprises = $repositoryEntreprise->findAll();

        // Envoyer les entreprises récupérées à la vue chargée de les afficher
        return $this->render('pro_stages/entreprises.html.twig',
                              ['entreprises' => $entreprises]);
    }

    /**
     * @Route("/formations", name="prostages_formations")
     */
    public function formations(): Response
    {
        // On récupère le repository de l'entité formation
        $repositoryFormation = $this->getDoctrine()->getRepository(Formation::class);

        // Récupérer toutes les formations enregistrées en BD
        $formations = $repositoryFormation->findAll();

        // Envoyer les formations récupérées à la vue chargée de les afficher
        return $this->render('pro_stages/formations.html.twig',
                              ['formations' => $formations]);
    }

    /**
     * @Route("/stages/{id}", name="prostages_stages")
     */
    public function stages($id): Response
    {
        // On récupère le repository de l'entité Stage
        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);

        // Recherche du stage donnt l'id a été fourni
        $stage = $repositoryStage->find($id);

        // Envoi du stage à la vue chargée de l'affichage
        return $this->render('pro_stages/stages.html.twig',
                              ['stage' => $stage]);
    }

    /**
     * @Route("/entreprises/{id}", name="prostages_stagesParEntreprise")
     */
    public function stagesParEntreprise($id): Response
    {
        // On récupère le repository de l'entité Entreprise
        $repositoryEntreprise = $this->getDoctrine()->getRepository(Entreprise::class);

        // Récupérer l'entreprises dont l'id a été fourni
        $entreprise = $repositoryEntreprise->find($id);

        // Envoi de l'entreprise à la vue chargée de l'affichage
        return $this->render('pro_stages/stagesParEntreprise.html.twig',
                              ['entreprise' => $entreprise]);
    }

    /**
     * @Route("/formations/{id}", name="prostages_stagesParFormation")
     */
    public function stagesParFormation($id): Response
    {
        // On récupère le repository de l'entité Formation
        $repositoryFormation = $this->getDoctrine()->getRepository(Formation::class);

        // Récupérer la formation dont l'id a été fourni
        $formation = $repositoryFormation->find($id);

        // On envoie ces données à la vue chargée de l'affichage
        return $this->render('pro_stages/stagesParFormation.html.twig',
                              ['formation' => $formation]);
    }
}
