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

                  $lengthkey = 16;
                  $key = "";

                  for ($i=1; $i<$lengthkey; $i++) {
                    $key.= mt_rand(0,9);
                  }

                  $insertmembre = $bdd->prepare("INSERT INTO membres(pseudo, email, password, confirmkey) VALUES(?, ?, ?, ?)");
                  $insertmembre->execute(array($pseudo, $email, $password, $key));

                  $header="MIME-Version: 1.0\r\n";
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
                          <br align="center">
                            <a style="background-color: #27ae60; border-radius: 20px; padding: 16px 18px; color: #FFF; text-decoration: none; font-size: 15px; text-transform: uppercase; font-weight: bold;" href="https://bet4gifts.web-edu.fr/confirmation.php?pseudo='.urlencode($pseudo).'&key='.$key.'">Click me !</a>
                          </div>
                          <br><br><br>
                       </body>
                    </html>
                  ';
                  mail($email, "Confirmation de compte", $message, $header);

                  $_SESSION['valid'] = "Your account has been created ! Look at your mails to confirm ! (and your spams)";
                  header("Location: connexion.php");



              }

              else {
                $error = "Les deux mots de passes ne correspondent pas !";
              }

            }

            else {

              $error = "Cette adresse email est déjà utilisé !";

            }

          }

          else {
            $error = "Votre adresse mail n'est pas valide !";
          }

        }



        else {
          $error = "Les deux adresses emails ne correspondent pas !";
        }

      }

      else {

        $error = "Votre pseudo est beaucoup trop long ! (<255 caractères)";

      }

    }

    else {

      $error = "Certains champs sont vides ! Veuillez tous les remplir !";

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
            if (isset($error)) {
          ?>
            <span class="errorMessage">
          <?php
            echo $error;
          ?>
            </span>
          <?php } ?>

      </div>

    </header>



  </body>
</html>
