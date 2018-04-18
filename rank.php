<?php
$reponse = $bdd->query('SELECT pseudo, points FROM membre ORDER BY points DESC LIMIT 100');
?>
