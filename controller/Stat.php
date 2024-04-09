<?php
// breve Stat qui permet d'ajouter les statisiques tout en verifiant les donner. extend de Errors qui est une class qui permet de stocker les message d'erreur

class Stat extends Errors
{
    protected $_id;
    protected $_stat;
    protected $_sport_id;

    public function __construct(array $data)
    {

        $this->SetId($data['stat_id']);
        $this->setstat($data['stat_perf']);
        $this->setSportId($data['sport_id']);

        if (!empty(parent::$error)) {
            throw new Exception(parent::$error . ' : ' . parent::ERROR_END_STAT);
        }
    }

    public function setId($id)
    {

        if (empty($id)) {
            $this->setError(parent::ERROR_EMPTY);
        } else {
            if (is_numeric($id)) {
                $this->_id = $id;
            } else {
                $this->setError(parent::ERROR_ID);
            }
        }
    }

    public function setstat($stat)
    {

        if (empty($stat)) {
            $this->setError(parent::ERROR_EMPTY);
        } else {
            if (is_numeric($stat)) {
                $this->_stat = $stat;
            } else {
                $this->setError(parent::ERROR_ID);
            }
        }
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getstat()
    {
        return $this->_stat;
    }

    public function setSportId($sport_id)
    {
        switch ($sport_id) {
            case ($sport_id >= 1 && $sport_id <= 5):
                $this->_sport_id = $sport_id;
                break;
            case '':
                $this->setError(parent::ERROR_EMPTY);
                break;
            default:
                $this->setError(parent::ERROR_SPORT_ID);
        }
    }
    public function getSportId()
    {
        return $this->_sport_id;
    }
}


class statManager
{
    public function addStat(Stat $stat)
    {
        $sql = 'INSERT INTO stat (stat_perf,sport_id) VALUES (:stat_perf,:sport_id)';
        $stat_perf = $stat->getstat();
        $sport_id = $stat->getSportId();
        $stmnt = Db::setting_db()->prepare($sql);
        $stmnt->bindParam(':stat_perf', $stat_perf);
        $stmnt->bindParam(':sport_id', $sport_id);
        $stmnt->execute();
    }
}
