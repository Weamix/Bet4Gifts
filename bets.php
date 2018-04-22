<?php

  session_start();

  $bdd = new PDO('mysql:host=localhost;dbname=isnmpweb_espace_membre', 'isnprojet', 'O1cuz98@');

  if (isset($_GET['id']) AND $_GET['id'] > 0) {

    $getid = intval($_GET['id']);
    $requser = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
    $requser->execute(array($getid));

    $userinfo = $requser->fetch();

    if (isset($_POST['formbets'])) {

      $number = 0;
      for ($i=0; $i < 3 ; $i++) {

        $i2 = (string)$i;

        if (isset($_POST[$i2])) {
          $number++;
          $teamselected = $i;
        }

      }

      if ($number != 0) {

        if ($number == 1) {

          if (!empty($_POST['amount'])) {

            if ($_POST['amount'] > 0 AND $_POST['amount'] <= $userinfo['points']) {

              $categories = "football";
              $team_one = (string)$_POST['teamone'];
              $team_one = (string)$_POST['teamtwo'];
              $bet = (int)$teamselected;
              $amount = (int)$_POST['amount'];
              //$match_end = null;
              //$author_id = htmlspecialchars($userinfo['id']);
              echo $categories;
              echo $team_one;
              echo $team_two;
              echo $bet;
              echo $amount;

              $insertbet = $bdd->prepare("INSERT INTO bets(categories, team_one, team_two, bet, amount, author_id) VALUES(?, ?, ?, ?, ?, ?)");
              $insertbet->execute(array($categories, $team_one, $team_two, $bet, $amount, 1));

            }else {
              $error = "Le montant saisi est supérieur à vos points actuels (ou inférieur 1)";
            }

          }else {
            $error = "Veuillez saisir un montant !";
          }

        }else {
          $error = "Veuillez ne sélectionner que un seul résultat !";
        }

      }else {
        $error = "Veuillez sélectionner un résultat !";
      }

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

   <?php if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) { ?>

      <form class="" action="" method="post">

        <label for=""> Equipe 1
          <input type="hidden" name="teamone" value="TeamOne">
          <input type="checkbox" name="1">
        </label>
        <label for=""> Match Nul
          <input type="checkbox" name="0" value="equality">
        </label>
        <label for=""> Equipe 2
          <input type="hidden" name="teamtwo" value="TeamTwo">
          <input type="checkbox" name="2">
        </label>
        <label for=""> Montant :
          <input type="number" name="amount" value="" min="1"> <input type="submit" name="formbets" value="Parier !">
        </label>

      </form>

    <?php } ?>

      <?php

          if (isset($error)) {

            echo $error;

          }

       ?>

  </body>
</html>
<?php } ?>
