<?php

use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Aniv\Lib\ConnexionUtilisateur;
use Aniv\Modele\DataObject\Publication;

/**
 * @var Publication[] $publications
 * @var UrlGenerator $generateurUrl
 * @var UrlHelper $assistantUrl
 */
?>
<main id="the-feed-main">
    <div id="feed">
        <?php
        if (ConnexionUtilisateur::estConnecte()) {
        ?>
            <form id="feedy-new" action="<?= $generateurUrl->generate("submitFeedy"); ?>" method="post">
                <fieldset>
                    <legend>Nouveau feedy</legend>
                    <div>
                        <textarea required id="message" minlength="1" maxlength="250" name="message" placeholder="Qu'avez-vous en tête?"></textarea>
                    </div>
                    <div>
                        <input id="feedy-new-submit" type="submit" value="Feeder!">
                    </div>
                </fieldset>
            </form>
            <?php
        }
        if (!empty($publications)) {
            foreach ($publications as $publication) {
                $loginHTML = htmlspecialchars($publication->getAuteur()->getLogin());
                $messageHTML = htmlspecialchars($publication->getMessage());
            ?>
                <div class="feedy">
                    <div class="feedy-header">
                        <a href="<?= $generateurUrl->generate("pagePerso", array("idUser" => $publication->getAuteur()->getIdUtilisateur())); ?>">
                            <img class="avatar" src="<?= $assistantUrl->getAbsoluteUrl("./assets/img/utilisateurs/".$publication->getAuteur()->getProfilePictureName()); ?>" alt="avatar de l'utilisateur">
                        </a>
                        <div class="feedy-info">
                            <span><?= $loginHTML ?></span>
                            <span> - </span>
                            <span><?= $publication->getDate()->format('d F Y') ?></span>
                            <p><?= $messageHTML ?></p>
                        </div>
                    </div>
                </div>
            <?php
            }
        } else {
            ?>
            <p id="no-publications" class="center">Pas de publications pour le moment!</p>
        <?php
        }
        ?>
    </div>
</main>