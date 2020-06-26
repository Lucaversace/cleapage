<?php 
session_start();
var_dump($_SESSION);
require_once "bdd.php";

if(isset($_POST['connexion'])) 
{ // si le bouton "Connexion" est appuyé
    // on vérifie que le champ "log" n'est pas vide
    // empty vérifie à la fois si le champ est vide et si le champ existe belle et bien (is set)
    if(empty($_POST['log'])) 
    {
        echo "Le champ Pseudo est vide.";
    } 
    else 
    {
        // on vérifie si le champ "Mot de passe" n'est pas vide"
        if(empty($_POST['pass'])) 
        {
            echo "Le champ Mot de passe est vide.";
        } 
        else 
        {
            // les champs sont bien posté et pas vide, on sécurise les données entrées
            $login = htmlentities($_POST['log'], ENT_QUOTES, "ISO-8859-1"); // le htmlentities() empêchera les injections SQL
            $password = htmlentities($_POST['pass'], ENT_QUOTES, "ISO-8859-1");
            //on vérifie que la connexion s'effectue correctement:
            if(!$bdd)
            {
                echo "Erreur de connexion à la base de données.";
            }
        
            else 
            {   
                $query = "SELECT * FROM Users WHERE Login = :login AND Password = :password";
                // on fait maintenant la requête dans la base de données pour rechercher si ces données existe et correspondent
                $stmt = $bdd->prepare($query);
                $stmt->execute([':login' => $login,':password' => $password]); 
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                var_dump($result);
                // Si oui , on créé une session et on redirige sur l'outil
                if($stmt)
                {
                    $id_user = (int)$result['ID'];
                    $_SESSION['Login'] = $result['Login'];
                    $_SESSION['ID'] = $id_user;
                    $_SESSION['status'] = "connected";
                    $lastConnexion = date('Y-m-d H:i:s');  // jour/mois/Année heure:minute:seconde

                    $query = "UPDATE Users SET Last_connexion = '".$lastConnexion."' WHERE ID = $id_user";
                    $stmt = $bdd->query($query, PDO::FETCH_ASSOC);

                    $query = "SELECT Last_connexion FROM Users WHERE ID = $id_user";
                    $stmt = $bdd->query($query);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    var_dump($result);
                    $_SESSION['Last_connexion'] = $result['Last_connexion'];

                    $query = "SELECT Last_generate FROM Users WHERE ID = $id_user";
                    $stmt = $bdd->query($query);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    $_SESSION['Last_generate'] = $result['Last_generate'];

                    header("Location: ../public/index.php");
                }
                // Sinon on indique un msg d'erreur
                else
                {
                    $errorlog = true;
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>Cléapage - Connexion</title>
</head>
<body>

<h1 class="text-center">Cléapage</h1>

<?php if(isset($errorlog)){?>
<div class="alert alert-danger " role="alert">
Login ou mot de passe incorrect
</div>
<?php } ?>

<form class="form-signin mx-auto w-25 mt-5" method="POST">


  <div class="form-label-group">
  <label for="inputEmail">Login</label>
    <input type="text" id="inputtext" name="log" class="form-control" required="" autofocus="">

  </div>

  <div class="form-label-group">
  <label for="inputPassword">Mot de passe</label>
    <input type="password" id="inputPassword" name="pass" class="form-control" required="">

  </div>
    <div class="form-group mt-3">
    <input name="connexion" class="btn btn-lg btn-primary btn-block" type="submit" value="Accéder à l'outil">

    </div>
</form>

</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</html>