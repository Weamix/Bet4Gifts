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

        <h2>Matches avaible</h2>

        <?php

            $reqmatchavaible = $bdd->prepare("SELECT * FROM matches WHERE categories = ? AND match_start > CURDATE()");
            $reqmatchavaible->execute(array("football"));

            while ($matchavaible = $reqmatchavaible->fetch()) {

              $date = $matchavaible['match_start'];
              $match_start = date('d-m-Y H:i', strtotime($date));

            /*  echo '
              <div class=\"bet_container\">
               <span>'.$matchavaible['team_one'].' VS '.$matchavaible['team_two'].'</span>
               <br>
               <br>
               <span>Categorie :'.$matchavaible['categories'].'</span>
               <span>Début: '.$match_start.'</span>
               <br>
               <a href=\"bets.php?tone='.$matchavaible['team_one'].'&ttwo='.$matchavaible['team_two'].'&id='.$matchavaible['id'].'\">Pariez !</a>
              </div>
               ';*/

            }
         ?>


      </div>




    <?php } ?>

  </body>
</html>

<?php } ?>
