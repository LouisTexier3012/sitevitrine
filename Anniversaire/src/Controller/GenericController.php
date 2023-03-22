<?php

namespace App\Anniversaire\Controller;

class GenericController{
    protected static function afficheVue(string $cheminVue, array $parametres = []) : void {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../view/$cheminVue"; // Charge la vue
    }

    public static function  error(string $errorMessage = ""): void{
        self::afficheVue("message.html.twig");
    }
}