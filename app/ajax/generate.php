<?php 

session_start();
require_once "../bdd.php";
require_once "../functions.php";

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

// récupération du résultat de la fonction de spinning content 
$tab = [];
$i = 0;
while($i <= $nbWords-1)
{   
    $result = spinNotRandom($spinTxt);
    array_push($tab,$result);
    $i++;
}
if(!is_dir("../../download/$nameSite")){
    mkdir("../../download/$nameSite", 0777, true);
}
foreach ($tab as $key => $value) {
    $fichier = fopen("fichier$key", "c+b");
    fwrite($fichier, $value);
    copy("fichier$key", "../../download/$nameSite/fichier$key");
    unlink("fichier$key");
}
$i = 0;
$pathDownload = "../../download/";
$pathFiles = "../../download/$nameSite";

$nbFiles = countFiles($pathFiles) - 2;
echo "Nombres de fichiers : $nbFiles <br>";

$zip = new ZipArchive();
$zip->open("$pathDownload/$nameSite/$nameSite.zip", ZipArchive::CREATE);
while($i != $nbFiles){
    $zip->addFile("$pathFiles/fichier$i");
    $i++;
}

$zip->close();


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


