<?php
ini_set("display_errors",1);
try {
    $db = new PDO('mysql:host=localhost;dbname=isnmpweb_espace_membre', 'isnprojet', 'O1cuz98@');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}
$sql = $db->query("SELECT nom_produit, prix FROM maboutique");

echo '<table border="1">';
while($data = $sql->fetch())
{
   $nom_produit = $data['nom_produit'];

echo "<tr><td>$nom_produit</td><td></td></tr>";

}
echo '</table>';
?>
