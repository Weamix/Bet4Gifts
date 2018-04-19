<?php

  session_start();

  $bdd = new PDO('mysql:host=localhost;dbname=isnmpweb_espace_membre', 'isnprojet', 'O1cuz98@');

  if (isset($_GET['id']) AND $_GET['id'] > 0) {

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

            $getid = intval($_GET['id']);
            $requser = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
            $requser->execute(array($getid));

            $userinfo = $requser->fetch();

            if ($_POST['amount'] > 0 AND $_POST['amount'] <= $userinfo['points']) {

              //$categories = "football";
             // $team_one = htmlspecialchars($_POST['1']);
              //$team_one = htmlspecialchars($_POST['2']);
              //$bet = htmlspecialchars($teamselected);
              //$amount = htmlspecialchars($_POST['amount']);
              //$match_end = null;
              //$author_id = htmlspecialchars($userinfo['id']);

              $insertbet = $bdd->prepare("INSERT INTO bets(categories, team_one, team_two, bet, amount, author_id) VALUES(?, ?, ?, ?, ?, ?)");
              $insertbet->execute(array("football", "equipe1", "equipe2", 1, 200, 1));

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
  </head>
  <body>

      <form class="" action="" method="post">

        <label for=""> Equipe 1
          <input type="checkbox" name="1" value="teamone">
        </label>
        <label for=""> Match Nul
          <input type="checkbox" name="0" value="equality">
        </label>
        <label for=""> Equipe 2
          <input type="checkbox" name="2" value="teamtwo">
        </label>
        <label for=""> Montant :
          <input type="number" name="amount" value="" min="1"> <input type="submit" name="formbets" value="Parier !">
        </label>

      </form>

      <?php

          if (isset($error)) {

            echo $error;

          }

       ?>

  </body>
</html>
<?php } ?>
