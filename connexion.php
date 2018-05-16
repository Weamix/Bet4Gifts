<!DOCTYPE html>
<?php

  session_start(); //permet d'utiliser les variables de SESSION

  $bdd = new PDO('mysql:host=localhost;dbname=isnmpweb_espace_membre', 'isnprojet', 'O1cuz98@'); // On se connecte à la BDD

  if(isset($_POST['formconnexion'])) {

     $emailconnect = htmlspecialchars($_POST['emailconnect']);
     $passwordconnect = sha1($_POST['passwordconnect']);

     if(!empty( $emailconnect) AND !empty($passwordconnect)) {

        $requser = $bdd->prepare("SELECT * FROM membres WHERE email = ? AND password = ?");
        $requser->execute(array( $emailconnect, $passwordconnect));
        $userexist = $requser->rowCount();

        if($userexist == 1) {

           $userinfo = $requser->fetch();
           $_SESSION['id'] = $userinfo['id'];
           $_SESSION['pseudo'] = $userinfo['pseudo'];
           $_SESSION['mail'] = $userinfo['mail'];
           header("Location: profil.php?id=".$_SESSION['id']);

        }
        else {
           $error = "L'adresse email et le mot de passe ne correspondent pas !";
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
    <title>Bet4Gifts - Connexion</title>
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

    <h2>Sign in</h2>

    <hr>

    <form class="" action="" method="post">

      <label for="emailconnect"> Email : </label> <input type="email" name="emailconnect" value="" id="emailconnect" placeholder="Your email">
      <label for="passwordconnect"> Password :</label> <input type="password" name="passwordconnect" value="" id="passwordconnect" placeholder="Your password">
      <br>
      <input type="submit" name="formconnexion" value="Sign up">

      <span>No account ? <a href="inscription.php">Sign up!</a></span>
      <span>Forgotten password ? <a href="forgottenpassword.php">Change it !</a></span>

    </form>

    <?php
      if (isset($error) OR isset($_SESSION['error'])) {
        echo '<span class="errorMessage">'.$error.$_SESSION['error'].'</span>'; // On vérifie si la variable ERROR est SET , si OUI on affiche le message à l'utilisateur !
        $_SESSION["error"] = null;
      }

      if (isset($_SESSION['valid'])) {
        echo '<span class="accountCreatedMessage">'.$_SESSION['valid'].'</span>'; // On vérifie si la variable VALID est SET , si OUI on affiche le message à l'utilisateur !
        $_SESSION['valid'] = null;
      }
    ?>

     </div>



  </body>
</html>
