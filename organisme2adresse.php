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
<p> r�cup�re les donn�es adresse et contact de la table organisme pour les transf�rer vers les tables adress et contact. A ne faire qu'une seule fois !</p>
<p>Op�ration effectu�e par le programme organisme2adresse qui devra �tre supprim�</p>
<p>le travail est effcetu� par la fonction maj_organisme($type_organisme) du fichier adresse_ajout.php</p>
<p><input type="submit" name="ok" value="valider"></p>
</form>
<?php
?>