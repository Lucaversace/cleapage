<?php 
session_start();

// Si la session est vide on redirige sur la page de connexion
if(empty($_SESSION))
{
    header('Location: signin.php');
}

// Récupération des dernières dates de génération et de connexion depuis la session
$brutLastConnexion = $_SESSION['Last_connexion'];
$lastConnexion = date('d-m-Y H:i:s', strtotime($brutLastConnexion));
$brutLastGenerate = $_SESSION['Last_generate'];
$lastGenerate = date('d-m-Y H:i:s', strtotime($brutLastGenerate));
 ?>

<!DOCTYPE html>
<html lang="fr">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.0.1">
    <title>Cléapage - Tool</title>

    <!-- Bootstrap core CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- Favicons -->

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }
      body{
          padding-top: 5rem;
      }
      .bouton{
          border-radius: 2rem;
      }


      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="style.css" rel="stylesheet">
  </head>
  
  <body>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="index.php">Cléapage</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Déconnexion</a>
      </li>
    </ul>
  </div>
</nav>

<main role="main" class="container">

    <div>
        <h1 class="text-center">Outils de Générateur de pages</h1>
        
    </div>
    <div class="alert alert-info">
        <b>Utilisation du spinning content :</b> Les mots qui doivent se remplacer doivent être entouré d'accolades et séparés par une barre verticale.<br>
        Exemple : {je|tu} {mange|dévore} une {pomme|fraise}.
    </div>
    <?php if($_SERVER['QUERY_STRING'] == "err=exist"){?>
        <div class="alert alert-danger">
            Ce site existe déjà !
        </div>
    <?php } ?>
    <div class="w-100 mx-auto mt-5">

        <!-- Formulaire -->
        <form class="bg-light p-5 formulaire rounded-top" action="generator.php" method="POST">
            <div class="row">
            <div class="form-group col-3">
                    <label class="text-center" for="site">Entrez le nom du site</label>
                    <input type="text" class="form-control" name="sitename" required>
                </div>
            </div>
            <div class="row text-center d-flex justify-content-center">
                <div class="form-group col-6">
                    <label class="text-center" for="containspin">Entrez le contenu spin</label>
                    <textarea name="Spin" class="form-control" id="containspin" rows="3" required></textarea>
                </div>
                <div class="form-group col-6">
                    <label class="text-center" for="keywords">Entrez les mots clés</label>
                    <textarea name="KW" class="form-control" id="keywords" rows="3" required></textarea>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <button class="btn btn-primary bouton">Similarité du spin</button>
                <input type="submit" class="btn btn-primary bouton" value="Générer les pages">
                <button class="btn btn-primary bouton">Télécharger les pages</button>
            </div>
        </form>
    </div>
    <div class="container bg-warning p-4 rounded-bottom">
        <div class="row">
            <div>
                <p>Dernière connexion  : <?php echo $lastConnexion; ?></p>
            </div>
        </div>
        <div class="row">
            <div>
                <p>Dernière génération de pages  : <?php echo $lastGenerate; ?></p>
            </div>
        </div>
    </div>

</main>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</body>
</html>
