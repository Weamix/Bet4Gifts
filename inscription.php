<!DOCTYPE html>
<?php

  session_start(); //permet d'utiliser les variables de SESSION

  $bdd = new PDO('mysql:host=localhost;dbname=isnmpweb_espace_membre', 'isnprojet', 'O1cuz98@'); // connexion à la BDD

  if (isset($_POST['forminscription'])) { // on vérifie si le bouton SUBMIT du formulaire a été cliqué

    $pseudo = htmlspecialchars($_POST['pseudo']); // on sécurise nos variables et on les simplifie
    $email = htmlspecialchars($_POST['email']);
    $confirmemail = htmlspecialchars($_POST['confirmemail']);
    $password = sha1($_POST['password']); // on crypte le mot de passe
    $confirmpassword = sha1($_POST['confirmpassword']);

    if (!empty($_POST['pseudo']) AND !empty($_POST['email']) AND !empty($_POST['confirmemail']) AND !empty($_POST['password']) AND !empty($_POST['confirmpassword'])) { //on vérifie si tous les champs ont bien été complétés (s'ils ne sont pas vides, ils doivent être différents de vide)

      $pseudolength = strlen($pseudo);

      if ($pseudolength <= 255) { // on vérifie si le pseudo spécifié est inférieur ou égal à 255 caratères

        if ($email == $confirmemail) { // on vérifie que les deux mails sont identiques

          if(filter_var($email, FILTER_VALIDATE_EMAIL)){ // on vérifie que l'email est sous une forme valide (@ et .com ; .fr ; etc )

            $reqemail = $bdd->prepare("SELECT * FROM membres WHERE email = ?"); // on prépare la requête SQL
            $reqemail->execute(array($email)); // on l'exécute avec les bonnes valeurs
            $emailexist = $reqemail->rowCount(); // on regarde le nombre de lignes dans la BDD qui respectent les conditions de la requête

            $reqpseudo = $bdd->prepare("SELECT * FROM membres WHERE pseudo = ?");
            $reqpseudo->execute(array($pseudo));
            $pseudoexist = $reqpseudo->rowCount();

            if($pseudoexist == 0){ // on vérifie si le pseudo n'est pas déjà utilisé 

              if($emailexist == 0){ // on vérifie si un compte n'existe pas déjà avec cette adresse mail

                if ($password == $confirmpassword) { // on vérifie si les deux MDP sont identiques

                    $lengthkey = 16; // on définit la taille de la clef
                    $key = ""; // on initialise la variable key

                    for ($i=0; $i<$lengthkey; $i++) {
                      $key.= mt_rand(0,9); // on génère 16 fois un nombre aléatoire entre 0 et 9 et on l'ajoute à la variable $key
                    }

                    $insertmembre = $bdd->prepare("INSERT INTO membres(pseudo, email, password, confirmkey) VALUES(?, ?, ?, ?)"); //on prépare la requête SQL
                    $insertmembre->execute(array($pseudo, $email, $password, $key)); //on l'exécute avec les bonnes valeurs (insertion du membre dans la BDD)

                    $header="MIME-Version: 1.0\r\n"; // on définit le HEADER du mail
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
                    '; // on définit le message du mail
                    mail($email, "Confirm your account !", $message, $header); // on envoie un mail avec les informations précédemment définies

                    $_SESSION['valid'] = "Your account has been created ! Look at your mails to confirm ! (and your spams)"; //on définit un message de validité
                    header("Location: connexion.php"); //on redirige l'utilisateur vers la page de connexion



                }

                else {
                  $error = "The passwords don't match !"; //on définit un message d'erreur
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

      $error = "Some fields are empty ! Please complete all fields !"; // on stocke l'erreur dans une variable

    }

  }

 ?>

<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Bet4Gifts - Create account</title>
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

          <h2>Create account</h2>

          <hr>

          <form class="" action="" method="post"> // test
            <label for="pseudo"> Username :
                <input type="text" name="pseudo" value="<?php if(isset($pseudo)) {echo $pseudo;} ?>" id="pseudo" placeholder="Your Username">
            </label>


            <label for="email"> Email : </label>
              <input type="email" name="email" value="<?php if(isset($email)) {echo $email;} ?>" id="email" placeholder="Your Email"> // élément HTML qui permet à l'utilisateur de rentrer des données dans une case

            <label for="confirmemail"> Confirm email : </label>
              <input type="email" name="confirmemail" value="<?php if(isset($confirmemail)) {echo $confirmemail;} ?>" id="confirmemail" placeholder="Confirm email">

            <label for="password"> Password : </label>
            <input type="password" name="password" value="" id="password" placeholder="password">

            <label for="confirmpassword"> Confirm password : </label>
            <input type="password" name="confirmpassword" value="" id="confirmpassword" placeholder="Confirm password">

            <br>
            <input type="submit" name="forminscription" value="Create your account!"> // bouton pour valider le formulaire

            <span>Already have an account? <a href="connexion.php">Sign in</a> !</span>

          </form>

          <?php
            if (isset($error) OR isset($_SESSION['error'])) { // message d'erreur si tous les champs ne sont pas complétés
              echo '<span class="errorMessage">'.$error.$_SESSION['error'].'</span>'; // on vérifie si la variable ERROR est SET , si OUI on affiche le message à l'utilisateur
              $_SESSION["error"] = null;
            }

            if (isset($_SESSION['valid'])) {
              echo '<span class="accountCreatedMessage">'.$_SESSION['valid'].'</span>'; // on vérifie si la variable VALID est SET , si OUI on affiche le message à l'utilisateur
              $_SESSION['valid'] = null;
            }
          ?>

      </div>

    </header>



  </body>
</html>
