<!DOCTYPE html>
<?php

  session_start();

  $bdd = new PDO('mysql:host=localhost;dbname=isnmpweb_espace_membre', 'isnprojet', 'O1cuz98@');

  if (isset($_POST['forminscription'])) {

    $pseudo = htmlspecialchars($_POST['pseudo']);
    $email = htmlspecialchars($_POST['email']);
    $confirmemail = htmlspecialchars($_POST['confirmemail']);
    $password = sha1($_POST['password']);
    $confirmpassword = sha1($_POST['confirmpassword']);

    if (!empty($_POST['pseudo']) AND !empty($_POST['email']) AND !empty($_POST['confirmemail']) AND !empty($_POST['password']) AND !empty($_POST['confirmpassword'])) {

      $pseudolength = strlen($pseudo);

      if ($pseudolength <= 255) {

        if ($email == $confirmemail) {

          if(filter_var($email, FILTER_VALIDATE_EMAIL)){

            $reqemail = $bdd->prepare("SELECT * FROM membres WHERE email = ?");
            $reqemail->execute(array($email));
            $emailexist = $reqemail->rowCount();

            if($emailexist == 0){

              if ($password == $confirmpassword) {

                  $insertmembre = $bdd->prepare("INSERT INTO membres(pseudo, email, password) VALUES(?, ?, ?)");
                  $insertmembre->execute(array($pseudo, $email, $password));
                  $_SESSION['accountcreated'] = "Your account has been created !";
                  header("Location: connexion.php");

              }

              else {
                $erreur = "Les deux mots de passes ne correspondent pas !";
              }

            }

            else {

              $erreur = "Cette adresse email est déjà utilisé !";

            }

          }

          else {
            $erreur = "Votre adresse mail n'est pas valide !";
          }

        }



        else {
          $erreur = "Les deux adresses emails ne correspondent pas !";
        }

      }

      else {

        $erreur = "Votre pseudo est beaucoup trop long ! (<255 caractères)";

      }

    }

    else {

      $erreur = "Certains champs sont vides ! Veuillez tous les remplir !";

    }

  }

 ?>

<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Bet4Gifts - Inscription</title>
    <link rel="icon" type="image/png" href="images/favicon.png" />
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/inscriptionstyle.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <script type="text/javascript" src="script.js"></script>
  </head>
  <body onload="resizeHeaderHeight()">

    <a href="index.php" class="logohome"> <img src="images/favicon.png" alt="" width="64" height="64"> </a>

    <header class="full-background" id="full-background">

      <div class="container_form_inscription">

          <h2>Inscription</h2>

          <hr>

          <form class="" action="" method="post">

            <label for="pseudo"> Pseudo :
                <input type="text" name="pseudo" value="<?php if(isset($pseudo)) {echo $pseudo;} ?>" id="pseudo" placeholder="Votre Pseudonyme">
            </label>


            <label for="email"> Email : </label>
              <input type="email" name="email" value="<?php if(isset($email)) {echo $email;} ?>" id="email" placeholder="Votre Email">

            <label for="confirmemail"> Confirmation de votre Email : </label>
              <input type="email" name="confirmemail" value="<?php if(isset($confirmemail)) {echo $confirmemail;} ?>" id="confirmemail" placeholder="Confirmez votre Email">

            <label for="password"> Mot de Passe : </label>
            <input type="password" name="password" value="" id="password" placeholder="Votre Mot de Passe">

            <label for="confirmpassword"> Confirmation de votre mot de passe : </label>
            <input type="password" name="confirmpassword" value="" id="confirmpassword" placeholder="Confirmez votre MDP">

            <br>
            <input type="submit" name="forminscription" value="Je m'inscris">

            <span>Déjà un compte ? <a href="connexion.php">Connecte-toi</a> !</span>

          </form>

          <?php
            if (isset($erreur)) {
          ?>
            <span class="errorMessage">
          <?php
            echo $erreur;
          ?>
            </span>
          <?php } ?>

      </div>

    </header>



  </body>
</html>
