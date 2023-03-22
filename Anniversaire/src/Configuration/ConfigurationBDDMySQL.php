<?php

namespace App\Anniversaire\Configuration;

use PDO;

class ConfigurationBDDMySQL implements ConfigurationBDDInterface
{
    private string $login = "tnznwxolouis";
    private string $motDePasse = "Valnos3012";
    private string $nomBDD = "tnznwxolouis"; // Comme votre login
    private string $hostname = "tnznwxolouis.mysql.db";

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getMotDePasse(): string
    {
        return $this->motDePasse;
    }

    public function getDSN() : string{
        return "mysql:host={$this->hostname};dbname={$this->nomBDD}";
    }
    public function getOptions() : array {
        // Option pour que toutes les chaines de caractères
        // en entrée et sortie de MySql soit dans le codage UTF-8
        return array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        );
    }
}