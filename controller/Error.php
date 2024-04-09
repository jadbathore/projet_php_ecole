<?php
// permet de stockes les message d'erreur plus proprement 
class Errors
{

    static protected $error;

    const ERROR_ID = "ID erreur id doit etre un nombre";
    const ERROR_STAT = "ID erreur id doit etre un nombre";
    const ERROR_EMPTY = "une ou plusieur valeur sont vide";
    const ERROR_END_STAT = ' la statistique ne peux pas etre enregisté';
    const ERROR_END_ELEVE = ' l\'eleve ne peux pas etre enregisté';
    const ERROR_END_DESC = ' la description ne peux pas etre enregisté';
    const ERROR_ELEVE = "erreur, nom doit etre un nombre";
    const ERROR_ELEVE_ID = "erreur eleve_id doit etre un nombre";
    const ERROR_ECOLE_ID = "erreur ecole_id doit etre un nombre compris entre 1 et 3";
    const ERROR_SPORT_ID = "erreur sport_id doit etre soit null soit un nombre compris entre 1 et 5";
    const ERROR_STAT_ID = "erreur stat_id doit etre un nombre";
    const ERROR_STAT_ID_ELEVE = "erreur sport_id doit etre soit null soit un nombre superieur à 1";
    const ERROR_SPORT_ID_LENTGH = "erreur l'eleve ne doit pas pratiquer plus de 3 sport à la fois";


    public function setError($message)
    {
        self::$error = $message;
    }
}

class SqlErrors
{
    static protected $errorSQL;

    const ERROR_SQL_EMPTY = "les donnner retourner sont vide";
    const ERROR_SQL_FALSE = "les donnner retourner sont eronnée";
    const ERROR_END = "la requête n'a pas aboutit";

    public function setErrorSQL($message)
    {
        self::$errorSQL = $message;
    }
}
