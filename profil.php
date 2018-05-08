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
    <link rel="icon" type="image/png" href="images/favicon.png" />
    <link rel="stylesheet" href="style/profilstyle.css">
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
      <br>
      <?php echo '<a href="bets.php?id='.$_GET['id'].'">Bet</a>'; ?>
      <br>
      <a href="#">Edit profil</a>
      <br>
      <a href="deconnexion.php">Sign out</a>

      <div class="bet">

        <h2>Matches available</h2>

        <?php

            $reqmatchavaible = $bdd->prepare("SELECT * FROM matches WHERE categories = ? AND match_start > CURDATE()");
            $reqmatchavaible->execute(array("football"));

            while ($matchavaible = $reqmatchavaible->fetch()) {

              $reqalreadybet = $bdd->prepare("SELECT * FROM bets WHERE match_id = ? AND team_one = ? AND team_two = ?");
              $reqalreadybet->execute(array($matchavaible['id'], $matchavaible['team_one'], $matchavaible['team_two']));
              $alreadybet = $reqalreadybet->rowCount();

              if ($alreadybet != 1) {

              $date = $matchavaible['match_start'];
              $match_start = date('d-m-Y H:i', strtotime($date));

            ?>
              <div class="container_bet_available">
                <span><?php echo $matchavaible['team_one']; ?> VS <?php echo $matchavaible['team_two']; ?></span>
                <br>
                <br>
                <span>Categorie : <?php echo $matchavaible['categories']; ?></span>
                <span>Date: <?php echo $match_start; ?></span>
                <br>
                <a href="<?php echo 'bets.php?user='.$userinfo['id'].'&tone='.$matchavaible['team_one'].'&ttwo='.$matchavaible['team_two'].'&id='.$matchavaible['id']; ?>">Pariez !</a>
              </div>
        <?php } } ?>


      </div>




    <?php } ?>

  </body>
</html>

<?php } ?>
