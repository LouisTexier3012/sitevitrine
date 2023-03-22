<?php

namespace App\Anniversaire\Modele\Repository;


use App\Anniversaire\Modele\DataObject\AbstractDataObject;
use App\Anniversaire\Modele\DataObject\Message;

class MessageRepository extends AbstractRepository
{



    protected function getNomTable(): string
    {
        return "message";
    }

    protected function getNomClePrimaire(): string
    {
        return "signature";
    }

    protected function getNomsColonnes(): array
    {
        return ["signature","message","lien1","lien2","lien3"];
    }

    protected function construireDepuisTableau(array $objetFormatTableau): AbstractDataObject
    {
        return new Message($objetFormatTableau["signature"],$objetFormatTableau["message"],$objetFormatTableau["lien1"]? : null,$objetFormatTableau["lien2"]? : null,$objetFormatTableau["lien3"]? : null);
    }
}