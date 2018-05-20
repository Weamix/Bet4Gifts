<!DOCTYPE html>
<?php

  session_start(); //permet d'utiliser les variables de SESSION

  $bdd = new PDO('mysql:host=localhost;dbname=isnmpweb_espace_membre', 'isnprojet', 'O1cuz98@');

  if (isset($_POST['forminscription'])) { // On vérifie si le bouton SUBMIT du formulaire a été cliqué !

    $pseudo = htmlspecialchars($_POST['pseudo']); //On sécurise les variables
    $email = htmlspecialchars($_POST['email']);
    $confirmemail = htmlspecialchars($_POST['confirmemail']);
    $password = sha1($_POST['password']); // On crypte le mot de passe
    $confirmpassword = sha1($_POST['confirmpassword']);

    if (!empty($_POST['pseudo']) AND !empty($_POST['email']) AND !empty($_POST['confirmemail']) AND !empty($_POST['password']) AND !empty($_POST['confirmpassword'])) { //On vérifie que tous les champs sont spécifiés

      $pseudolength = strlen($pseudo);

      if ($pseudolength <= 255) { //On vérifie si le pseudo spécifié est inférieur ou egal à 255 caratères

        if ($email == $confirmemail) { //On vérifie que les deux mails sont identiques

          if(filter_var($email, FILTER_VALIDATE_EMAIL)){ //On vérifie que l'email est valide

            $reqemail = $bdd->prepare("SELECT * FROM membres WHERE email = ?"); //On prépare la requête SQL
            $reqemail->execute(array($email)); //On l'execute avec les bonnes valeurs
            $emailexist = $reqemail->rowCount(); // On regarde le nombre de ligne dans la BDD qui respecte les conditions de la requête

            $reqpseudo = $bdd->prepare("SELECT * FROM membres WHERE pseudo = ?");
            $reqpseudo->execute(array($pseudo));
            $pseudoexist = $reqpseudo->rowCount();

            if($pseudoexist == 0){ //On vérifie si le pseudo n'est pas déjà utilisé

              if($emailexist == 0){ //On vérifie si un compte n'existe pas déjà avec cette adresse mail

                if ($password == $confirmpassword) { //On vérifie si les deux MDP sont identiques

                    $lengthkey = 16; //On définie la taille de la clef
                    $key = ""; //On initialise la variable key

                    for ($i=0; $i<$lengthkey; $i++) {
                      $key.= mt_rand(0,9); //On génère 16 fois un nombre aléatoire entre 0 et 9 et on l'ajoute à la variable $key
                    }

                    $insertmembre = $bdd->prepare("INSERT INTO membres(pseudo, email, password, confirmkey) VALUES(?, ?, ?, ?)"); //On prépare la requête SQL
                    $insertmembre->execute(array($pseudo, $email, $password, $key)); //On l'execute avec les bonnes valeurs

                    $header="MIME-Version: 1.0\r\n"; //On définie le HEADER du mails
                    $header.='From:"Bet4Gifts"<noreply@bet4gifts.web-edu.fr>'."\n";
                    $header.='Content-Type:text/html; charset="uft-8"'."\n";
                    $header.='Content-Transfer-Encoding: 8bit';
                    $message='
                      <html>
                        <style>
                          @import url(\'https://fonts.googleapis.com/css?family=Lato\');
                        </style>
                         <body style="margin: 0; padding: 0; background-color:#2c3e50; font-family: \'Lato\', sans-serif;">
                            <br>
                            <div style="" align="center"><img src="https://bet4gifts.web-edu.fr/images/favicon.png" alt="" width="150" height="150"></div>
                            <br>
                            <hr style="width: 25%;">
                            <br>
                            <div align="center">
                              <span style="display: block; color: #FFF; font-size: 25px; font-weight: bold;">Your account was successfully created!</span>
                            </div>
                            <br>
                            <hr style="width: 25%;">
                            <br>
                            <div align="center">
                              <span style="display: block; color: #FFF; font-size: 20px;">Your account was successfully created!</span>
                              <span style="display: block; color: #FFF; font-size: 20px;">You are just one step to confirm your mail !</span>
                              <br>
                              <hr style="width: 25%;">
                              <br>
                            </div>
                            <div align="center">
                            <br>
                              <a style="background-color: #27ae60; border-radius: 20px; padding: 16px 18px; color: #FFF; text-decoration: none; font-size: 15px; text-transform: uppercase; font-weight: bold;" href="https://bet4gifts.web-edu.fr/confirmation.php?pseudo='.urlencode($pseudo).'&key='.$key.'">Click me !</a>
                            </div>
                            <br><br><br>
                         </body>
                      </html>
                    '; //On définit le message du mail
                    mail($email, "Confirm your account !", $message, $header); //On envoie un mail avec les informations précédements définies

                    $_SESSION['valid'] = "Your account has been created ! Look at your mails to confirm ! (and your spams)"; //On définit un message de validité
                    header("Location: connexion.php"); //On redirige l'utilisateur vers la page de connexion



                }

                else {
                  $error = "The passwords don't match !"; //On définit un message d'erreur
                }

              }else {
              $error = "This email adress is already taken ! ";
              }

            }else {
              $error = "This pseudo is already taken !";
            }

          }

          else {
            $error = "Your email adress is invalid !";
          }

        }



        else {
          $error = "The email addresses don't match !";
        }

      }

      else {

        $error = "Your pseudo is far too long ! (<255 characters)";

      }

    }

    else {

      $error = "Some fields are empty ! Please complete all fields !";

    }

  }

 ?>

<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Bet4Gifts - Sign up</title>
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

          <h2>Sign up</h2>

          <hr>

          <form class="" action="" method="post">

            <label for="pseudo"> Username :
                <input type="text" name="pseudo" value="<?php if(isset($pseudo)) {echo $pseudo;} ?>" id="pseudo" placeholder="Your Username">
            </label>


            <label for="email"> Email : </label>
              <input type="email" name="email" value="<?php if(isset($email)) {echo $email;} ?>" id="email" placeholder="Your Email">

            <label for="confirmemail"> Confirm email : </label>
              <input type="email" name="confirmemail" value="<?php if(isset($confirmemail)) {echo $confirmemail;} ?>" id="confirmemail" placeholder="Confirm email">

            <label for="password"> Password : </label>
            <input type="password" name="password" value="" id="password" placeholder="password">

            <label for="confirmpassword"> Confirm password : </label>
            <input type="password" name="confirmpassword" value="" id="confirmpassword" placeholder="Confirm password">

            <br>
            <input type="submit" name="forminscription" value="I join!">

            <span>You have already an account ? <a href="connexion.php">Sign in</a> !</span>

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

    </header>



  </body>
</html>
