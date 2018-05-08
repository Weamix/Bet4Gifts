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
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
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
      <a href="#">Edit profil</a>
      <br>
      <a href="deconnexion.php">Sign out</a>

      <div class="bet">

        <h2>Matches available</h2>

        <?php

            $reqmatchavaible = $bdd->prepare("SELECT * FROM matches WHERE categories = ? AND match_start > CURRENT_TIMESTAMP");
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

        <h2>Matchs bet upcoming</h2>

        <?php

          $reqmatchbetincoming = $bdd->prepare('SELECT * FROM bets WHERE author_id = ? AND match_start > CURRENT_TIMESTAMP');
          $reqmatchbetincoming->execute(array($userinfo['id']));

          while ($matchbetupcoming = $reqmatchbetincoming->fetch()) {

            $date = $matchbetupcoming['match_start'];
            $match_start = date('d-m-Y H:i', strtotime($date));

        ?>

        <div class="container_bet_available">
          <span><?php echo $matchbetupcoming['team_one']; ?> VS <?php echo $matchbetupcoming['team_two']; ?></span>
          <br>
          <br>
          <span>Categorie : <?php echo $matchbetupcoming['categories']; ?></span>
          <span>Date: <?php echo $match_start; ?></span>
          <br>
          <span>Résultat parié : <?php echo $matchbetupcoming['bet']; ?></span>
        </div>


        <?php } ?>

        <h2>Matchs bet in progress</h2>

        <?php

          $reqmatchbetinprogress = $bdd->prepare('SELECT * FROM bets WHERE author_id = ? AND match_start < CURRENT_TIMESTAMP AND match_end > CURRENT_TIMESTAMP');
          $reqmatchbetinprogress->execute(array($userinfo['id']));

          while ($matchbetinprogress = $reqmatchbetinprogress->fetch()) {

            $date = $matchbetinprogress['match_start'];
            $match_start = date('d-m-Y H:i', strtotime($date));

        ?>

        <div class="container_bet_available">
          <span><?php echo $matchbetinprogress['team_one']; ?> VS <?php echo $matchbetinprogress['team_two']; ?></span>
          <br>
          <br>
          <span>Categorie : <?php echo $matchbetinprogress['categories']; ?></span>
          <span>En cours !</span>
          <br>
          <span>Résultat parié : <?php echo $matchbetinprogress['bet']; ?></span>
        </div>


        <?php } ?>

        <h2>Matchs bet finished</h2>

        <?php

          $reqmatchbetfinished = $bdd->prepare('SELECT * FROM bets WHERE author_id = ? AND match_end <= CURRENT_TIMESTAMP');
          $reqmatchbetfinished->execute(array($userinfo['id']));

          while ($matchbetfinished = $reqmatchbetfinished->fetch()) {

            $reqmatchresult = $bdd->prepare("SELECT result FROM matches WHERE id = ?");
            $reqmatchresult->execute(array(intval($matchbetfinished['match_id'])));
            $matchresult = $reqmatchresult->fetch();

            $date = $matchbetfinished['match_start'];
            $match_start = date('d-m-Y H:i', strtotime($date));

            if ($matchbetfinished['bet'] == $matchresult['result']) {

              //$gain = floor(intval($matchbetfinished['amount']) * 1.10);
              //$newPointsvalue = intval($userinfo['points']) + $gain;

              /*if ($matchbetfinished['pointrecup'] == 0) {

                  $reqaddpoints = $bdd->prepare('UPDATE membres SET points = ? WHERE id = ? AND pseudo = ?');
                  $reqaddpoints->execute(array($newPointsvalue, $userinfo['id'], $userinfo['pseudo']));

                  $reqsetrecuppoints = $bdd->prepare('UPDATE bets SET pointrecup = ? WHERE author_id = ? AND team_one = ? AND team_two = ?');
                  $reqsetrecuppoints->execute(array(1 ,$userinfo['id'], $matchbetfinished['team_one'], $matchbetfinished['team_two']));

              }*/

        ?>

            <div class="container_bet_available">
              <span><?php echo $matchbetfinished['team_one']; ?> VS <?php echo $matchbetfinished['team_two']; ?></span>
              <br>
              <br>
              <span>Categorie : <?php echo $matchbetfinished['categories']; ?></span>
              <span>Finished !</span>
              <br>
              <span>Résultat: <?php echo $matchresult['result'] ?></span>
              <span>Résultat parié : <?php echo $matchbetfinished['bet']; ?></span>
              <span>Gain : <?php echo $gain; ?></span>
              <br>
              <span>Vous avez gagné !</span>
            </div>


        <?php}else { ?>

          <div class="container_bet_available">
            <span><?php echo $matchbetfinished['team_one']; ?> VS <?php echo $matchbetfinished['team_two']; ?></span>
            <br>
            <br>
            <span>Categorie : <?php echo $matchbetfinished['categories']; ?></span>
            <span>Finished !</span>
            <br>
            <span>Résultat: <?php echo $matchresult['result'] ?></span>
            <span>Résultat parié : <?php echo $matchbetfinished['bet']; ?></span>
            <span>Gain : 0</span>
            <br>
            <span>Vous avez perdu !</span>
          </div>

        <?php } }?>
      </div>

      <?php if (isset($_SESSION['valid'])) { echo "<div class=\"validMessage\"><span>".$_SESSION['valid']."</span><a href=\"#\">Close</a></div>"; } ?>

    <?php } ?>

  </body>
</html>

<?php } ?>
