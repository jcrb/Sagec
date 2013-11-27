<?php
//----------------------------------------- SAGEC --------------------------------------------------------

// This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// SAGEC67 is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
/**--------------------------------------------------------------------------------------------------------
*	programme: 		intervenant_enregistre
*	@date création: 	03/09/2003
*	@author:		jcb
*	description:	
*	@version:		1.3 - $Id$
*	maj le:			03/10/2004			enregistre le service d'appartenance
*	maj le:			27/11/2006			enregistre n° passeport
*	@package		Sagec
*--------------------------------------------------------------------------------------------------------*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../"; 
require($backPathToRoot."dbConnection.php");
include($backPathToRoot."login/init_security.php");
include($backPathToRoot."date.php");
include($backPathToRoot."adresse_ajout.php");

// teste s'il existe un individu ayant le même nom
function intervenant_existe($nom,$connexion)
{
	if(Security::esc2Db($_REQUEST['maj'] == 0))// uniquement si demande de création
	{
		$nom = Security::esc2Db($_REQUEST[nom]);
		$prenom = Security::esc2Db($_REQUEST[prenom]);
		$requete="SELECT Pers_Nom,Pers_Prenom FROM personnel WHERE Pers_Nom = '$nom' AND Pers_Prenom = '$prenom'";
		$resultat = ExecRequete($requete,$connexion);
		$donnees = mysql_fetch_array($resultat);
		if($donnees)return true;
		else return false;
	}
}

$adresse = recupere_adresse();


$auto = $_REQUEST[auto];
$maj = $_REQUEST['maj'];
$_SESSION["localisation"] = $_REQUEST[localisation_type];

$nom = Security::esc2Db($_REQUEST[nom]);
$prenom = Security::esc2Db($_REQUEST[prenom]);
$passport_no = Security::esc2Db($_REQUEST[passport_no]);
$passport_qui = Security::esc2Db($_REQUEST[passport_qui]);
//$passport_date = Security::esc2Db(fDate2unix($_REQUEST[date_u]));// date française en timestamp unix
$delai_route = Security::esc2Db($_REQUEST[delai_route]);
$rpps = Security::esc2Db($_REQUEST[rpps]);

if($_REQUEST['maj'])
{	// update du vecteur
	$date_maj = date("Y-m-j H:i:s");// format compatible mysql;
	$requete="UPDATE personnel SET 	Pers_ID = '$_REQUEST[maj]',
								Pers_Nom = '$nom',
								Pers_Prenom = '$prenom',
								civilite_ID = '$_REQUEST[civilite_type]',
								perso_cat_ID = '$_REQUEST[prof_type]',
								org_ID = '$_REQUEST[orgID]',
								service_ID = '$_REQUEST[the_service]',
								pers_Maj = '$date_maj',
								delai_route = '$delai_route',
								passport_no = '$passport_no',
								passport_date = '$passport_date',
								passport_qui = '$passport_qui',
								rpps = '$_REQUEST[rpps]',
								adresse_ID = '$adresse',
								visible = '$_REQUEST[o_n]'
							WHERE Pers_ID = '$_REQUEST[maj]'";
	$resultat = ExecRequete($requete,$connexion);
}
else
{
	if(!intervenant_existe($nom,$connexion))
	{	// Création intervenant
		$date_maj = date("Y-m-j H:i:s");
		$requete = "INSERT INTO `pma`.`personnel` (
			`Pers_ID` ,
			`Pers_Nom` ,
			`Pers_Prenom` ,
			`civilite_ID` ,
			`perso_cat_ID` ,
			`org_ID` ,
			`service_ID` ,
			`pers_Maj` ,
			`delai_route` ,
			`photo` ,
			`passport_no` ,
			`passport_date` ,
			`passport_qui` ,
			`rpps` ,
			`adresse_ID`,
			`visible`)
		VALUES (
			NULL , '$nom', '$prenom', '$_REQUEST[civilite_type]', '$_REQUEST[prof_type]', '$_REQUEST[orgID]', '$_REQUEST[the_service]',
			'$date_maj', '$delai_route', 'NULL', '$passport_no', '$passport_date', '$passport_qui', '$rpps', '$adresse','$_REQUEST[o_n]')";

		$resultat = ExecRequete($requete,$connexion);
		$maj = mysql_insert_id();
	}
	else
	{
		//print("Une personne du même nom existe déjà... ");
		//print("<A HREF = \"vecteurs_maj.php\">Continuer");
	}	
}
//print($requete);

$fichier= $_FILES['photo_victime']['name'];
$taille= $_FILES['photo_victime']['size'];
$tmp= $_FILES['photo_victime']['tmp_name'];
$type= $_FILES['photo_victime']['type'];
$erreur= $_FILES['photo_victime']['error'];

if($taille > 0 && $erreur == 0)
{
	$destination = "photos/personnel/".$maj.".jpg";
	//echo"nouveau nom => $destination. <br />";
	move_uploaded_file($tmp, $backPathToRoot.$destination);
	chmod ($backPathToRoot.$destination,07777);
	$requete="UPDATE personnel SET 	photo = '$destination' WHERE Pers_ID = '$_REQUEST[maj]'";
	$resultat = ExecRequete($requete,$connexion);
}

//print($requete."<br>\n");
header("Location:".$_REQUEST['back']."?personnelID=$maj&type=$_REQUEST[prof_type]&organisme=$_REQUEST[org_type]&auto=$auto");
?>
