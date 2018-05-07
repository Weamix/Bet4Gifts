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
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Bets</title>
    <link rel="icon" type="image/png" href="images/favicon.png" />
  </head>
  <body>


    <p>test</p>


  </body>
</html>
<?php }else { header('Location: index.php');} ?>
