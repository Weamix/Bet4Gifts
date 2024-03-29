<!DOCTYPE html>
<?php

  session_start();

  $bdd = new PDO('mysql:host=localhost;dbname=isnmpweb_espace_membre', 'isnprojet', 'O1cuz98@');

  if (isset($_GET['user'], $_GET['tone'], $_GET['ttwo'], $_GET['id']) AND $_GET['user'] > 0 AND $_GET['id'] > 0 AND !empty($_GET['tone']) AND !empty($_GET['ttwo'])) {

    $userid = intval($_GET['user']);
    $requser = $bdd->prepare("SELECT * FROM membres WHERE id = ?"); //On effectue un requête SQL pour récupérer les informations de l'utilisateur
    $requser->execute(array($userid));
    $userinfo = $requser->fetch();

    $matchid = intval($_GET['id']);
    $matchteamone = htmlspecialchars($_GET['tone']);
    $matchteamtwo = htmlspecialchars($_GET['ttwo']);
    $reqmatch = $bdd->prepare("SELECT * FROM matches WHERE id = ? AND team_one = ? AND team_two = ?"); //On effectue un requête SQL pour récupérer les informations du matchs
    $reqmatch->execute(array($matchid, $matchteamone, $matchteamtwo));
    $matchinfo = $reqmatch->fetch();

    $reqalreadybet = $bdd->prepare("SELECT * FROM bets WHERE match_id = ? AND team_one = ? AND team_two = ? AND author_id = ?"); //On effectue un requête SQL pour vérifier que l'utilisateur n'a pas déjà parié sur le match
    $reqalreadybet->execute(array($matchinfo['id'], $matchinfo['team_one'], $matchinfo['team_two'], $userinfo['id']));
    $alreadybet = $reqalreadybet->rowCount();

    if ($alreadybet == 0) { //On vérifie si l'utilisateur a déjà parié sur ce match

      if (isset($_POST['formbet'])) { // On vérifie si le bouton SUBMIT du formulaire a été cliqué

        if(!$_POST['choice']){  //On vérifie si l'utilisateur a choisi une équipe sur qui parier

          $error = 'Veuillez sélectionner un résultat pour parier !';

        }else {

          if (sizeof($_POST['choice']) == 1) { //On vérifie si l'utilisateur n'a sélectionné qu'un seul résultat

            if (intval($_POST['amount']) > 0) { //On vérifie que le montant est supérieur à 0

              if (intval($_POST['amount']) <= $userinfo['points']) { //On vérifie si le montant est inférieur ou égal aux points actuels du joueur

                  foreach ($_POST['choice'] as $choice) {
                    $bet = $choice; // On définit la variable $bet sur le choix de l'utilisateur
                  }

                  $addbet = $bdd->prepare("INSERT INTO `bets`(`match_id`, `categories`, `team_one`, `team_two`, `match_start`, `match_end`, `amount`, `bet`, `author_id`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"); //On prépare la requête SQL qui va permettre d'ajouter le pari à la BDD
                  $addbet->execute(array(intval($matchinfo['id']), $matchinfo['categories'], $matchinfo['team_one'], $matchinfo['team_two'], $matchinfo['match_start'], $matchinfo['match_end'], intval($_POST['amount']), $bet, $userinfo['id'])); //On execute la requête avec les bonnes valeurs

                  $updatepoints = intval($userinfo['points']) - intval($_POST['amount']);

                  $reqremovepoint = $bdd->prepare("UPDATE membres SET points = ? WHERE id = ? AND pseudo = ?");  //On effectue un requête SQL pour mettre à jour les points de l'utilisateur
                  $reqremovepoint->execute(array($updatepoints, $userinfo['id'], $userinfo['pseudo']));
                  $_SESSION['valid'] = "Pari effectué avec succès !";
                  header('Location: index.php');

              }else {
                $error = 'Vous ne pouvez pas parier plus que ce que vous avez sur votre compte !'; //On définit un message d'erreur
              }

            }else {
              $error = 'Veuillez spécifier un montant supérieur à 0 !';
            }


          }else {
            $error = 'Veuillez ne sélectionner que un seul résultat !';
          }

        }

      }

    }else {
      header("Location: index.php");
    }


?>

<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Bets</title>
    <link rel="icon" type="image/png" href="images/favicon.png" />
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="stylesheet" href="style/betsstyle.css">
  </head>
  <body>

    <?php if (isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) { ?> <!-- On vérifie qu'une session est ouverte et on verifie que l'id de la session est le même que celui de l'URL -->

        <form class="" action="" method="post">

          <label for=""><?php echo $matchinfo['team_one']; ?>
            <input type="radio" name="choice[]" value="<?php echo $matchinfo['team_one']; ?>"> <!-- On affiche l'équipe 1 -->
          </label>
          <label for=""> Match nul
            <input type="radio" name="choice[]" value="equality">
          </label>
          <label for=""><?php echo $matchinfo['team_two']; ?>
            <input type="radio" name="choice[]" value="<?php echo $matchinfo['team_two']; ?>"> <!-- On affiche l'équipe 2 -->
          </label>
          <label for="amount">Montant :
            <input type="number" name="amount" value="1" min="1" max="<?php echo $userinfo['points']; ?>"> <!-- On défini un maximum à l'input number (qui a pour max le nombre de points de l'utilisateur) -->
          </label>
          <input type="submit" name="formbet" value="Pariez !">

          <?php if (isset($error)) { echo $error; } ?> <!-- Permet d'affiche un message d'erreur s'il y en a un ! -->

        </form>


    <?php } ?>

  </body>
</html>

<?php } else{ header("Location: index.php"); }?>
