<!DOCTYPE html>
<?php

  session_start();

  $bdd = new PDO('mysql:host=localhost;dbname=isnmpweb_espace_membre', 'isnprojet', 'O1cuz98@');

  if (isset($_GET['id']) AND $_GET['id'] > 0) {

    $getid = intval($_GET['id']);
    $requser = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
    $requser->execute(array($getid));

    $userinfo = $requser->fetch();

?>

<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Your profile</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>

    <?php if (isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) { ?>

    <h2>Your profile <?php echo $userinfo['pseudo']; ?></h2>
    <br>
    <span>Username : <?php echo $userinfo['pseudo']; ?></span>
    <br>
    <span>Email : <?php echo $userinfo['email']; ?></span>
    <br>
      <span>Points : <?php echo $userinfo['points']; ?></span>
    <?php echo '<a href="bets.php?id='.$_GET['id'].'">Bet</a>'; ?>
    <br>
    <a href="#">Edit profil</a>
    <br>
    <a href="deconnexion.php">Sign out</a>
    <?php } ?>



    <?php

      if (isset($erreur)) {
        echo $erreur;
      }

     ?>

  </body>
</html>

<?php } ?>
