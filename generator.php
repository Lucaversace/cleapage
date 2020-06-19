<?php
session_start();
require_once "bdd.php";
require_once "functions.php";

$spinTxt = $_POST['Spin'];
$KW = $_POST['KW'];
$nameSite = $_POST['sitename'];

$id_user = $_SESSION['ID'];

// Mise à jour de la date de la dernière génération de page
$lastGenerate = date('Y-m-d H:i:s');
$query = "UPDATE Users SET Last_generate = '".$lastGenerate."' WHERE ID = $id_user";
$stmt = $bdd->query($query, PDO::FETCH_ASSOC);

// Récupération de la date de la dernière génération de page et insertion dans la session
$query = "SELECT Last_generate FROM Users WHERE ID = $id_user";
$stmt = $bdd->query($query);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$_SESSION['Last_generate'] = $result['Last_generate'];

//délimiter les mots et mettre les mots clés en tableau
$keyWords = explode(" ", $KW);

// compter le nombre de mots clés
$nbWords = count($keyWords);
$i = 0;

// récupération du résultat de la fonction de spinning content 
while($i <= $nbWords)
{   
    echo "lol";
    $result = spin($spinTxt);
    $tab = [];
    array_push($tab,$result);
    $i++;
}
var_dump($tab);
echo $result;

//Création de la table du site pour enregistrer les spinnings content des pages

/* if ($res = $bdd->query("SHOW TABLES LIKE '".$nameSite."' ")->fetch()) 
{
        header("Location: index.php?err=exist");
}
else 
{
    echo "Table does not exist";
    $query = "CREATE TABLE $nameSite ( id INT NOT NULL AUTO_INCREMENT , content_spinning TEXT NOT NULL , PRIMARY KEY (`id`))";

    $stmt = $bdd->prepare($query);
    $stmt->execute([]);
    var_dump($stmt);
    header("Location: index.php");
}

 */


