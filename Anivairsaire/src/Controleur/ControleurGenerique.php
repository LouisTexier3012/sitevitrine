<?php

namespace Aniv\Controleur;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Aniv\Lib\Conteneur;
use Aniv\Lib\MessageFlash;
use Twig\Environment;

class ControleurGenerique {

    protected static function afficherVue(string $cheminVue, array $parametres = []): Response
    {
        extract($parametres);
        $messagesFlash = MessageFlash::lireTousMessages();
        ob_start();
        require __DIR__ . "/../vue/$cheminVue";
        $corpsReponse = ob_get_clean();
        return new Response($corpsReponse);
   }

    protected static function afficherTwig(string $cheminVue, array $parametres = []): Response
    {
        /** @var Environment $twig */
        $twig = Conteneur::recupererService("twig");
        return new Response($twig->render($cheminVue, $parametres));
    }

    // https://stackoverflow.com/questions/768431/how-do-i-make-a-redirect-in-php


    protected static function rediriger(string $nomroute, array $parametre = null) : RedirectResponse{
        /**
         * @var UrlGenerator $generateur
         */
        $generateur=Conteneur::recupererService("generateurUrl");
        ob_start();
        if ($parametre!=null){
            $url=$generateur->generate($nomroute, $parametre);
        }else{
            $url=$generateur->generate($nomroute);
        }
        /** @var RedirectResponse $response */
        $response = ob_get_clean();
        header("Location: ".$url);
        return $response;
    }

    public static function afficherErreur($errorMessage = "", $controleur = ""): Response
    {
        $errorMessageView = "Warning";
        if ($controleur !== "")
            $errorMessageView .= " with the controller $controleur";
        if ($errorMessage !== "")
            $errorMessageView .= " : $errorMessage";

        $response =ControleurGenerique::afficherTwig('erreur.html.twig', [
            "pagetitle" => "Problème",
            "error" => $errorMessageView
        ]);
        return $response;
    }

}