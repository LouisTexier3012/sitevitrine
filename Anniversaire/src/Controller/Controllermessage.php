<?php

namespace Anniversaire\Controller\Controller;

use Anniversaire\Controller\Controller\GenericController;

class Controllermessage extends  GenericController{

    public function ecrire(){
        self::afficheVue("message.html.twig");
    }
}