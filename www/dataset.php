<?php
const DB_SERVER = "localhost";
const DB_NAME = "basesondage";
const DB_USER = "root";
const DB_PWD = "";
//création d'un object connexion 
$link = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USER, DB_PWD);
//définit le charset pour les échanges de données avec le serveur de BDD
$link->exec("SET CHARACTER SET UTF8");
//Définit le mode de la méthode fetch par défaut
$link->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
//déclenche une exception en cas d'erreur : stop l'éxécution
$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//réinit BDD
$sql = file_get_contents("../creation_base_sondage.sql");
//echo "<pre>$sql</pre>";
$link->setAttribute(PDO::ATTR_EMULATE_PREPARES, 0);
$link->exec($sql);

//generation des données
$nbs = 3; //nombre de sondage
$nbq = 10; //nombre de question par sondage
$nbrp = 3; //nombre de réponse possible par question
$nbvisiteur = 100;

echo "<h3>création des sondages</h3>";
$data = [];
$sql = "insert into sondage values ";
for ($i = 1; $i <= $nbs; $i++) {
    $texte = "sondage n°$i";
    $debut = "2019-11-19";
    $fin = "2019-12-19";
    $data[] = "(null,'$texte','$debut','$fin')";
}
$link->query($sql . implode(",", $data));


echo "<h3>création des question</h3>";
$data = [];
$sql = "insert into question values ";
for ($i = 1; $i <= $nbs; $i++) {
    for ($j = 1; $j <= $nbq; $j++) {
        $texte = "question n°$j au sondage n°$i";
        $data[] = "(null,'$texte',$i)";
    }
}
$link->query($sql . implode(",", $data));

echo "<h3>création des réponses possibles</h3>";
$data = [];
//sélection des questions
$sql = "select * from question";
$questions = $link->query($sql)->fetchAll();

$sql = "insert into reponse_possible values ";
foreach ($questions as $question) {
    extract($question);
    for ($j = 1; $j <= $nbrp; $j++) {
        $texte = "réponse n°$j à la question n°$que_id (sondage n°$que_sondage)";
        $data[] = "(null,'$texte',$que_id)";
    }
}
$link->query($sql . implode(",", $data));

echo "<h3>création des visiteurs</h3>";
$data = [];
$sql = "insert into visiteur values ";
for ($i = 1; $i <= $nbvisiteur; $i++) {
    $ip = rand(0, 255) . "." . rand(0, 255) . "." . rand(0, 255);
    $data[] = "(null,'$ip')";
}
$link->query($sql . implode(",", $data));


var_dump($requette);
extract($row);



echo "<h3>création des choix</h3>";
$data = [];
$sql = "insert into choix values ";
for ($i = 1; $i <= $nbvisiteur; $i++) {
    for ($j = 1; $j <= $nbq; $j++) {
        $row = $link->query("select* from reponse_possible ")->fetchall();
        $requette = [];
        foreach ($row as $indice => $ligne) {
            if ($ligne["rep_question"] == $j) {
                $requette[] = $ligne;
            }
        }
        foreach ($requette as $valeur)
            $data[] = "(null,'$i','$valeur','$j')";
    }
}
$link->query($sql . implode(",", $data));
