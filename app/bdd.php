<?php 

try {
    $bdd = new PDO('mysql:host=localhost:3300;dbname=cleapage', 'root', 'root');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
  catch(exception $e) {
    die('Erreur '.$e->getMessage());
  }
