<?php

  $bdd = new PDO('mysql:host=localhost;dbname=isnmpweb_espace_membre', 'isnprojet', 'O1cuz98@');

  if (isset($_GET['pseudo'], $_GET['key']) AND !empty($_GET['pseudo']) AND !empty($_GET['key'])) {

    echo "ISSET OK";

    $pseudo = htmlspecialchars(urlencode($_GET['pseudo']));
    echo $pseudo;
    $key = htmlspecialchars($_GET['key']);
    echo $key;

    $requser = $bdd->prepare("SELECT * FROM membres WHERE speudo = ? AND confirmkey = ?");
    $requser->execute(array($pseudo, $key));

    $userexist = $requser->rowCount();

    if ($userexist == 1) {

      $userinfo = $requser->fetch();
      if ($userinfo['isconfirm'] == 0) {

        $updateuserinfo = $bdd->prepare("UPDATE membres SET isconfirm = 1 WHERE pseudo = ? AND confirmkey = ?");
        $updateuserinfo->execute(array($pseudo, $key));
        echo "Compte confirmé avec succès !";

      }else {
        echo "Compte déjà confirmé !";
      }

    }else {
      echo "Utilisateur inconnu !";
    }


  }

 ?>
