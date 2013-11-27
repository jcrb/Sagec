<?php
/**
*	organisme2adresse.php
*/
$backPathToRoot="./";
include($backPathToRoot."adresse_ajout.php");
$type_organisme = 4;
print_r($_REQUEST);
if($_REQUEST[ok]=="valider")
{
	maj_organisme($type_organisme);
}
?>
<form name="ee" action="organisme2adresse.php" method="post">
<p> récupère les données adresse et contact de la table organisme pour les transférer vers les tables adress et contact. A ne faire qu'une seule fois !</p>
<p>Opération effectuée par le programme organisme2adresse qui devra être supprimé</p>
<p>le travail est effcetué par la fonction maj_organisme($type_organisme) du fichier adresse_ajout.php</p>
<p><input type="submit" name="ok" value="valider"></p>
</form>
<?php
?>