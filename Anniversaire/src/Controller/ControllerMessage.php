<?php

namespace App\Anniversaire\Controller;


use App\Anniversaire\Modele\DataObject\Message;
use App\Anniversaire\Modele\Repository\MessageRepository;

class ControllerMessage extends  GenericController{

    public static function ecrire(){
        self::afficheVue("message.html.twig");
    }


    public static function upload(){
        echo "lalala";
        $lienimg = [];
        $nb =$_REQUEST["nb-img"];
        $target_dir = "img/message/";
        for ($i=1; $i<=$nb; $i++){
            $filetouplode="fileToUpload".$i;
            $target_file = $target_dir . basename($_FILES[$filetouplode]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Vérifie si le fichier est une image réelle ou une fausse image
            if (isset($_POST["submit"])) {
                $check = getimagesize($_FILES[$filetouplode]["tmp_name"]);
                if ($check !== false) {
                    echo "Le fichier est une image - " . $check["mime"] . ".";
                } else {
                    throw new \Exception("Le fichier n'est pas une image.");
                }
            }

            // Vérifie si le fichier existe déjà
            if (file_exists($target_file)) {
                throw new \Exception("Désolé, ce fichier existe déjà.");
            }

            // Vérifie la taille du fichier
            if ($_FILES[$filetouplode]["size"] > 1000000000) {
                throw new \Exception("Désolé, votre fichier est trop volumineux.");
            }

            // Autorise certains formats de fichier
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif") {
                throw new \Exception("Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.");
            }

            // Si tout est ok, on tente d'uploader le fichier
            if (is_uploaded_file($_FILES[$filetouplode]['tmp_name'])) {
                if (move_uploaded_file($_FILES[$filetouplode]["tmp_name"], $target_file)) {
                    echo "Le fichier " . htmlspecialchars(basename($_FILES[$filetouplode]["name"])) . " a été téléchargé.";
                    $lienimg[]= $target_file;
                } else {
                    throw new \Exception("Désolé, une erreur s'est produite lors de l'upload de votre fichier.");
                }
            } else {
                echo "Attaque possible par téléchargement de fichier : ";
                echo "Nom du fichier : '" . $_FILES['userfile']['tmp_name'] . "'.";
            }
        }

        $lien1 = $lienimg[0]? :"null";
        $lien2 = $lienimg[1]? :"null";
        $lien3 = $lienimg[2]? :"null";
        (new MessageRepository())->ajouter(Message::create($_REQUEST["message-principal"],$_REQUEST["signature"],$lien1,$lien2,$lien3));
        self::afficheVue("message.html.twig",[]);
    }
}
