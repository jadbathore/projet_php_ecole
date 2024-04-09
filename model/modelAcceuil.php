<?php require('controller/caller.php') ?>
 <!-- model visible que si elle passe le test du caller  ici est montre le nombre de personne dans l'ecole , une liste montrant le nombre de personne partiquant au moins 1 sport une liste detailler des eleve avec leurs stat (qui on une perf avec le sport relier a cette perf j'ai fait un systme de point mais cette collone peux etre aisaiment changer en text pour par exemple : il a fait telle exploit blabla) en desous il y a le nombre de partiquant par sport comme demander sur l'exercice-->

<?php for ($i = 1; $i <= 3; $i++) : ?>
    <h1>ecole <?php echo  $i ?></h1>
    <h2>information de l'ecole : </h2>
    <p>nombre des eleves dans l'ecole : <?php echo $eleveManager->getcount($i) ?></p>
    <p>nombre des eleves dans l'ecole : <?php echo $eleveManager->getSportCountEleve($i) ?></p>
    <h3>description complete des eleves partiquant au moins 1 sport : </h3>
    <ul>
        <?php foreach ($eleveManager->getEleve_desc($i) as $value) : ?>
            <li>
                <p> l'eleve :<?php echo $value['eleve_nom'] ?></p>
                <p>c'est statisque en <?php echo $value['sport_name'] ?> sont de <?php echo $value['stat_perf'] ?> point.</p>
            </li>
        <?php endforeach ?>
        <li>
            <h3>nombre de pratiquant par sport : </h3>
            <?php foreach ($eleveManager->getSportCount($i) as $value) : ?>
                <p> sport : <?php echo $value['sport_name'] ?> , nombre de pratiquant <?php echo $value['COUNT(*)'] ?></p>
            <?php endforeach; ?>
        </li>
    </ul>
<?php endfor ?>