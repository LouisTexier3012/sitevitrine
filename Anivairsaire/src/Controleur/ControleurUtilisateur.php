<?php

namespace Aniv\Controleur;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Aniv\Configuration\Configuration;
use Aniv\Lib\ConnexionUtilisateur;
use Aniv\Lib\MessageFlash;
use Aniv\Lib\MotDePasse;
use Aniv\Modele\DataObject\Utilisateur;
use Aniv\Modele\Repository\PublicationRepository;
use Aniv\Modele\Repository\UtilisateurRepository;
use Aniv\Service\Exception\ServiceException;
use Aniv\Service\UtilisateurService;

class ControleurUtilisateur extends ControleurGenerique
{

    public static function afficherErreur($errorMessage = "", $statusCode = 400): Response
    {
        $reponse = parent::afficherErreur($errorMessage, "utilisateur");

        $reponse->setStatusCode($statusCode);
        return $reponse;
    }

    public static function pagePerso($idUser): Response
    {
        try {
            $utilisateur = (new UtilisateurRepository())->get($idUser);
            $loginHTML = htmlspecialchars($utilisateur->getLogin());
            $publications = (new PublicationRepository())->getAllFrom($idUser);
        }catch(ServiceException $e) {
            MessageFlash::ajouter("error", $e);
            return ControleurUtilisateur::afficherVue("publication/feed.html.twig", []);
        }
        return ControleurUtilisateur::afficherTwig("publication/feed.html.twig", [
            "publications" => $publications,
            "pagetitle" => "Page de $loginHTML",
            "connection" => new ConnexionUtilisateur(),
        ]);
    }

    public static function afficherFormulaireCreation(): Response
    {
        $response = ControleurUtilisateur::afficherTwig('utilisateur/inscription.html.twig', [
            "pagetitle" => "Création d'un utilisateur",
            "cheminVueBody" => "utilisateur/formulaireCreation.php",
            "method" => Configuration::getDebug() ? "get" : "post",
        ]);
        return $response;
    }

    public static function creerDepuisFormulaire(): RedirectResponse
    {
            $login = $_POST['login']?? null; ;
            $password = $_POST['password']?? null; ;
            $adresseMail = $_POST['adresseMail']?? null; ;
            $profilePicture = $_FILES['profilePicture']?? null; ;
            try {
                (new UtilisateurService())->creerUtilisateur($login,$password,$adresseMail,$profilePicture);
            }
            catch(ServiceException $e) {
                MessageFlash::ajouter("error", $e);
            }

            MessageFlash::ajouter("success", "L'utilisateur a bien été créé !");
            $response=ControleurUtilisateur::rediriger("feed");
            return $response;
    }

    public static function afficherFormulaireConnexion(): Response
    {
        $response = ControleurUtilisateur::afficherTwig("utilisateur/connexion.html.twig", [
            "connection" => new ConnexionUtilisateur()
        ]);
        return $response;
    }


    public static function connecter(): RedirectResponse
    {

        $login =$_POST['login'] ?? null;
        $mdp = $_POST['password'] ?? null;

        try {
            (new UtilisateurService())->connecte($login,$mdp);
        }catch(ServiceException $e) {
            MessageFlash::ajouter("error", $e);
        }

        MessageFlash::ajouter("success", "Connexion effectuée.");
        return ControleurUtilisateur::rediriger("feed");
    }

    public static function deconnecter(): RedirectResponse
    {
        try {
            (new UtilisateurService())->disconect();
        }catch(ServiceException $e) {
            MessageFlash::ajouter("error", $e);
        }
        MessageFlash::ajouter("success", "L'utilisateur a bien été déconnecté.");
        $response =ControleurUtilisateur::rediriger("feed");
        return $response;
    }
}
