<?php
use App\Covoiturage\Controller\ControllerVoiture;
use App\Covoiturage\Controller\GenericController;

//require_once __DIR__ . "/../src/Controller/ControllerVoiture.php";
//require_once __DIR__ . "/../src/Controller/ControllerUtilisateur.php";
require_once __DIR__."/../src/Lib/Psr4AutoloaderClass.php";
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
$loader = new App\Covoiturage\Lib\Psr4AutoloaderClass();
// register the base directories for the namespace prefix
$loader->addNamespace('App\Covoiturage', __DIR__ . '/../src');
// register the autoloader
$loader->register();

if (isset($_GET['controller'])){
    $controller ="App\Covoiturage\Controller\Controller".ucfirst($_GET['controller']);
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
