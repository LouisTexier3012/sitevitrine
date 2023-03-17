<?php

namespace app\Anniversaire\Controller;


use app\Anniversaire\Lib\PreferenceControleur;

class GenericController{
    protected static function afficheVue(string $cheminVue, array $parametres = []) : void {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../view/$cheminVue"; // Charge la vue
    }

    public static function  error(string $errorMessage = ""): void{
        self::afficheVue ('view.php',["pagetitle"=>"Erreur","cheminVueBody"=>"error/error.php","message"=>$errorMessage]);
    }

    public static function formulairePreference(){
        self::afficheVue ('view.php',["pagetitle"=>"préférence","cheminVueBody"=>"formulairePreference.php"]);
    }

    public static function enregistrerPreference(){
        PreferenceControleur::enregistrer($_GET["controleur_defaut"]);
        ControllerMessage::afficheVue ('view.php',["pagetitle"=>"préférence enregistré","cheminVueBody"=>"enregistrerPreference.php"]);
    }
}