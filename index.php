<?php

  session_start();

  if (isset($_SESSION['id'])) {

    header("Location: profil.php?id=".$_SESSION['id']);

  }

 ?>

<!DOCTYPE html>
<html>
  <head lang="fr">
    <meta charset="utf-8">
    <title>Accueil</title>
    <link rel="stylesheet" href="style/style.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="icon" type="image/png" href="images/favicon.png" />
    <script type="text/javascript" src="script.js"></script>
  </head>
  <body onload="resizeHeaderHeight()">

      <header class="full-background" id="full-background">

          <ul class="navbar">
            <li> <a href="#">Home</a> </li>
            <li> <a href="#">About</a> </li>
            <li style="float:right;"> <a href="inscription.php">Sign up</a> </li>
            <li style="float:right;"> <a href="connexion.php">Sign in</a> </li>
          </ul>

          <div class="header_information">

              <h2>Bet4Gifts</h2>
              <hr>
              <p>ISN project in development on free sport forecasts: <br> accumulate points and win prizes! <br>Follow the evolution of the project on Twitter <a href="https://twitter.com/Bet4Gifts" target="_blank">@Bet4Gifts</a></p>

          </div>


      </header>

      <footer>

          <span>Project ISN, created by <a href="https://twitter.com/weamix">@Maxime</a>, <a href="https://twitter.com/N0bodys_">@Loic</a> and <a href="https://twitter.com/Elkios_">@Mathys</a> </span>

      </footer>


  </body>
</html>
