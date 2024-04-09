<?php
//le caller regroupe toute les données.
require('controller/Db.php');
require('controller/Error.php');
require('controller/Stat.php');
require('controller/Eleves.php');
require('controller/JointDescr.php');
// j'ai chois de remplir aléatoirement une liste d'eleve conforme au breve respective 
$listeEleve = array(
    ['eleve_id'  => 1, 'eleve_nom'  => "paul", "stat_id"  => 1],
    ['eleve_id'  => 2, 'eleve_nom' => "sarah", "stat_id" => 2],
    ['eleve_id'  => 3, 'eleve_nom' => "john", "stat_id"  => 3],
    ['eleve_id' => 4, 'eleve_nom'   => "maria", "stat_id" => 0],
    ['eleve_id' => 5, 'eleve_nom'   => "johnna", "stat_id" => 4],
);

$listeStat = array(
    'performanceN_1' => ['stat_id' => 1, 'stat_perf' => 30, 'sport_id' => 1],
    'performanceN_2' => ['stat_id' => 2, 'stat_perf' => 10, 'sport_id' => 3],
    'performanceN_3' => ['stat_id' => 3, 'stat_perf' => 18, 'sport_id' => 2],
    'performanceN_4' => ['stat_id' => 4, 'stat_perf' => 40, 'sport_id' => 1],
);
//vous remarquera que certaine sont 0 et d'autre son son des arrays cela et suportter grace a une methode qui identifie chaque cas de figure et procedes en fonction.

$listedescr = array(
    'description_paul' => ['id' => 1, 'eleve_id' => 1, 'ecole_id' => 1, 'sport_id' => [1, 2, 4]],
    'description_sarah' => ['id' => 2, 'eleve_id' => 2, 'ecole_id' => 2, 'sport_id' => 3],
    'description_john' => ['id' => 3, 'eleve_id' => 3, 'ecole_id' => 2, 'sport_id' => 3],
    'description_maria' => ['id' => 4, 'eleve_id' => 4, 'ecole_id' => 3, 'sport_id' => 0],
    'description_jonna' => ['id' => 5, 'eleve_id' => 5, 'ecole_id' => 3, 'sport_id' => 1]
);


//toute les breve son tester les une apres les autre (foreach array je fait une breve et en suite j'ajoute le contenue)
// vous remarquerait que eleveManager n'est pas d'embler tester en faite le test final comprend la method testing qui va tester toute les methods si elle son bonne et si elle ne son pas vide , mais si je ne remplit pas la base de donné au préalable il y aura toujour une erreur c'est pour cela que le le test à la fin .pour tester les erreur vous pouvez essayer en vidant les table (eleves,joint_table_all et stat) puis  de mettre en commentaire les ligne 44($eleveManager->addEleve($eleve);), 57($statManager->addStat($stat);), 69($descrManager->addDescr($descr);) die sera activer et juste le message d'erreur s'affichera.

foreach ($listeEleve as $value) {
    $eleveManager = new EleveManager;
    try {
        $eleve = new Eleve($value);
        var_dump($eleve);
        echo '<br>';
    } catch (Exception $e) {
        die($e->getMessage());
    }
    $eleveManager->addEleve($eleve);
};


foreach ($listeStat as $value) {
    $statManager = new statManager();
    try {
        $stat = new Stat($value);
        var_dump($stat);
        echo '<br>';
    } catch (Exception $e) {
        die($e->getMessage());
    }
    $statManager->addStat($stat);
}

foreach ($listedescr as $key => $value) {
    $descrManager = new JointDescrManager;
    try {
        $descr = new JointDescr($value);
        var_dump($descr);
        echo '<br>';
    } catch (Exception $e) {
        die($e->getMessage());
    }
    $descrManager->addDescr($descr);
}

try {
    $eleveManager = new EleveManager(true);
    echo '<br>';
} catch (Exception $e) {
    die($e->getMessage());
}
