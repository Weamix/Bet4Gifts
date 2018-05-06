<?php

  session_start();

  $bdd = new PDO('mysql:host=localhost;dbname=isnmpweb_espace_membre', 'isnprojet', 'O1cuz98@');

  /*if (isset($_GET['id'], $_GET['tone'], $_GET['ttwo']) AND $_GET['id'] > 0 AND !empty($_GET['tone']) AND !empty($_GET['ttwo'])) {

    echo "test";

  }else {
    header("Location: index.php");
  }*/

?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Bets</title>
    <link rel="icon" type="image/png" href="images/favicon.png" />
  </head>
  <body>

   <?php session_start(); if(isset($_SESSION['id'])) { ?>

      <form class="" action="test.php" method="post">

        <label for=""> Equipe 1
          <input type="hidden" name="teamone" value="TeamOne">
          <input type="checkbox" name="1">
        </label>
        <label for=""> Match Nul
          <input type="checkbox" name="0" value="equality">
        </label>
        <label for=""> Equipe 2
          <input type="hidden" name="teamtwo" value="TeamTwo">
          <input type="checkbox" name="2">
        </label>
        <label for=""> Montant :
          <input type="number" name="amount" value="1" min="1"> <input type="submit" name="formbets" value="Parier !">
        </label>

      </form>

    <?php}?>

  </body>
</html>
