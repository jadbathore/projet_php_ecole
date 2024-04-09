<?php
//methode statique qui permet la connection mais aussi de passer des paramètre pour changer la base de donner 


class Db
{

    static function setting_db(

        string $pdoName = '',
        string $pdoUserName = '',
        string $pdoPassword = '',
    ) {

        if (empty($pdoName) and empty($pdoUserName) and empty($pdoPassword)) {
            try {
                $setting = new PDO("mysql:host=localhost;dbname=ecole", 'root', 'root');
            } catch (Exception $e) {
                $message = $e->getMessage();
                echo "erreur de la base de donnée : $message ";
            }
        } else {

            try {
                $setting = new PDO($pdoName, $pdoUserName, $pdoPassword);
            } catch (Exception $e) {
                $message = $e->getMessage();
                echo "erreur de la base de donnée : $message";
            }
        }

        if (isset($setting)) {
            return $setting;
        }
    }
}
