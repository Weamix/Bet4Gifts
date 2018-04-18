<?php 

// on se connecte à MySQL (à remplir) 
$db = mysql_connect('localhost', 'login', 'password'); 
// on sélectionne la base (à remplir) 
mysql_select_db('nom_de_la_base',$db);  


// Tableau des meilleurs posteurs 
$recup_posteurs =mysql_query( 'SELECT DISTINCT `username`, `visits`, `referals` FROM `tb_users` ORDER BY `visits` DESC LIMIT 0, 10 ');  

$compteur = 1; 
while($best_posteurs = mysql_fetch_array($recup_posteurs)){ 
     // Mise en forme des données à revoir 
     echo $compteur."<br/>";      
     echo $best_posteurs ["username"]."<br/>"; 
     echo $best_posteurs ["visits"]."<br/>"; 
     echo $best_posteurs ["referals"]."<br/>"; 
     $compteur++; 
} 

// Tableau des meilleurs parrains 
$recup_parrains =mysql_query( 'SELECT DISTINCT `username`, `visits`, `referals` FROM `tb_users` ORDER BY `referals` DESC LIMIT 0, 10 ');  

$compteur = 1; 
while($best_parrains = mysql_fetch_array($recup_posteurs)){ 
     // Mise en forme des données à revoir 
     echo $compteur."<br/>";      
     echo $best_parrains["username"]."<br/>"; 
     echo $best_parrains["visits"]."<br/>"; 
     echo $best_parrains["referals"]."<br/>"; 
     $compteur++; 
} 

?>
