<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\Persistence\ManagerRegistry;


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
         $stages = $repositoryStage->findAllAvecEntreprises();

        // Envoyer les stages récupérés à la vue chargée de les afficher
        return $this->render('pro_stages/index.html.twig',
                              ['stages' => $stages]);
    }

    /**
     * @Route("/ajoutEntreprise", name="prostages_ajoutEntreprise")
     */
    public function ajoutEntreprise(Request $request, ManagerRegistry $manager): Response
    {
        // Création d'une entreprise vierge qui sera remplie par le formulaire
        $entreprise = new Entreprise();

        // Création du formulaire permettant de saisir une entreprises
        $formulaireEntreprise = $this->createFormBuilder($entreprise)
          ->add('nom', TextType::class)
          ->add('adresse', TextType::class)
          ->add('site_web', UrlType::class)
          ->getForm();

        /* On demande au formulaire d'analyser la dernière requête Http.
           Si le tableau POST contenu dans cette requête contient des variables nom, adresse, etc.
           alors la méthode handleRequest() récupère les valeurs de ces variables
           et les affecte à l'objet $ressource */
        $formulaireEntreprise->handleRequest($request);

        if ($formulaireEntreprise->isSubmitted()) {
          // Enregistrer l'entreprise en base de donnéelse
          $manager->getManager()->persist($entreprise);
          $manager->getManager()->flush();

          // Rediriger l'utilisateur vers la page d'accueil
          return $this->redirectToRoute('pro_stages');
        }

        // Création de la représentation graphique du $formulaireEntreprise
        $vueFormulaire = $formulaireEntreprise->createView();

        // Afficher la page présentant le formulaire d'ajout d'une entreprise
        return $this->render('pro_stages/ajoutModifEntreprise.html.twig', [
            'vueFormulaire' => $vueFormulaire,
            'action' => "ajouter"
            ]);
    }

    /**
     * @Route("/modificationEntreprise/{id}", name="prostages_modificationEntreprise")
     */
    public function modificationEntreprise(Request $request, ManagerRegistry $manager, Entreprise $entreprise): Response
    {
        // Le mécanisme d'injection de dépendance a récupéré pour nous l'entité Entreprise dont l'id a été passé par l'URL
        // Création du formulaire permettant de saisir une entreprises
        $formulaireEntreprise = $this->createFormBuilder($entreprise)
          ->add('nom', TextType::class)
          ->add('adresse', TextType::class)
          ->add('site_web', UrlType::class)
          ->getForm();

        /* On demande au formulaire d'analyser la dernière requête Http.
           Si le tableau POST contenu dans cette requête contient des variables nom, adresse, etc.
           alors la méthode handleRequest() récupère les valeurs de ces variables
           et les affecte à l'objet $ressource */
        $formulaireEntreprise->handleRequest($request);

        if ($formulaireEntreprise->isSubmitted()) {
          // Enregistrer l'entreprise en base de donnéelse
          $manager->getManager()->persist($entreprise);
          $manager->getManager()->flush();

          // Rediriger l'utilisateur vers la page d'accueil
          return $this->redirectToRoute('pro_stages');
        }

        // Création de la représentation graphique du $formulaireEntreprise
        $vueFormulaire = $formulaireEntreprise->createView();

        // Afficher la page présentant le formulaire d'ajout d'une entreprise
        return $this->render('pro_stages/ajoutModifEntreprise.html.twig', [
            'vueFormulaire' => $vueFormulaire,
            'action' => "modifier"
            ]);
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
     * @Route("/entreprises/{nom}", name="prostages_stagesParEntreprise")
     */
    public function stagesParEntreprise(StageRepository $repositoryStage, $nom): Response
    {
        // Je n'utilise plus le mécanisme d'injection de dépendances "poussée" afin de garder le code lisible.
        // On visualise mieux quelle recherche est appliquée sur le repository
        // Récupérer les stages dont le nom de l'entreprise a été fourni
        $stages = $repositoryStage->findByNomEntreprise($nom);

        // Envoi de l'entreprise à la vue chargée de l'affichage
        return $this->render('pro_stages/stagesParEntreprise.html.twig',
                              ['stages' => $stages,
                               'nomEntreprise' => $nom]);
    }

    /**
     * @Route("/formations/{nom}", name="prostages_stagesParFormation")
     */
    public function stagesParFormation(StageRepository $repositoryStage, $nom): Response
    {
        // Récupérer les stages dont e nom de la formation a été fourni
        $stages = $repositoryStage->findByNomFormation($nom);

        // On envoie ces données à la vue chargée de l'affichage
        return $this->render('pro_stages/stagesParFormation.html.twig',
                              ['stages' => $stages,
                               'nomFormation' => $nom]);
    }
}
