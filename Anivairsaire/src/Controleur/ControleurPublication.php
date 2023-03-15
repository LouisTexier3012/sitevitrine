<?php

namespace Aniv\Controleur;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Aniv\Lib\ConnexionUtilisateur;
use Aniv\Lib\MessageFlash;
use Aniv\Modele\DataObject\Publication;
use Aniv\Modele\Repository\PublicationRepository;
use Aniv\Modele\Repository\UtilisateurRepository;
use Aniv\Service\Exception\ServiceException;
use Aniv\Service\PublicationService;

class ControleurPublication extends ControleurGenerique
{

    public static function feed() : Response
    {
        $publications = (new PublicationService())->recupererPublications();
        /** @var @var Response $reponse */
        $response = ControleurUtilisateur::afficherTwig("publication/feed.html.twig", [
            "publications" => $publications,
            "connection" => new ConnexionUtilisateur(),
        ]);
        return $response;
    }

    public static function submitFeedy():  RedirectResponse
    {
        $idUtilisateurConnecte = ConnexionUtilisateur::getIdUtilisateurConnecte();
        $message = $_POST['message'];
        try {
            (new PublicationService())->creerPublication($idUtilisateurConnecte,$message);
        }
        catch(ServiceException $e) {
            MessageFlash::ajouter("error", $e);
        }

        return ControleurPublication::rediriger('feed');
    }


}