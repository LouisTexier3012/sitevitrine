<?php

namespace Aniv\Service;

use Aniv\Lib\ConnexionUtilisateur;
use Aniv\Lib\MotDePasse;
use Aniv\Modele\DataObject\Utilisateur;
use Aniv\Modele\Repository\UtilisateurRepository;
use Aniv\Service\Exception\ServiceException;

class UtilisateurService
{

    /**
     * @throws ServiceException
     */
    public function creerUtilisateur($login, $password, $adresseMail, $profilePictureData) {
        //TO-DO
        //Verifier que les attributs ne sont pas null
        if ($login==null || $password==null || $adresseMail==null || $profilePictureData==null){
            throw new ServiceException("un des attribute n'est pas remplit");
        }
        //Verifier la taille du login
        if (strlen($login) < 4 || strlen($login) > 20) {
            throw new ServiceException( "Le login doit être compris entre 4 et 20 caractères!");
        }
        //Verifier la validité du mot de passe
        if (!preg_match("#^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,20}$#", $password)) {
            throw new ServiceException( "Mot de passe invalide!");
        }
        //Verifier le format de l'adresse mail
        if (!filter_var($adresseMail, FILTER_VALIDATE_EMAIL)) {
            throw new ServiceException("L'adresse mail est incorrecte!");
        }
        //Verifier que l'utilisateur n'existe pas déjà
        $utilisateurRepository = new UtilisateurRepository();
        $utilisateur = $utilisateurRepository->getByLogin($login);
        if ($utilisateur != null) {
            throw new ServiceException("Ce login est déjà pris!");
        }
        //Verifier que l'adresse mail n'est pas prise
        $utilisateur = $utilisateurRepository->getByAdresseMail($adresseMail);
        if ($utilisateur != null) {
            throw new ServiceException("Un compte est déjà enregistré avec cette adresse mail!");
        }
        //Verifier extension photo de profil
        $explosion = explode('.', $profilePictureData['name']);
        $fileExtension = end($explosion);
        if (!in_array($fileExtension, ['png', 'jpg', 'jpeg'])) {
            throw new ServiceException("La photo de profil n'est pas au bon format!");
        }
        //Enregistrer la photo de profil
        $pictureName = uniqid() . '.' . $fileExtension;
        $from = $profilePictureData['tmp_name'];
        $to = __DIR__ . "/../../web/assets/img/utilisateurs/$pictureName";
        move_uploaded_file($from, $to);
        //Chiffrer le mot de passe
        $passwordChiffre = MotDePasse::hacher($password);
        //Enregistrer l'utilisateur...
        $utilisateur = Utilisateur::create($login, $passwordChiffre, $adresseMail, $pictureName);
        $utilisateurRepository->create($utilisateur);
    }

    /**
     * @throws ServiceException
     */
    public function recupererUtilisateur($idUtilisateur, $autoriserNull = true) {
        $utilisateur = (new UtilisateurRepository)->get($idUtilisateur);
     if(!$autoriserNull && $utilisateur === null) {
            throw new ServiceException("utilisateur inexistant cheh");
     }
     return $utilisateur;
    }

    /**
     * @throws ServiceException
     */
    public function connecte($login, $password){
        if (!(isset($_POST['login']) && isset($_POST['password']))) {
            throw new ServiceException("Login ou mot de passe manquant.");
        }
        $utilisateurRepository = new UtilisateurRepository();
        /** @var Utilisateur $utilisateur */
        $utilisateur = $utilisateurRepository->getByLogin($_POST["login"]);

        if ($utilisateur == null) {
            throw new ServiceException("Login inconnu.");
        }

        if (!MotDePasse::verifier($_POST["password"], $utilisateur->getPassword())) {
            throw new ServiceException("Mot de passe incorrect.");
        }
        ConnexionUtilisateur::connecter($utilisateur->getIdUtilisateur());
    }

    public function disconect(){
        if (!ConnexionUtilisateur::estConnecte()) {
            throw new ServiceException("Utilisateur non connecté.");
        }
        ConnexionUtilisateur::deconnecter();
    }

}