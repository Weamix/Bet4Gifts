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
    <title>Profil</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>

    <?php if (isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) { ?>

    <h2>Profil de <?php echo $userinfo['pseudo']; ?></h2>
    <br>
    <span>Pseudonyme : <?php echo $userinfo['pseudo']; ?></span>
    <br>
    <span>Email : <?php echo $userinfo['email']; ?></span>
    <br>
      <span>Points : <?php echo $userinfo['points']; ?></span>
    <br>
    <a href="#">Editer mon profil</a>
    <br>
    <a href="deconnexion.php">Se déconnecter</a>
    <?php } ?>



    <?php

      if (isset($erreur)) {
        echo $erreur;
      }

     ?>

  </body>
</html>

<?php } ?>
