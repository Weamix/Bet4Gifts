<?php

  session_start();
  $bdd = new PDO('mysql:host=localhost;dbname=isnmpweb_espace_membre', 'isnprojet', 'O1cuz98@');

  if(isset($_GET['pseudo'], $_GET['key']) AND !empty($_GET['pseudo']) AND !empty($_GET['key'])) { //On vérifie si les informations de l'URL sont remplies

    $pseudo = htmlspecialchars($_GET['pseudo']); //On sécurise les variables
    $key = htmlspecialchars($_GET['key']);
    $requser = $bdd->prepare("SELECT * FROM membres WHERE pseudo = ? AND confirmkey = ?"); //On prépare la requête SQL
    $requser->execute(array($pseudo, $key)); //On l'execute avec les bonnes valeurs
    $userexist = $requser->rowCount(); // On regarde le nombre de ligne dans la BDD qui respecte les conditions de la requête

    if($userexist == 1) { //On vérifie si l'utilisateur existe

      $user = $requser->fetch(); //Permet de récupérer les informations de la requête

      if($user['isconfirm'] == 0) { //On vérifie que l'utilisateur n'a pas encore confirmé son compte

        $updateuser = $bdd->prepare("UPDATE membres SET isconfirm = 1 WHERE pseudo = ? AND confirmkey = ?");
        $updateuser->execute(array($pseudo,$key));
        $_SESSION['valid'] = "Your accound has been confirmed !"; //On définit un message de validité !
        header("Location: connexion.php"); //On redirige l'utilistauer vers la page de connexion !

      } else {
        $_SESSION['error'] = "Your account has already been confirmed !"; //On définit un message d'erreur !
        header("Location: inscription.php");
      }

    } else {
      $_SESSION['error'] = "The user doesn't exist !";
      header("Location: inscription.php");
    }
  }
?>
