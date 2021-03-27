<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\UserType;
use Doctrine\Persistence\ManagerRegistry;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/inscription", name="app_inscription")
     */
     public function inscription(Request $request, ManagerRegistry $manager): Response
     {
        // Création d'un utilisateur vide qui sera rempli par le formulaire
        $utilisateur = new User();

        // Création du formulaire permettant de saisir un utilisateur
        $formulaireUtilisateur = $this->createForm(UserType::class, $utilisateur);

        /* On demande au formulaire d'analyser la dernière requête Http.
           Si le tableau POST contenu dans cette requête contient des variables email, mot de passe, etc.
           alors la méthode handleRequest() récupère les valeurs de ces variables
           et les affecte à l'objet $ressource */
           $formulaireUtilisateur->handleRequest($request);

           if ($formulaireUtilisateur->isSubmitted() && $formulaireUtilisateur->isValid()) {
             // Enregistrer le stage en base de donnéelse
             //$manager->getManager()->persist($entreprise);
             //$manager->getManager()->flush();

             // Rediriger l'utilisateur vers la page d'accueil
             return $this->redirectToRoute('pro_stages');
           }

           // Création de la représentation graphique du $formulaireStage
           $vueFormulaire = $formulaireUtilisateur->createView();

           // Afficher la page présentant le formulaire d'ajout d'une entreprise
           return $this->render('security/inscription.html.twig', ['vueFormulaire' => $vueFormulaire]);
     }
}
