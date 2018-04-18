<?php
  
function point($pseudo, $pt)
{
  //on cherche si le pseudo existe
    $sql = $bdd->prepare('SELECT pseudo FROM membre WHERE pseudo = ?');
    $sql->execute(array($pseudo));   
    $req = $sql->fetch();
    if ($req['pseudo']) {
    	//on selectionne le nombre de points
    $sql = $bdd->prepare('SELECT points FROM membre WHERE pseudo = ?');
    	$sql->execute(array($pseudo));   
    	$req = $sql->fetch();
    	//on met tout sous forme de nombre entier
    	$point = (int) $req['points']; 
    	$pt = (int) $pt;
    	//on ajoute les points gagnés
    	$point += $pt;
    	//on sauve le tout dans la bdd
    	$sql = $bdd->prepare('UPDATE membre SET points = ? WHERE id = ?');
        $sql->execute(array($point, $pseudo));    	
    }
}


<?php } ?>



