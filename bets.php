<!DOCTYPE html>
<?php

  session_start();

  $bdd = new PDO('mysql:host=localhost;dbname=isnmpweb_espace_membre', 'isnprojet', 'O1cuz98@');

  if (isset($_GET['user'], $_GET['tone'], $_GET['ttwo'], $_GET['id']) AND $_GET['user'] > 0 AND $_GET['id'] > 0 AND !empty($_GET['tone']) AND !empty($_GET['ttwo'])) {

    $userid = intval($_GET['user']);
    $requser = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
    $requser->execute(array($userid));
    $userinfo = $requser->fetch();

    $matchid = intval($_GET['id']);
    $matchteamone = htmlspecialchars($_GET['tone']);
    $matchteamtwo = htmlspecialchars($_GET['ttwo']);
    $reqmatch = $bdd->prepare("SELECT * FROM matches WHERE id = ? AND team_one = ? AND team_two = ?");
    $reqmatch->execute(array($matchid, $matchteamone, $matchteamtwo));
    $matchinfo = $reqmatch->fetch();

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

        <label for=""><?php echo $matchinfo['team_one']; ?>
          <input type="radio" name="choice" value="<?php echo $matchinfo['tone']; ?>">
        </label>
        <label for=""> Match nul
          <input type="radio" name="choice" value="equality">
        </label>
        <label for=""><?php echo $matchinfo['team_two']; ?>
          <input type="radio" name="choice" value="<?php echo $matchinfo['ttwo']; ?>">
        </label>

    <?php } ?>

  </body>
</html>

<?php } ?>
