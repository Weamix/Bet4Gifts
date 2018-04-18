<?php
mysql_connect("localhost", "root", "");
mysql_select_db("personnages");
$reponse = mysql_query('SELECT * FROM personnages ORDER BY experience');
$rang = 0;
 
while ($donnees = mysql_fetch_array($reponse))
{
$rang++;
echo $rang;
echo $donnees['pseudo'];
echo $donnees['experience'];
}
?>
