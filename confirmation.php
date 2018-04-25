<?php

  $bdd = new PDO('mysql:host=localhost;dbname=isnmpweb_espace_membre', 'isnprojet', 'O1cuz98@');

  if (isset($_GET['pseudo'], $_GET['key']) AND !empty($_GET['pseudo']) AND !empty($_GET['key'])) {

    $pseudo = htmlspecialchars(urlencode($_GET['pseudo']));
    $key = htmlspecialchars($_GET['key']);

    $requser = $bdd->prepare("SELECT * FROM membres WHERE speudo = ? AND confirmkey = ?");
    $requser->execute(array($pseudo, $key));

    $userexist = $requser->rowCount();

    if ($userexist == 1) {

      $userinfo = $requser->fetch();
      if ($userinfo['isconfirm'] == 0) {

        $updateuserinfo = $bdd->prepare("UPDATE membres SET isconfirm = 1 WHERE pseudo = ? AND confirmkey = ?");
        $updateuserinfo->execute(array($pseudo, $key));
        $emailconfirmed = "Compte confirmé avec succès !";
        header("Location: connexion.php");

      }else {
        $error = "Compte déjà confirmé !";
        header("Location: connexion.php");
      }

    }else {
      $error = "Utilisateur inconnu !";
      header("Location: connexion.php");
    }


  }

 ?>
