<?php
$req=$bdd->prepare('SELECT nom_produit, prix FROM maboutique');
$req->execute();
?>
     <table>
          <tr>
               <th>Produit</th>
               <th>Prix unitaire</th>
               <th>Ajouter au panier</th>              
          </tr>
<?php    
while ($donnees = $req->fetch())
{
?>
          <tr>
               <td><?php echo $donnees['nom_produit']; ?></td>
               <td><?php echo $donnees['prix']; ?></td>
               <td><a href="panier.php?action=ajout&amp;l=<?php echo($donnees['nom_produit']); ?>&amp;q=1&amp;p=<?php echo($donnees['prix']); ?>" onclick="window.open(this.href, '', 'toolbar=no, location=no, directories=no, status=yes, scrollbars=yes, resizable=yes, copyhistory=no, width=600, height=350'); return false;">Ajouter au panier</a></td>
          </tr>
<?php
}
?>
     </table>
