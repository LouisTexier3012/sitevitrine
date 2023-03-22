<?php

namespace App\Anniversaire\Controller;


class ControllerMessage extends  GenericController{

    public static function ecrire(){
        self::afficheVue("message.html.twig");
    }

    public static function upload(){
        for ($i=1; $i<$_REQUEST["nbimg"]; $i++){
            $target_dir = "img/";
            $filetoyplode="fileToUpload".$i;
            $target_file = $target_dir . basename($_FILES[$filetoyplode]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Vérifie si le fichier est une image réelle ou une fausse image
            if (isset($_POST["submit"])) {
                $check = getimagesize($_FILES[$filetoyplode]["tmp_name"]);
                if ($check !== false) {
                    echo "Le fichier est une image - " . $check["mime"] . ".";
                } else {
                    echo "Le fichier n'est pas une image.";
                    $uploadOk = 0;
                }
            }

            // Vérifie si le fichier existe déjà
            if (file_exists($target_file)) {
                echo "Désolé, ce fichier existe déjà.";
                $uploadOk = 0;
            }

            // Vérifie la taille du fichier
            if ($_FILES["fileToUpload"]["size"] > 1000000000) {
                echo "Désolé, votre fichier est trop volumineux.";
                $uploadOk = 0;
            }

            // Autorise certains formats de fichier
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif") {
                echo "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
                $uploadOk = 0;
            }

            // Vérifie si $uploadOk est à 0 en raison d'une erreur
            if ($uploadOk == 0) {
                echo "Désolé, votre fichier n'a pas été téléchargé.";

                // Si tout est ok, on tente d'uploader le fichier
            } else {
                if (is_uploaded_file($_FILES[$filetoyplode]['tmp_name'])) {
                    if (move_uploaded_file($_FILES[$filetoyplode]["tmp_name"], $target_file)) {
                        echo "Le fichier " . htmlspecialchars(basename($_FILES[$filetoyplode]["name"])) . " a été téléchargé.";
                    } else {
                        echo "Désolé, une erreur s'est produite lors de l'upload de votre fichier.";
                    }
                } else {
                    echo "Attaque possible par téléchargement de fichier : ";
                    echo "Nom du fichier : '" . $_FILES['userfile']['tmp_name'] . "'.";
                }

            }
        }
    }
}