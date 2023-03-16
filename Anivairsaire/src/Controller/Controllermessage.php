<?php

namespace Anivairsaire\Controller\Controller;

use App\Covoiturage\Controller\GenericController;

class Controllermessage extends  GenericController{

    public function ecrire(){
        self::afficheVue("message.html.twig");
    }
}