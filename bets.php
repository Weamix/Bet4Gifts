<?php

  session_start();

  $bdd = new PDO('mysql:host=localhost;dbname=isnmpweb_espace_membre', 'isnprojet', 'O1cuz98@');

  if (isset($_GET['id'], $_GET['tone'], $_GET['ttwo'], $_GET['user']) AND $_GET['id'] > 0 AND !empty($_GET['tone']) AND !empty($_GET['ttwo'])) {

    $getuserid = intval($_GET['user']);
    $requser = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
    $requser->execute(array($getuserid));
    $userinfo = $requser->fetch();

    echo "test";



  }else {
    header("Location: index.php");
  }

?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Bets</title>
    <link rel="icon" type="image/png" href="images/favicon.png" />
  </head>
  <body>

   <?phpif(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) { ?>

      <form class="" action="test.php" method="post">

        <label for=""> Equipe 1
          <input type="radio" name="betcheck">
        </label>
        <label for=""> Match Nul
          <input type="radio" name="betcheck" value="equality">
        </label>
        <label for=""> Equipe 2
          <input type="radio" name="betcheck">
        </label>
        <label for=""> Montant :
          <input type="number" name="amount" value="1" min="1" <?php echo 'max="'.$userinfo['points'].'"' ?>> <input type="submit" name="formbets" value="Parier !">
        </label>

      </form>

    <?php} else { header("Location: index.php"); } ?>

  </body>
</html>
