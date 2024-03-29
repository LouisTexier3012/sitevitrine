<?php

namespace App\Anniversaire\Configuration;

use Exception;
use PDO;

class ConfigurationBDDPostgreSQL implements ConfigurationBDDInterface
{
    private string $nomBDD = "iut";
    private string $hostname = "webinfo.iutmontp.univ-montp2.fr"; //webinfo.iutmontp.univ-montp2.fr //"162.38.222.142"

    public function getLogin(): string
    {
        return "riosq";
    }

    public function getMotDePasse(): string
    {
        return "awdfaha0";
    }

    public function getDSN() : string{
        return "pgsql:host={$this->hostname};dbname={$this->nomBDD};options='--client_encoding=UTF8'";
    }

    public function getOptions() : array {
        return array();
    }
}
