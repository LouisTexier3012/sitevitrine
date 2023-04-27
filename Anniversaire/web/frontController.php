<?php
namespace app;
require_once __DIR__."/../src/Lib/Psr4AutoloaderClass.php";
// instantiate the loader
$loader = new Anniversaire\Lib\Psr4AutoloaderClass();
// register the base directories for the namespace prefix
$loader->addNamespace('App\Anniversaire', __DIR__ . '/../src');
// register the autoloader
$loader->register();
use App\Anniversaire\Controller\GenericController;
use App\Anniversaire\Controller\ControllerMessage;

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


if (isset($_GET['controller'])){
    $controller = "App\Anniversaire\Controller\Controller".ucfirst($_GET['controller']);
    $verif=class_exists($controller);
    if ($verif){
        extracted($controller);
    }else{
        GenericController::error("Page Not Found");
    }
}else{
    $controller = "app\Anniversaire\Controller\ControllerMessage";
    extracted($controller);
}

// Appel de la méthode statique $action de ControllerVoiture
?>
