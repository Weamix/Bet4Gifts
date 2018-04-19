<?php

  session_start();

  $bdd = new PDO('mysql:host=localhost;dbname=isnmpweb_espace_membre', 'isnprojet', 'O1cuz98@');

  if (isset($_GET['id']) AND $_GET['id'] > 0) {

    if (isset($_POST['formbets'])) {

      $number = 0;
      for ($i=0; $i <=2 ; $i++) {

        echo "i =".$i."<br>";

        if (!empty($_POST[strvar($i)])) {
          $number++;
          echo "ok".$i;
          $teamselected = $i;
        }else {
          echo "erreur";

        }

      }

      if ($number == 0) {

        if ($number == 1) {

          if (!empty($_POST['amount'])) {

            $getid = intval($_GET['id']);
            $requser = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
            $requser->execute(array($getid));

            $userinfo = $requser->fetch();

            if ($_POST['amount'] > 0 AND $_POST['amount'] <= $userinfo['points']) {
              # code...
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
          <input type="checkbox" name="1" value="">
        </label>
        <label for=""> Match Nul
          <input type="checkbox" name="0" value="">
        </label>
        <label for=""> Equipe 2
          <input type="checkbox" name="2" value="">
        </label>
        <label for=""> Montant :
          <input type="number" name="amount" value="" min="1" max="1000"> <input type="submit" name="formbets" value="Parier !">
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
