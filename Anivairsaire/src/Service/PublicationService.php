<?php
namespace Aniv\Service;

use Aniv\Modele\DataObject\Publication;
use Aniv\Modele\Repository\PublicationRepository;
use Aniv\Modele\Repository\UtilisateurRepository;
use Aniv\Service\Exception\ServiceException;

class PublicationService{

    public function recupererPublications(){
        return (new PublicationRepository())->getAll();
    }

    /**
     * @throws ServiceException
     */
    public function creerPublication($idUtilisateur, $message) {
        $utilisateur = (new UtilisateurRepository())->get($idUtilisateur);

        if ($utilisateur == null) {
            throw new ServiceException("Utilisateur non controller!");

        }

        if ($message == null || $message == "") {
            throw new ServiceException("Aucun message rentré!");

        }
        if (strlen($message) > 250) {
            throw new ServiceException("Message trop long!");

        }

        $publication = Publication::create($message, $utilisateur);
        (new PublicationRepository())->create($publication);
    }

    public function recupererPublicationsUtilisateur($idUtilisateur){
        $utilisateur = (new UtilisateurRepository())->get($idUtilisateur);
        if ($utilisateur === null) {
            throw new ServiceException("Login inconnu.");
        } else {
            $publications = (new PublicationRepository())->getAllFrom($idUtilisateur);
            return $publications;
        }
    }
}