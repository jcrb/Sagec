<?php
	session_start();
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	$backPathToRoot="../";
    include_once("header.php");
    include_once("dbConnection.php");
    include_once($backPathToRoot."login/init_security.php");
?>
<?php
    // Retreiving Form Elements from Form
    $thisTs_ID = Security::str2db($_REQUEST['tsID']);
    $update = Security::str2db($_REQUEST['update']);
    $thisTs_nom = Security::str2db($_REQUEST['thisTs_nomField']);
    $thisTs_type = Security::str2db($_REQUEST['local_type']);
    $thisTs_localisation = Security::str2db($_REQUEST['thisTs_localisationField']);
    $thisTs_contact = Security::str2db($_REQUEST['thisTs_contactField']);
    $thisTs_lat = Security::str2db($_REQUEST['thisTs_latField']);
    $thisTs_long = Security::str2db($_REQUEST['thisTs_longField']);
    $thisCata_ID = Security::str2db($_SESSION['evenement']);
    $thisTs_parent_ID = Security::str2db($_REQUEST['localisation_type']);
	 if($_REQUEST['thisTs_activeField']) $thisTs_active = 'o';else $thisTs_active = 'n';
    $thisTs_heure_activation = $_REQUEST['thisTs_heure_activationField'];
    $thisTs_heure_arret = $_REQUEST['thisTs_heure_arretField'];
    $thisTs_reutilisable = Security::str2db($_REQUEST['thisTs_reutilisableField']);
    $racine = $backPathToRoot.'../docs/plans/';
    $this_fichier = Security::str2db($_REQUEST['fichier']);
    
if($update == false)
{
	$sqlQuery = "INSERT INTO temp_structure (ts_ID , ts_nom , ts_type , ts_localisation , ts_contact , ts_lat , ts_long , cata_ID , ts_parent_ID , ts_active, ts_heure_activation , ts_heure_arret , ts_reutilisable,ts_plan )
				VALUES ('' , '$thisTs_nom' , '$thisTs_type' , '$thisTs_localisation' , '$thisTs_contact' , '$thisTs_lat' , '$thisTs_long' , '$thisCata_ID' ,
				'$thisTs_parent_ID' , '$thisTs_active','$thisTs_heure_activation' , '$thisTs_heure_arret' , '$thisTs_reutilisable','$this_fichier' )";
	print("Un nouvel enregistrement  été ajouté à la base. Les informations suivantes ont insérées :- <br><br>");
}
else
{
	$sqlQuery = "UPDATE temp_structure SET
					ts_nom = '$thisTs_nom',
					ts_type = '$thisTs_type',
					ts_localisation = '$thisTs_localisation',
					ts_contact = '$thisTs_contact',
					ts_lat = '$thisTs_lat',
					ts_long = '$thisTs_long',
					cata_ID = '$thisCata_ID',
					ts_parent_ID = '$thisTs_parent_ID',
					ts_active = '$thisTs_active',
					ts_heure_activation = '$thisTs_heure_activation',
					ts_heure_arret = '$thisTs_heure_arret',
					ts_reutilisable = '$thisTs_reutilisable',
					ts_plan =  '$this_fichier'
					WHERE ts_ID = $thisTs_ID";
	print("Un enregistrement a été modifié. Les informations suivantes ont  ont insérées :- <br><br>");
}
	$result = ExecRequete($sqlQuery,$connexion);
	print($sqlQuery)."<br> resultat: ".$result;
?>

<table>
<tr height="30">
    <td align="right"><b>Ts_ID : </b></td>
    <td><? echo $thisTs_ID; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Ts_nom : </b></td>
    <td><? echo Security::db2str($thisTs_nom); ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Ts_type : </b></td>
    <td><? echo $thisTs_type; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Ts_localisation : </b></td>
    <td><? echo Security::db2str($thisTs_localisation); ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Ts_contact : </b></td>
    <td><? echo Security::db2str($thisTs_contact); ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Ts_lat : </b></td>
    <td><? echo $thisTs_lat; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Ts_long : </b></td>
    <td><? echo $thisTs_long; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Cata_ID : </b></td>
    <td><? echo $thisCata_ID; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Ts_parent_ID : </b></td>
    <td><? echo $thisTs_parent_ID; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Ts_active : </b></td>
    <td><? echo $thisTs_active; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Ts_heure_activation : </b></td>
    <td><? echo $thisTs_heure_activation; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Ts_heure_arret : </b></td>
    <td><? echo $thisTs_heure_arret; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Ts_reutilisable : </b></td>
    <td><? echo $thisTs_reutilisable; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Ts_plan : </b></td>
	<td><? echo $this_fichier; ?></td>
</tr>
</table>

<?php
    include_once("footer.php");
?> 