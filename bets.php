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

    $reqalreadybet = $bdd->prepare("SELECT * FROM bets WHERE match_id = ? AND team_one = ? AND team_two = ?");
    $reqalreadybet->execute(array($matchinfo['id'], $matchinfo['team_one'], $matchinfo['team_two']));
    $alreadybet = 1;

    if ($alreadybet == 0) {

      if (isset($_POST['formbet'])) {

        if(!$_POST['choice']){

          $error = 'Veuillez sélectionner un résultat pour parier !';

        }else {

          if (sizeof($_POST['choice']) == 1) {

            if (intval($_POST['amount']) > 0) {

              if (intval($_POST['amount']) <= $userinfo['points']) {

                  foreach ($_POST['choice'] as $choice) {
                    $bet = $choice;
                  }

                  $addbet = $bdd->prepare("INSERT INTO `bets`(`match_id`, `categories`, `team_one`, `team_two`, `match_start`, `match_end`, `amount`, `bet`, `author_id`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                  $addbet->execute(array($matchid, $matchinfo['categories'], $matchinfo['team_one'], $matchinfo['team_two'], $matchinfo['match_start'], $matchinfo['match_end'], intval($_POST['amount']), $bet, $userinfo['id']));
                  $error = 'Pari validé !';

              }else {
                $error = 'Vous ne pouvez pas parier plus que ce que vous avez sur votre compte !';
              }

            }else {
              $error = 'Veuillez spécifier un montant supérieur à 0 !';
            }


          }else {
            $error = 'Veuillez ne sélectionner que un seul résultat !';
          }

        }

      }

    }/*else {
      header("Location : index.php");
    }*/


?>

<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Bets</title>
    <link rel="icon" type="image/png" href="images/favicon.png" />
    <link rel="stylesheet" href="style/profilstyle.css">
  </head>
  <body>

    <?php if (isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) { ?>

        <form class="" action="" method="post">

          <label for=""><?php echo $matchinfo['team_one']; ?>
            <input type="radio" name="choice[]" value="<?php echo $matchinfo['team_one']; ?>">
          </label>
          <label for=""> Match nul
            <input type="radio" name="choice[]" value="equality">
          </label>
          <label for=""><?php echo $matchinfo['team_two']; ?>
            <input type="radio" name="choice[]" value="<?php echo $matchinfo['team_two']; ?>">
          </label>
          <label for="">Montant :
            <input type="number" name="amount" value="1" min="1" max="<?php echo $userinfo['points']; ?>">
          </label>
          <input type="submit" name="formbet" value="Pariez !">

        </form>

        <?php if (isset($error)) { echo $error; } ?>

    <?php } ?>

  </body>
</html>

<?php } else{ header("Location: index.php"); }?>
