<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Repository\StageRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\FormationRepository;

class ProStagesController extends AbstractController
{
    /**
     * @Route("/", name="pro_stages")
     */
    public function index(StageRepository $repositoryStage): Response
    {
        // Récupérer tous les stages enregistrés en BD
         $stages = $repositoryStage->findAll();

        // Envoyer les stages récupérés à la vue chargée de les afficher
        return $this->render('pro_stages/index.html.twig',
                              ['stages' => $stages]);
    }

    /**
     * @Route("/entreprises", name="prostages_entreprises")
     */
    public function entreprises(EntrepriseRepository $repositoryEntreprise): Response
    {
        // Récupérer toutes les entreprises enregistrées en BD
        $entreprises = $repositoryEntreprise->findAll();

        // Envoyer les entreprises récupérées à la vue chargée de les afficher
        return $this->render('pro_stages/entreprises.html.twig',
                              ['entreprises' => $entreprises]);
    }

    /**
     * @Route("/formations", name="prostages_formations")
     */
    public function formations(FormationRepository $repositoryFormation): Response
    {
        // Récupérer toutes les formations enregistrées en BD
        $formations = $repositoryFormation->findAll();

        // Envoyer les formations récupérées à la vue chargée de les afficher
        return $this->render('pro_stages/formations.html.twig',
                              ['formations' => $formations]);
    }

    /**
     * @Route("/stages/{id}", name="prostages_stages")
     */
    public function stages(Stage $stage): Response
    {
        // L'utilisation du mécanisme d'injection nous permet d'obtenir directement l'objet stage
        // La recherche par identifiant est effectuée automatiquement
        // Envoi du stage à la vue chargée de l'affichage
        return $this->render('pro_stages/stages.html.twig',
                              ['stage' => $stage]);
    }

    /**
     * @Route("/entreprises/{id}", name="prostages_stagesParEntreprise")
     */
    public function stagesParEntreprise(EntrepriseRepository $repositoryEntreprise, $id): Response
    {
        // Je n'utilise plus le mécanisme d'injection de dépendances "poussée" afin de garder le code lisible.
        // On visualise mieux quelle recherche est appliquée sur le repository
        // Récupérer l'entreprises dont l'id a été fourni
        $entreprise = $repositoryEntreprise->find($id);

        // Envoi de l'entreprise à la vue chargée de l'affichage
        return $this->render('pro_stages/stagesParEntreprise.html.twig',
                              ['entreprise' => $entreprise]);
    }

    /**
     * @Route("/formations/{id}", name="prostages_stagesParFormation")
     */
    public function stagesParFormation(FormationRepository $repositoryFormation, $id): Response
    {
        // Récupérer la formation dont l'id a été fourni
        $formation = $repositoryFormation->find($id);

        // On envoie ces données à la vue chargée de l'affichage
        return $this->render('pro_stages/stagesParFormation.html.twig',
                              ['formation' => $formation]);
    }
}
