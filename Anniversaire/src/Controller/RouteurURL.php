<?php
namespace app\Anniversaire\Controller;
use LogicException;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\NoConfigurationException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\HttpFoundation\RequestStack;
use TheFeed\Lib\ConnexionUtilisateur;
use TheFeed\Lib\Conteneur;
use TheFeed\Lib\MessageFlash;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;


class RouteurURL
{
    public static function traiterRequete() {

        $requete = Request::createFromGlobals();

        $routes = new RouteCollection();
        self::createRoute($routes);
        // Route feed

        $contexteRequete = (new RequestContext())->fromRequest($requete);
        $associateurUrl = new UrlMatcher($routes, $contexteRequete);
        $assistantUrl = new UrlHelper(new RequestStack(), $contexteRequete);
        $generateurUrl = new UrlGenerator($routes, $contexteRequete);


        $twigLoader = new FilesystemLoader(__DIR__ . '/../vue/');
        $twig = new Environment(
            $twigLoader,
            [
                'autoescape' => 'html',
                'strict_variables' => true
            ]
        );
        $twig->addFunction(new TwigFunction("route", $generateurUrl->generate(...)));
        $twig->addFunction(new TwigFunction("asset", $assistantUrl->getAbsoluteUrl(...)));
        $twig->addGlobal('messagesFlash', new MessageFlash());
        $twig->addGlobal('idConnecte', ConnexionUtilisateur::getIdUtilisateurConnecte());
        Conteneur::ajouterService("twig", $twig);







        Conteneur::ajouterService("assistantUrl",$assistantUrl);
        Conteneur::ajouterService("generateurUrl",$generateurUrl);
        try {
            $donneesRoute = $associateurUrl->match($requete->getPathInfo());$resolveurDeControleur = new ControllerResolver();
            $requete->attributes->add($donneesRoute);
            $controleur = $resolveurDeControleur->getController($requete);
            $resolveurDArguments = new ArgumentResolver();
            $arguments = $resolveurDArguments->getArguments($requete, $controleur);
            /** @var Response $reponse */
            $reponse = call_user_func_array($controleur, $arguments);
        } catch (NoConfigurationException|ResourceNotFoundException|LogicException $exception) {
            $reponse = ControleurGenerique::afficherErreur($exception->getMessage(), 404);
        } catch (MethodNotAllowedException $exception) {
            $reponse = ControleurGenerique::afficherErreur($exception->getMessage(), 405);
        } catch (RuntimeException $exception) {
            $reponse = ControleurGenerique::afficherErreur($exception->getMessage()) ;
        }
        $reponse->send();
    }

    public static function createRoute($routes){
        // Route feed
        $route = new Route("/", [
            "_controller" => "\TheFeed\Controleur\ControleurPublication::feed",
        ]);
        $routes->add("feed", $route);

        // Route afficherFormulaireConnexion
        $route = new Route("/connexion", [
            "_controller" => "\TheFeed\Controleur\ControleurUtilisateur::afficherFormulaireConnexion",
            // Syntaxes équivalentes
            // "_controller" => ControleurUtilisateur::class . "::afficherFormulaireConnexion",
            // "_controller" => [ControleurUtilisateur::class, "afficherFormulaireConnexion"],
        ]);
        $route->setMethods(["GET"]);
        $routes->add("afficherFormulaireConnexion", $route);

        // Route connecter
        $route = new Route("/connexion", [
            "_controller" => "\TheFeed\Controleur\ControleurUtilisateur::connecter",
        ]);
        $route->setMethods(["POST"]);
        $routes->add("connecter", $route);

        // Route deconnexion
        $route = new Route("/deconnexion", [
            "_controller" => "\TheFeed\Controleur\ControleurUtilisateur::deconnecter",
        ]);
        $route->setMethods(["GET"]);
        $routes->add("deconnecter", $route);

        // Route feedy
        $route = new Route("/feedy", [
            "_controller" => "\TheFeed\Controleur\ControleurPublication::submitFeedy",
        ]);
        $route->setMethods(["POST"]);
        $routes->add("submitFeedy", $route);

        // Route inscription
        $route = new Route("/inscription", [
            "_controller" => "\TheFeed\Controleur\ControleurUtilisateur::afficherFormulaireCreation",
        ]);
        $route->setMethods(["GET"]);
        $routes->add("afficherFormulaireCreation", $route);

        // Route crée inscription
        $route = new Route("/inscription", [
            "_controller" => "\TheFeed\Controleur\ControleurUtilisateur::creerDepuisFormulaire",
        ]);
        $route->setMethods(["POST"]);
        $routes->add("creerDepuisFormulaire", $route);

        // Route crée inscription
        $route = new Route("/utilisateur/{idUser}", [
            "_controller" => "\TheFeed\Controleur\ControleurUtilisateur::pagePerso",
        ]);
        $route->setMethods(["GET"]);
        $routes->add("pagePerso", $route);
    }
}