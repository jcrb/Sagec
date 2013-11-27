<?php
/**
*	zone_liste.php
*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$backPathToRoot = "../"; 
include_once($backPathToRoot."dbConnection.php");
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
</head>
<body>
<form name = "zones" method="post" action="zone_saisie.php">

<?php
function SelectZone($connexion,$item_select=0) //discipline_id
{
	$requete="SELECT zenveloppe_nom,zenveloppe_ID FROM zone_enveloppe ORDER BY zenveloppe_nom";
	$resultat = ExecRequete($requete,$connexion);
	print("<SELECT NAME=\"zoneID\" size=\"1\">");
	$mot="== nouveau ==";
	print("<OPTION VALUE = \"0\" selected>$mot </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<OPTION VALUE=\"$rub[zenveloppe_ID]\" ");
		//if($item_select == $rub['zenveloppe_ID']) print(" SELECTED");
		print(">".$rub['zenveloppe_nom']."</OPTION> \n");

	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
}

SelectZone($connexion,"");
echo "<input type='submit' name='btn' value='voir'>";
?>
</form>
</body>
</html>