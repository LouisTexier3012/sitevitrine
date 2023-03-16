<?php

use Anniversaire\Controller\Lib\Psr4AutoloaderClass;
use Anniversaire\Controller\Controller\GenericController;
use Anniversaire\Controller\Controller\Controllermessage;

/**
 * @param string $control
 * @return void
 */
function extracted(string $control): void
{
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        if (in_array($action, get_class_methods($control))) {
            $control::$action();
        } else {
            $action = "error";
            $control::$action("Page Not Found");
        }
    } else {
        $action = "readAll";
        $control::$action();
    }
}

// instantiate the loader
$loader = new Psr4AutoloaderClass();
// register the base directories for the namespace prefix
$loader->addNamespace('App\Covoiturage', __DIR__ . '/../src');
// register the autoloader
$loader->register();

if (isset($_GET['controller'])){
    $controller ="Anniversaire\Controller\Controller".ucfirst($_GET['controller']);
    if (class_exists($controller)){
        extracted($controller);
    }else{
        GenericController::error("Page Not Found");
    }
}else{
    if (\App\Covoiturage\Lib\PreferenceControleur::existe()){
        $controller = "App\Covoiturage\Controller\Controller".ucfirst(\App\Covoiturage\Lib\PreferenceControleur::lire());
        extracted($controller);
    }else {
        $controller = "App\Covoiturage\Controller\ControllerVoiture";
        extracted($controller);
    }
}

// Appel de la méthode statique $action de ControllerVoiture
?>
