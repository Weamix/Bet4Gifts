<!DOCTYPE html>
<?php

  session_start();

  $bdd = new PDO('mysql:host=localhost;dbname=isnmpweb_espace_membre', 'isnprojet', 'O1cuz98@');

  if (isset($_GET['user'], $_GET['tone'], $_GET['ttwo'], $_GET['id']) AND $_GET['user'] > 0 AND $_GET['id'] > 0 AND !empty($_GET['tone']) AND !empty($_GET['ttwo'])) {

    $getid = intval($_GET['id']);
    $requser = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
    $requser->execute(array($getid));

    $userinfo = $requser->fetch();

?>

<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Your profile</title>
    <link rel="icon" type="image/png" href="images/favicon.png" />
    <link rel="stylesheet" href="style/profilstyle.css">
  </head>
  <body>

    <?php if (isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) { ?>

        <p>TEST</p>

    <?php } ?>

  </body>
</html>

<?php } ?>
