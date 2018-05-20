<?php

  session_start(); //permet d'utiliser les variables de SESSION
  $_SESSION = array(); //On défini toutes les variables de session de l'utilisateur sur NULL
  session_destroy(); //On détruit la SESSION
  header("Location: connexion.php"); //On redirige l'utilisateur vers la page de connexion

 ?>
