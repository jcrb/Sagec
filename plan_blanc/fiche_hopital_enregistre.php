<?php
/*
*	fiche_hopital_enregistre.php
* Enregistre les données dans la table
* @author Jean-Claude Bartier
* @copyright 2003-2009 (Jean-Claude Bartier)
* @package SAGEC67
*/
session_start();
$backPathToRoot = "../"; 
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");
include_once($backPathToRoot."date.php");

$hopID = $_REQUEST['hopID'];
$date = uDateTime2MySql(time());
$specialite_litsdispo = serialize($_REQUEST[dispo]);
$specialite_litsliberables = serialize($_REQUEST[liberable]);

/*
// list disponibles
// creation d'un tableau de couples spécialité/lits dispo 
foreach ($_REQUEST[dispo] as $key => $value)
{
	$dispo[] = $key; 
	$dispo[] = Security::esc2Db(strtoupper($value));
}
$specialite_litsdispo = implode(";",$dispo);
// list libérables 
// creation d'un tableau de couples spécialité/lits libérables 
foreach ($_REQUEST[liberable] as $key => $value)
{
	$liberable[] = $key; 
	$liberable[] = Security::esc2Db(strtoupper($value));
}
$specialite_litsliberables = implode(";",$liberable);
*/

if($hopID)
{
	$requete = "INSERT INTO `pma`.`planblanc_dispo` (`pb_ID` ,`Hop_ID` ,`pb_date` ,`pb_lits_dispo` ,`pb_lits_liberables`)
				VALUES ('' , '$hopID', '$date', '$specialite_litsdispo', '$specialite_litsliberables')";
	$resultat = ExecRequete($requete,$connexion);
}

$ua1 = Security::esc2Db(strtoupper($_REQUEST[ua1]));
$ua2 = Security::esc2Db(strtoupper($_REQUEST[ua2]));
$ur1 = Security::esc2Db(strtoupper($_REQUEST[ur1]));
$ur2 = Security::esc2Db(strtoupper($_REQUEST[ur2]));
$heberg1 = Security::esc2Db(strtoupper($_REQUEST[heberg1]));
$heberg2 = Security::esc2Db(strtoupper($_REQUEST[heberg2]));

$comment = Security::esc2Db(strtoupper($_REQUEST[comment]));
header("location: fiche_hopital.php?hopID=$hopID");
?>

<p>ID Hopital: <?php echo $hopID; ?></p>
<p>date</p>
<?php
echo uDateTime2MySql(time());

?>
<p>Lists disponibles</p>
<?php
foreach ($_REQUEST[dispo] as $key => $value)
	 echo 'Cet élément a pour clé "' . $key . '" et pour valeur "' . $value . '"<br />';
print($specialite_litsdispo."<br>");
?>
<p>Lits libérables dans les 3 heures</p>
<?php
foreach ($_REQUEST[liberable] as $key => $value)
	 echo 'Cet élément a pour clé "' . $key . '" et pour valeur "' . $value . '"<br />';
?>
<p>ID Hopital: <?php print_r($_REQUEST); ?></p>
