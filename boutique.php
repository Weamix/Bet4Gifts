<?php $sql = mysql_query("SELECT nom_produit, prix FROM maboutique");
 
$array = array("nom_produit" => $sql['nom_produit'], "prix" => $sql['prix']);
echo '<table>
   <caption>La Boutique</caption>
   <tr>
       <th>Nom du produit</th>
       <th>prix</th>
       <th>action</th>
   </tr>';
foreach($array as $item){
    echo '
   <tr>
       <td>'.$array['nom_produit'].'</td>
       <td>'.$array['prix'].'points</td>
       <td><a href="#">Acheter</a></td>
   </tr><br />
</table>';}?>
