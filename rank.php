<?php

// on se connecte à MySQL (à remplir)
$db = mysql_connect('localhost', 'isnprojet', 'O1cuz98@');
// on sélectionne la base (à remplir) 
mysql_select_db('isnmpweb_espace_membre',$db);

// Tableau des meilleurs
$recup_parieurs =mysql_query( 'SELECT pseudo, points FROM membre ORDER BY points DESC LIMIT 100 ');

$compteur = 1;
while($best_parieurs = mysql_fetch_array($recup_parieurs)){
     // Mise en forme des données à revoir
     echo $compteur."<br/>";
     echo $best_posteurs ["pseudo"]."<br/>";
     echo $best_posteurs ["points"]."<br/>";
     $compteur++;
}
}

?>
