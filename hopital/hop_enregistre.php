<?php
/**
*	hop_enregistre.php
*/
print_r($_REQUEST);
$serviceID = array();
$lits_dispo = array();
$serviceID = $_REQUEST['services'];
$lits_dispo = $_REQUEST['litsd'];

for($i=0; $i < sizeof($serviceID); $i++)
{
	$requete = "UPDATE lits SET lits_dispo = '$lits_dispo[$i]' WHERE service_ID = '$serviceID[$i]'";
	print($requete."<br>");
}
	
?>