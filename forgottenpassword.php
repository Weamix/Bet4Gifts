<!DOCTYPE html>
<?php

  session_start();

  $bdd = new PDO('mysql:host=localhost;dbname=isnmpweb_espace_membre', 'isnprojet', 'O1cuz98@');

  if(isset($_POST['formforgottenpassword'])) {

    $email = htmlspecialchars($_POST['email']);
    $confirmemail = htmlspecialchars($_POST['confirmemail']);

    if (!empty($_POST['email'] and !empty($_POST['confirmemail']))) {

      if ($email == $confirmemail) {

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

          $reqemail = $bdd->prepare("SELECT * FROM membres WHERE email = ?");
          $reqemail->execute(array($email));
          $emailexist = $reqemail->rowCount();
          $userinfo = $reqemail->fetch();

          $key = htmlspecialchars($userinfo['confirmkey']);

          if ($emailexist == 1) {

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
                      <span style="display: block; color: #FFF; font-size: 25px; font-weight: bold;">Forgotten password !</span>
                    </div>
                    <br>
                    <hr style="width: 25%;">
                    <br>
                    <div align="center">
                      <span style="display: block; color: #FFF; font-size: 20px;">"Forgot your password ?</span>
                      <span style="display: block; color: #FFF; font-size: 20px;">Click on the button to change it !</span>
                      <br>
                      <hr style="width: 25%;">
                      <br>
                    </div>
                    <div align="center">
                    <br>
                      <a style="background-color: #27ae60; border-radius: 20px; padding: 16px 18px; color: #FFF; text-decoration: none; font-size: 15px; text-transform: uppercase; font-weight: bold;" href="https://bet4gifts.web-edu.fr/confirmation.php?email='.urlencode($pseudo).'&key='.$key.'">Click me !</a>
                    </div>
                    <br><br><br>
                 </body>
              </html>
            ';
            mail($email, "Forgotten password", $message, $header);

            $_SESSION['valid'] = "Your account has been created ! Look at your mails to confirm ! (and your spams)";

          }else {
            $error = "This email adress doesn't exist !";
          }

        }else {
          $error = "Your email adress is invalid !";
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
      <label for="passwordconnect"> Confirm email :</label> <input type="email" name="confirmemail" value="" id="emailconnect" placeholder="Cofnirm email">
      <br>
      <input type="submit" name="formforgottenpassword" value="Send mail !">

    </form>

    <?php
      if (isset($error) OR isset($_SESSION['error'])) {
    ?>
      <span class="errorMessage">
    <?php
      echo $error;
      echo $_SESSION['error'];
      $_SESSION['error'] = null;
    ?>
      </span>
    <?php } ?>

    <?php
      if (isset($valid)) {
    ?>
      <span class="accountCreatedMessage">
    <?php
      echo $valid;
    ?>
      </span>
    <?php } ?>

     </div>



  </body>
</html>
