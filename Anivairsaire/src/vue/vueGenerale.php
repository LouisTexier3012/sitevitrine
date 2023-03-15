<?php

use Aniv\Lib\ConnexionUtilisateur;
use Aniv\Lib\Conteneur;

/**
 * @var string $pagetitle
 * @var string $cheminVueBody
 * @var String[][] $messagesFlash
 */

$assistantUrl=Conteneur::recupererService("assistantUrl");
$generateurUrl=Conteneur::recupererService("generateurUrl");
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <title><?= $pagetitle ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href=" <?= $assistantUrl->getAbsoluteUrl("assets/css/styles.css"); ?>">
</head>

<body>
    <header>
        <div id="titre" class="center">
            <a href="<?= $generateurUrl->generate("feed"); ?> "><span>The Feed</span></a>
            <nav>
                <a href="<?= $generateurUrl->generate("feed"); ?>">Accueil</a>
                <?php
                if (!ConnexionUtilisateur::estConnecte()) {
                ?>
                    <a href=" <?= $generateurUrl->generate("afficherFormulaireCreation"); ?> ">Inscription</a>
                    <a href="<?= $generateurUrl->generate("afficherFormulaireConnexion"); ?>">Connexion</a>
                <?php
                } else {
                    $idUtilisateurURL = rawurlencode(ConnexionUtilisateur::getIdUtilisateurConnecte());
                ?>
                    <a href="<?= $generateurUrl->generate("pagePerso", array("idUser" => $idUtilisateurURL)); ?>">Ma
                        page</a>
                    <a href="<?= $generateurUrl->generate("deconnecter"); ?>">Déconnexion</a>
                <?php } ?>
            </nav>
        </div>
    </header>
    <div id="flashes-container">
        <?php
        foreach (["success", "error"] as $type) {
            foreach ($messagesFlash[$type] as $messageFlash) {
        ?>
                <span class="flashes flashes-<?= $type ?>"><?= $messageFlash ?></span>
        <?php
            }
        }
        ?>
    </div>
    <?php
    require __DIR__ . "/{$cheminVueBody}";
    ?>
</body>

</html>