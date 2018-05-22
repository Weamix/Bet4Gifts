<!DOCTYPE html>
<?php

  session_start(); //permet d'utiliser les variables de SESSION

  $bdd = new PDO('mysql:host=localhost;dbname=isnmpweb_espace_membre', 'isnprojet', 'O1cuz98@'); // On se connecte à la BDD

  if(isset($_POST['formconnexion'])) { // On vérifie si le bouton SUBMIT du formulaire a été cliqué

     $emailconnect = htmlspecialchars($_POST['emailconnect']); //On sécurise l'email de l'utilisateur
     $passwordconnect = sha1($_POST['passwordconnect']); //On crypte le mot de passe

     if(!empty( $emailconnect) AND !empty($passwordconnect)) { // On vérifie si l'email et le mot de passe sont spécifiés

        $requser = $bdd->prepare("SELECT * FROM membres WHERE email = ? AND password = ?"); //On prépare la requête SQL
        $requser->execute(array( $emailconnect, $passwordconnect)); // On l'execute avec les bonnes variables
        $userexist = $requser->rowCount(); // On regarde le nombre de lignes dans la BDD qui respectent les conditions de la requête

        if($userexist == 1) { // On vérifie si l'utilisateur existe

           $userinfo = $requser->fetch();//Permet de récupérer les informations de la requête
           $_SESSION['id'] = $userinfo['id']; //On définit l'identifiant de la SESSION
           $_SESSION['pseudo'] = $userinfo['pseudo']; //On définit le pseudo de l'utilisateur associé à la SESSION
           $_SESSION['mail'] = $userinfo['mail']; //On définit le mail de l'utilisateur associé à la SESSION
           header("Location: profil.php?id=".$_SESSION['id']); // On redirige l'utilisateur vers sa page de profil

        }
        else {
           $error = "L'adresse email et le mot de passe ne correspondent pas !"; //On définit le message de l'erreur
        }
     }
     else {
        $error = "Tous les champs doivent être complétés !";
     }
  }

?>

<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Bet4Gifts - Login</title>
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

    <h2>Login</h2>

    <hr>

    <form class="" action="" method="post">

      <label for="emailconnect"> Email Address : </label> <input type="email" name="emailconnect" value="" id="emailconnect" placeholder="Your email">
      <label for="passwordconnect"> Password :</label> <input type="password" name="passwordconnect" value="" id="passwordconnect" placeholder="Your password">
      <br>
      <input type="submit" name="formconnexion" value="LOG IN">

      <span>Don't have an account? <a href="inscription.php">Create an account</a></span>
      <span>Forgot your password? <a href="forgottenpassword.php">Reset password</a></span>

    </form>

    <?php
      if (isset($error) OR isset($_SESSION['error'])) {
        echo '<span class="errorMessage">'.$error.$_SESSION['error'].'</span>'; // On vérifie si la variable ERROR est SET, 
                                                                               // si OUI on affiche le message à l'utilisateur
        $_SESSION["error"] = null;
      }

      if (isset($_SESSION['valid'])) {
        echo '<span class="accountCreatedMessage">'.$_SESSION['valid'].'</span>'; // On vérifie si la variable VALID est SET, 
                                                                                 // si OUI on affiche le message à l'utilisateur
        $_SESSION['valid'] = null;
      }
    ?>

     </div>



  </body>
</html>
