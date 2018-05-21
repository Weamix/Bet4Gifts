-<?php 
try {
    $db = new PDO('mysql:host=adresse;dbname=nom_de_ta_base', $user='nom_util', $pass='mot_de_passe');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}
$sql = $conn->query("SELECT nom_produit, prix FROM maboutique");
- 
-$array = array("cle_steam_aleatoire" => $sql['nom_produit'], "prix" => $sql['prix']);
-echo '<table>
-   <caption>La Boutique</caption>
-   <tr>
-       <th>Nom du produit</th>
-       <th>prix</th>
-       <th>action</th>
-   </tr>';
-foreach($array as $item){
-    echo '
-   <tr>
-       <td>'.$array['cle_steam_aleatoire'].'</td>
-       <td>'.$array['prix'].'points</td>
-       <td><a href="#">Acheter</a></td>
-   </tr><br />
-</table>';}?>
