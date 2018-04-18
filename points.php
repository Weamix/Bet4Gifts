<?php
function rang($pseudo)
{
  include('/index.php');

  //on cherche si le pseudo existe
  $sql = $bdd->prepare('SELECT pseudo FROM membre WHERE pseudo = ?');
    $sql->execute(array($pseudo));   
    $req = $sql->fetch();
    if ($req['pseudo']) {
        //on cherche le rang
        $sql = $bdd->prepare('SELECT COUNT(*) + 1 AS rang FROM membre WHERE points > (SELECT points FROM membre WHERE pseudo = ?)');
        $sql->execute(array($pseudo));   
        $req = $sql->fetch();

        $sql = $bdd->query('SELECT COUNT(*) AS nb_membre FROM membre');
        $req_membre = $sql->fetch();

        return array($req['rang'], $req_membre['nb_membre']);        
    }
    else {
        return FALSE;
    }
}
?>
