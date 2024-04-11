<?php

// breve classique avec verification sur erreur comme les autre breves.
class Eleve extends Stat
{
    protected $_id;
    protected $_eleve_name;
    protected $_stat_id;

    public function __construct(array $data)
    {
        $this->SetId($data['eleve_id']);
        $this->setName($data['eleve_nom']);
        $this->setStatId($data['stat_id']);
        if (!empty(parent::$error)) {
            throw new Exception(parent::$error . parent::ERROR_END_ELEVE);
        }
    }

    public function setName($eleve_name)
    {
        if (empty($eleve_name)) {
            $this->setError(parent::ERROR_EMPTY);
        } else {

            if (is_string($eleve_name)) {
                $this->_eleve_name = $eleve_name;
            } else {
                $this->setError(parent::ERROR_ELEVE);
            }
        }
    }

    public function setStatId($stat_id)
    {
        switch ($stat_id) {
            case 0:
                $this->_sport_id = null;
                break;
            case ($stat_id >= 1):
                $this->_stat_id = $stat_id;
                break;
            case '':
                $this->setError(parent::ERROR_EMPTY);
                break;
            default:
                $this->setError(parent::ERROR_STAT_ID_ELEVE);
        }
    }

    public function getName()
    {
        return $this->_eleve_name;
    }

    public function getStatEleves()
    {
        return $this->_stat_id;
    }
}
// la classe eleveMannager est particuliere parce que elle a un systeme de verication des method avec test en faite si je le desire je peux tester toutes les methode avec des parametre aléatoire si je fait par exemple 
// $eleveMG = new EleveManager(true) le test sera activer et je pourrait verifier :
// 1° si la methode ne me renvoit pas une erreur donc si c'est le cas exeception -> appel de la method sqlerrors. (vous pouver tester en modifiant la requete sql ).
// 2° verifie si le retour du sql n'est pas vide si c'est vide l'exeception est levé et les classe ne sont pas visible a la fin. chaque method revoie une requete sql precise qui permet d'afficher des demandes spécifique.


class EleveManager extends SqlErrors
{

    public function __construct($testActif = false)
    {
        if ($testActif) {
            $this->testing();
        }
        if (!empty(parent::$errorSQL)) {
            throw new Exception(parent::$errorSQL . " : " . parent::ERROR_END);
        }
    }

    public function testing()
    {
        try {
            $this->getEleve_desc(1);
            $this->getSportCount(1);
            $this->getCount(1);
            $this->getSportCountEleve(1);
        } catch (Exception) {
            $this->setErrorSQL(parent::ERROR_SQL_FALSE);
        }
    }

    public function getEleve_desc($id)
    {
        $sql = 'SELECT E.eleve_nom,JTA.sport_id,S.stat_perf,SP.sport_name,EL.ecole_name  FROM eleves AS E INNER JOIN joint_table_all AS JTA ON E.eleve_id = JTA.eleve_id INNER JOIN stat AS S ON S.stat_id = E.stat_id INNER JOIN  
        sports AS SP ON SP.sport_id = S.sport_id INNER JOIN ecoles AS EL ON EL.ecole_id = JTA.ecole_id  WHERE EL.ecole_id = :id
        ';
        $stmnt = Db::setting_db()->prepare($sql);
        $stmnt->bindParam(':id', $id);
        $stmnt->execute();
        while ($row = $stmnt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $row;
        }

        if (isset($result)) {
            return $result;
        } else {
            $this->setErrorSQL(parent::ERROR_SQL_EMPTY);
        }
    }

    public function getSportCount($id)
    {
        $sql = 'SELECT COUNT(*),sport_name FROM eleves AS E INNER JOIN joint_table_all AS JTA ON E.eleve_id = JTA.eleve_id INNER JOIN stat AS S ON S.stat_id = E.stat_id INNER JOIN  sports AS SP ON SP.sport_id = S.sport_id INNER JOIN ecoles AS EL ON
        EL.ecole_id = JTA.ecole_id  WHERE EL.ecole_id = :id GROUP BY sport_name ORDER BY COUNT(*) ASC';
        $stmnt = Db::setting_db()->prepare($sql);
        $stmnt->bindParam(':id', $id);
        $stmnt->execute();

        while ($row = $stmnt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $row;
        }
        if (isset($result)) {
            return $result;
        } else {
            $this->setErrorSQL(parent::ERROR_SQL_EMPTY);
        }
    }
    public function getSportCountEleve($id)
    {
        $sql = 'SELECT COUNT(*) FROM eleves AS E INNER JOIN joint_table_all AS JTA ON E.eleve_id = JTA.eleve_id INNER JOIN stat AS S ON S.stat_id = E.stat_id INNER JOIN  sports AS SP ON SP.sport_id = S.sport_id INNER JOIN ecoles AS EL ON 
        EL.ecole_id = JTA.ecole_id  WHERE EL.ecole_id = :id';
        $stmnt = Db::setting_db()->prepare($sql);
        $stmnt->bindParam(':id', $id);
        $stmnt->execute();
        $result = $stmnt->fetch();
        $value = $result['COUNT(*)'];

        if (isset($value)) {
            return $value;
        } else {
            $this->setErrorSQL(parent::ERROR_SQL_EMPTY);
        }
    }
    
    public function getcount($id)
    {
        $sql = 'SELECT COUNT(E.eleve_id) FROM eleves AS E INNER JOIN joint_table_all AS JTA ON E.eleve_id = JTA.eleve_id WHERE JTA.ecole_id = :id';
        $stmnt = Db::setting_db()->prepare($sql);
        $stmnt->bindParam(':id', $id);
        $stmnt->execute();
        $result = $stmnt->fetch();
        $value = $result['COUNT(E.eleve_id)'];

        if (isset($value)) {
            return $value;
        } else {
            $this->setErrorSQL(parent::ERROR_SQL_EMPTY);
        }
    }

    public function addEleve(Eleve $eleve)
    {
        if (is_null($eleve->getStatEleves())) {
            $sql = 'INSERT INTO eleves (eleve_nom) VALUE (:eleve_nom)';
            $stmnt = Db::setting_db()->prepare($sql);
            $eleve = htmlspecialchars($eleve->getName());
        } else {
            $sql = 'INSERT INTO eleves (eleve_nom,stat_id) VALUE (:eleve_nom,:stat_id)';
            $stmnt = Db::setting_db()->prepare($sql);
            $stat =  $eleve->getStatEleves();
            $eleve = htmlspecialchars($eleve->getName());
            $stmnt->bindParam(':stat_id', $stat);
        }
        $stmnt->bindParam(':eleve_nom', $eleve);
        $stmnt->execute();
    }
}
