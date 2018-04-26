<!DOCTYPE html>
<?php

  session_start();

  $bdd = new PDO('mysql:host=localhost;dbname=isnmpweb_espace_membre', 'isnprojet', 'O1cuz98@');

  if (isset($_POST['formchangepassword'])) {

    if(isset($_GET['email'], $_GET['key']) AND !empty($_GET['email']) AND !empty($_GET['key'])) {

      $email = htmlspecialchars($_GET['email']);
      $key = htmlspecialchars($_GET['key']);

      $reqemail = $bdd->prepare("SELECT * FROM membres WHERE email =  ?");
      $reqemail->execute(array($email));
      $emailexist = $reqemail->rowCount();
      $userinfo = $reqemail->fetch();

      $newpassword = htmlspecialchars($_POST['newpassword']);
      $confirmnewpassword = htmlspecialchars($_POST['confirmnewpassword']);

      $newpasswordcrypt = sha1($newpassword);
      $lastpassword = htmlspecialchars($userinfo['password']);

      if ($emailexist == 1) {

          if ($newpassword == $confirmnewpassword) {

            if ($newpasswordcrypt != $lastpassword) {

              $updateuser = $bdd->prepare("UPDATE membres SET password = ? WHERE email = ? AND confirmkey = ?");
              $updateuser->execute(array($newpasswordcrypt,$email,$key));
              $valid = "Congratulations ! Your password have been changed !";

            }else {
              $error = "The new password can't be the same that the last password !";
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
