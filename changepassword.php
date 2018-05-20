<!DOCTYPE html>
<?php

  session_start(); //permet d'utiliser les variables de SESSION

  $bdd = new PDO('mysql:host=localhost;dbname=isnmpweb_espace_membre', 'isnprojet', 'O1cuz98@'); // On se connecte à la BDD

  if (isset($_POST['formchangepassword'])) { // On vérifie si le bouton SUBMIT du formulaire a été cliqué !

    if(isset($_GET['email'], $_GET['key']) AND !empty($_GET['email']) AND !empty($_GET['key'])) { //On vérifie si les informations de l'URL sont remplies

      $email = htmlspecialchars($_GET['email']); //On sécurise l'email
      $key = htmlspecialchars($_GET['key']); //On sécurise la clef associé à un utilisateur

      $reqemail = $bdd->prepare("SELECT * FROM membres WHERE email =  ?"); //On prépare la requête SQL
      $reqemail->execute(array($email)); // On l'execute avec les bonnes données
      $emailexist = $reqemail->rowCount(); // On regarde le nombre de ligne dans la BDD qui respecte les conditions de la requête
      $userinfo = $reqemail->fetch(); //Permet de récupérer les informations de la requête

      $newpassword = htmlspecialchars($_POST['newpassword']); //On sécurise le MDP
      $confirmnewpassword = htmlspecialchars($_POST['confirmnewpassword']); // idem

      $newpasswordcrypt = sha1($newpassword); //On crypte le nouveau MDP
      $lastpassword = $userinfo['password']; //On définie la variable $lastpassword sur le mot de passe oublié de l'utilisateur

      if ($emailexist == 1) {// On vérifie si un utilisateur avec cette email existe

          if ($newpassword == $confirmnewpassword) { // On vérifie si l'utilisateur a saisi deux fois le même mot de passe

            if ($newpasswordcrypt != $lastpassword) { // On vérifie que le nouveau mot de passe n'est pas le même que le précédent

              $updateuser = $bdd->prepare("UPDATE membres SET password = ? WHERE email = ? AND confirmkey = ?"); //On prépare la requete SQL
              $updateuser->execute(array($newpasswordcrypt,$email,$key)); // On l'éxécute avec les bonnes valeurs
              $valid = "Congratulations ! Your password have been changed !"; //On défini le message de validité

            }else {
              $error = "The new password can't be the same that the last password !"; // On défini le message d'erreur
            }

          }else {
            $error = "The passwords don't match !";
          }

      }else {
        $error = "This email address doesn't exist !";
      }

    }

  }

?>

<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Bet4Gifts - Change password</title>
    <link rel="icon" type="image/png" href="images/favicon.png" />
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/connexionstyle.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <script type="text/javascript" src="script.js"></script>
  </head>
  <body onload="resizeHeaderHeight()">

    <a href="index.php" class="logohome"> <img src="images/favicon.png" alt="" width="64" height="64"> </a>

    <header class="full-background" id="full-background">

    <div class="container_form_connexion">

    <h2>Change password</h2>

    <hr>

    <form class="" action="" method="post">

      <label for="emailconnect"> New password : </label> <input type="password" name="newpassword" value="" id="emailconnect" placeholder="New password">
      <label for="passwordconnect"> Confirm new password :</label> <input type="password" name="confirmnewpassword" value="" id="emailconnect" placeholder="Confirm new password">
      <br>
      <input type="submit" name="formchangepassword" value="Change password !">

    </form>

    <?php
      if (isset($error) OR isset($_SESSION['error'])) {
        echo '<span class="errorMessage">'.$error.$_SESSION['error'].'</span>'; // On vérifie si la variable ERROR est SET , si OUI on affiche le message à l'utilisateur !
        $_SESSION["error"] = null;
      }

      if (isset($_SESSION['valid']) or isset($valid)) {
        echo '<span class="accountCreatedMessage">'.$valid.$_SESSION['valid'].'</span>'; // On vérifie si la variable VALID est SET , si OUI on affiche le message à l'utilisateur !
        $_SESSION['valid'] = null;
      }
    ?>



  </body>
</html>
