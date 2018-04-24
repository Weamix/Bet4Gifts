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
      <br>
      <?php echo '<a href="bets.php?id='.$_GET['id'].'">Bet</a>'; ?>
      <br>
      <a href="#">Edit profil</a>
      <br>
      <a href="deconnexion.php">Sign out</a>

      <div class="betinprogress">

        <h2>Matches in progress</h2>

        <?php

          $reqbets = $bdd->prepare("SELECT * FROM bets WHERE author_id = ?");
          $reqbets->execute(array($getid));

          while ($bets = $reqbets->fetch()) {
         ?>

         <strong>Catégories: </strong><?php echo $bets['categories'] ?><br>
         <strong>Equipe 1: </strong><?php echo $bets['team_one'] ?><br>
         <strong>Equipe 2: </strong><?php echo $bets['team_two'] ?><br>
         <strong>Montant: </strong><?php echo $bets['amount'] ?><br>
         <strong>Pari: </strong><?php echo $bets['bet'] ?><br>
         <strong>Parieur ID: </strong><?php echo $bets['author_id'] ?><br>

       <?php } $reqbets->closeCursor(); ?>

      </div>




    <?php } ?>

  </body>
</html>

<?php } ?>
