<?php

  session_start();

  $bdd = new PDO('mysql:host=localhost;dbname=isnmpweb_espace_membre', 'isnprojet', 'O1cuz98@');

  if (isset($_GET['user'], $_GET['tone']), $_GET['ttwo'], $_GET['id'] AND $_GET['id'] > 0 AND $_GET['user'] > 0) AND !empty($_GET['tone']) AND !empty($_GET['ttwo'])) {

    $userid = intval($_GET['user']);
    $requser = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
    $requser->execute(array($userid));
    $userinfo = $requser->fetch();

    $matchid = intval($_GET['id']);
    $matchteamone = $_GET['tone'];
    $matchteamtwo = $_GET['ttwo'];
    $reqmatch = $bdd->prepare("SELECT * FROM matches WHERE id = ? AND team_one = ? AND team_two = ?");
    $reqmatch->execute(array($matchid, $matchteamone, $matchteamtwo));
    $matchinfo = $reqmatch->fetch();

  }else {

    header('Location: index.php');

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

    <?php if (isset($_SESSION['id']) AND $_SESSION['id'] == $userinfo['id']) {?>

        <label for=""><?php echo $matchinfo['team_one']; ?>
          <input type="radio" name="choice" value="<?php echo $matchinfo['team_one']; ?>">
        </label>
        <label for="">Match nul
          <input type="radio" name="choice" value="equality">
        </label>
        <label for=""><?php echo $matchinfo['team_two']; ?>
          <input type="radio" name="choice" value="<?php echo $matchinfo['team_two']; ?>">
        </label>

    <?php } ?>



  </body>
</html>
