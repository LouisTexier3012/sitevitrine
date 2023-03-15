<?php

namespace Aniv\Lib;

use Aniv\Modele\DataObject\Utilisateur;
use Aniv\Modele\HTTP\Session;
use Aniv\Modele\Repository\UtilisateurRepository;

class ConnexionUtilisateur
{
    private static string $cleConnexion = "_utilisateurConnecte";

    // Note : Classe trop couplée avec les sessions
    // TODO : Découpler avec un autre exemple de stockage (cookie via JWT ?)
    public static function connecter(string $idUtilisateur): void
    {
        $session = Session::getInstance();
        $session->enregistrer(ConnexionUtilisateur::$cleConnexion, $idUtilisateur);
    }

    public static function estConnecte(): bool
    {
        $session = Session::getInstance();
        return $session->existeCle(ConnexionUtilisateur::$cleConnexion);
    }

    public static function deconnecter()
    {
        $session = Session::getInstance();
        $session->supprimer(ConnexionUtilisateur::$cleConnexion);
    }

    public static function getIdUtilisateurConnecte(): ?string
    {
        $session = Session::getInstance();
        if ($session->existeCle(ConnexionUtilisateur::$cleConnexion)) {
            return $session->lire(ConnexionUtilisateur::$cleConnexion);
        } else
            return null;
    }
}
