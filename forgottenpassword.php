<!DOCTYPE html>
<?php

  session_start(); //permet d'utiliser les variables de SESSION

  $bdd = new PDO('mysql:host=localhost;dbname=isnmpweb_espace_membre', 'isnprojet', 'O1cuz98@'); // On se connecte à la BDD

  if(isset($_POST['formforgottenpassword'])) { // On vérifie si le bouton SUBMIT du formulaire a été cliqué !

    $email = htmlspecialchars($_POST['email']); //On sécurise l'email de l'utilisateur
    $confirmemail = htmlspecialchars($_POST['confirmemail']);

    if (!empty($_POST['email'] and !empty($_POST['confirmemail']))) { // On vérifie que les champs sont remplis

      if ($email == $confirmemail) { // On vérifie que les deux emails sont identiques

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) { //On vérifie que que l'email entré par l'utilisateur est valide

          $reqemail = $bdd->prepare("SELECT * FROM membres WHERE email = ?"); //On prépare la requête SQL
          $reqemail->execute(array($email)); // On l'execute avec les bonnes variables
          $emailexist = $reqemail->rowCount(); // On regarde le nombre de ligne dans la BDD qui respecte les conditions de la requête
          $userinfo = $reqemail->fetch(); //Permet de récupérer les informations de la requête

          $key = htmlspecialchars($userinfo['confirmkey']); // on sécurise la variable key

          if ($emailexist == 1) { //On vérifie qu'il existe bien un compte avec cette adresse mail

            $header="MIME-Version: 1.0\r\n"; // On définit l'HEADER du mail
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
                      <span style="display: block; color: #FFF; font-size: 25px; font-weight: bold;">Forgotten password !</span>
                    </div>
                    <br>
                    <hr style="width: 25%;">
                    <br>
                    <div align="center">
                      <span style="display: block; color: #FFF; font-size: 20px;">Forgot your password ?</span>
                      <span style="display: block; color: #FFF; font-size: 20px;">Click on the button to change it !</span>
                      <br>
                      <hr style="width: 25%;">
                      <br>
                    </div>
                    <div align="center">
                    <br>
                      <a style="background-color: #27ae60; border-radius: 20px; padding: 16px 18px; color: #FFF; text-decoration: none; font-size: 15px; text-transform: uppercase; font-weight: bold;" href="https://bet4gifts.web-edu.fr/changepassword.php?email='.$email.'&key='.$key.'">Click me !</a>
                    </div>
                    <br><br><br>
                 </body>
              </html>
            '; // On définite le message du mail
            mail($email, "Forgotten password", $message, $header); //On envoie un mail avec les informations définies ci-dessus

            $valid = "An email you have been sent to change your password ! (Look at your mails and your spams)"; //On définit le message de validité

          }else {
            $error = "This email address doesn't exist !"; //On définit un message d'erreur
          }

        }else {
          $error = "Your email address is invalid !";
        }

      }else {
        $error = "The email addresses don't match !";
      }

    }else {
      $error = "Some fields are empty ! Please complete all fields !";
    }

  }

?>

<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Bet4Gifts - Forgotten password</title>
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

    <h2>Forgotten password</h2>

    <hr>

    <form class="" action="" method="post">

      <label for="emailconnect"> Email : </label> <input type="email" name="email" value="" id="emailconnect" placeholder="Your email">
      <label for="passwordconnect"> Confirm email :</label> <input type="email" name="confirmemail" value="" id="emailconnect" placeholder="Confirm email">
      <br>
      <input type="submit" name="formforgottenpassword" value="Send mail !">

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
