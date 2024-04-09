<?php
//  la descr est la breve qui permet de remplir la table de jointure joint_table_all et etant de la class extend parce que elle aura par la suite les propriète de la class error et en plus la method setId dont je n'aurai pas a re ecrire le code.

class JointDescr extends stat
{
    protected $_id;
    protected $_eleve_id;
    protected $_ecole_id;
    protected $_sport_id;
    protected $_stat_id;

    public function __construct(array $data)
    {
        $this->setId($data['id']);
        $this->setEleveId($data['eleve_id']);
        $this->setEcoleId($data['ecole_id']);
        $this->setSportId($data['sport_id']);

        if (!empty(parent::$error)) {
            throw new Exception(parent::$error . ' : ' . parent::ERROR_END_DESC);
        }
    }

    public function setEleveId($eleve_id)
    {
        if (empty($eleve_id)) {
            $this->setError(parent::ERROR_EMPTY);
        } else {
            if (is_numeric($eleve_id)) {
                $this->_eleve_id = $eleve_id;
            } else {
                $this->setError(parent::ERROR_ELEVE_ID);
            }
        }
    }

    public function setEcoleId($ecole_id)
    {
        if (empty($ecole_id)) {
            $this->setError(parent::ERROR_EMPTY);
        } else {

            if (is_numeric($ecole_id) && ($ecole_id >= 1 && $ecole_id <= 3)) {
                $this->_ecole_id = $ecole_id;
            } else {
                $this->setError(parent::ERROR_ECOLE_ID);
            }
        }
    }

    public function setStatId($stat_id)
    {
        if (empty($stat_id)) {
            $this->setError(parent::ERROR_EMPTY);
        } else {
            if (is_numeric($stat_id)) {
                $this->_stat_id = $stat_id;
            } else {
                $this->setError(parent::ERROR_STAT_ID);
            }
        }
    }

// method setSportID utilise le switch qui quand c'est c'est 0 = null quand c'est une array il y a verification et ce n'est pas possible d'avoir plus de 3 sport en meme tant dans cette arrays,et quand c'est juste un nombre ca le prend aussi 
    public function setSportId($sport_id)
    {
        switch ($sport_id) {
            case 0:
                $this->_sport_id = null;
                break;
            case ($sport_id >= 1 && $sport_id <= 5):
                $this->_sport_id = $sport_id;
                break;
            case is_array($sport_id):
                if (count($sport_id) > 3) {
                    $this->setError(parent::ERROR_SPORT_ID_LENTGH);
                } else {
                    $this->_sport_id = $sport_id;
                }
                break;
            case '':
                $this->setError(parent::ERROR_EMPTY);
                break;
            default:
                $this->setError(parent::ERROR_SPORT_ID);
        }
    }



    public function getEleveId()
    {
        return $this->_eleve_id;
    }
    public function getEcoleId()
    {
        return $this->_ecole_id;
    }
    public function getSportId()
    {
        return $this->_sport_id;
    }
    public function getStatId()
    {
        return $this->_stat_id;
    }
}

//quand une arrays et envoyer elle est serialize pour que elle puisse rentre dans la base sql et puisse etre unserialize si besoin par la suite 
class JointDescrManager
{
    public function addDescr(JointDescr $joint)
    {
        if (is_null($joint->getSportId())) {
            $sql = 'INSERT INTO joint_table_all (eleve_id,ecole_id) VALUES (:eleve_id,:ecole_id)';
            $stmnt = Db::setting_db()->prepare($sql);
            $eleveId = $joint->getEleveId();
            $ecoleId = $joint->getEcoleId();
            $stmnt->bindParam(':eleve_id', $eleveId);
            $stmnt->bindParam(':ecole_id', $ecoleId);
        } elseif (is_array($joint->getSportId())) {
            $sql = 'INSERT INTO joint_table_all (eleve_id,ecole_id,sport_id) VALUES (:eleve_id,:ecole_id,:sport_id)';
            $stmnt = Db::setting_db()->prepare($sql);
            $eleveId = $joint->getEleveId();
            $ecoleId = $joint->getEcoleId();
            $sportId = $joint->getSportId();
            $sportIdSerialize = htmlspecialchars(serialize($sportId));
            $stmnt->bindParam(':eleve_id', $eleveId);
            $stmnt->bindParam(':ecole_id', $ecoleId);
            $stmnt->bindParam(':sport_id', $sportIdSerialize);
        } else {
            $sql = 'INSERT INTO joint_table_all (eleve_id,ecole_id,sport_id) VALUES (:eleve_id,:ecole_id,:sport_id)';
            $stmnt = Db::setting_db()->prepare($sql);
            $eleveId = $joint->getEleveId();
            $ecoleId = $joint->getEcoleId();
            $sportId = $joint->getSportId();
            $stmnt->bindParam(':eleve_id', $eleveId);
            $stmnt->bindParam(':ecole_id', $ecoleId);
            $stmnt->bindParam(':sport_id', $sportId);
        }
        $stmnt->execute();
    }
}
