<?php
/**
*	acces_rapide.php
*	liste d�roulante pour acc�s rapide � une page
*/
?>

<?php

function liste_rapide($chemin="")
{
	print("<select name=\"destination\" size=\"1\" onChange = \"redirige(this.form)\">");
		print("<option>Acc�s rapide</option>");
		$mot = $chemin."blocnote_lire.php";
		print("<option value = \"$mot\"> Main courante </option>");
		$mot = $chemin."sagec67.php";
		print("<option value = \"$mot\"> Menu principal </option>");
		$mot = $chemin."lits_synoptique.php";
		print("<option value = \"$mot\"> Synoptique service </option>");
	print("</select>");
}
?>
