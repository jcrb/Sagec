<?php
/*
$objetNom
$objetId
$table
*/

function liste($objetNom,$objetId,$table)
{
	$m = '"SELECT '.$objetNom.','.$objetId.' FROM '.$table.' ORDER BY '.$objetNom.'";<br>';
	$m .= '$resultat = ExecRequete($requete,$connexion);<br>';
	$m .= 'print("<SELECT NAME=\"$id_centrale\" size=\"1\">");<br>';
	$m .= 'print("<OPTION VALUE = \"0\">'.'--?--'.'</OPTION> \n";)';
	$m .= 'while($rub=mysql_fetch_array($resultat)){\n';
	$m .= 'print("<OPTION VALUE=\"$rub['.$objetId.']\" ")\n;';
	$m .= 'if($item_select == $rub['.$objetId.']) print(" SELECTED")\n;';
	$m .= 'print(">".$rub['.$objetNom.']."</OPTION> \n")\n;}';
	$m .= '@mysql_free_result($resultat)\n;';
	$m .= 'print("</SELECT>\n");';
	return $m;
}

echo liste('dci_nom','dci_ID','med_dci');

?>