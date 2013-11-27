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
$backPathToRoot = ""; 
require($backPathToRoot."dbConnection.php");
include($backPathToRoot."login/init_security.php");
include("date.php");

$date_u = Security::esc2Db(fDate2unix($_REQUEST['passport_date']));// date française en timestamp unix
$auto = $_REQUEST[auto];

// teste s'il existe un individu ayant le même nom
function intervenant_existe($nom,$connexion)
{
	if(Security::esc2Db($_REQUEST['maj'] == 0))// uniquement si demande de création
	{
		$nom = Security::esc2Db($_REQUEST[nom]);
		$prenom = Security::esc2Db($_REQUEST[prenom]);
		$requete="SELECT Pers_Nom,Pers_Prenom FROM personnel WHERE Pers_Nom = '$nom' AND Pers_Prenom = '$prenom'";
		$resultat = ExecRequete($requete,$connexion);
		$n = mysql_num_rows($resultat);
		//$donnees = mysql_fetch_array($resultat);
		if($n > 0)return true;
		else return false;
	}
}

$maj = $_REQUEST['maj'];
$_SESSION["localisation"] = $_REQUEST[localisation_type];

$nom = Security::esc2Db($_REQUEST[nom]);
$prenom = Security::esc2Db($_REQUEST[prenom]);
$passport_no = Security::esc2Db($_REQUEST[passport_no]);
$passport_qui = Security::esc2Db($_REQUEST[passport_qui]);


if($_REQUEST['maj'])
{	// update du vecteur
	$date_maj = date("Y-m-j H:i:s");// format compatible mysql;
	$requete="UPDATE personnel SET 	Pers_ID = '$_REQUEST[maj]',
								Pers_Nom = '$nom',
								Pers_Prenom = '$prenom',
								civilite_ID = '$_REQUEST[civilite_type]',
								perso_cat_ID = '$_REQUEST[prof_type]',
								Pers_fonction = '',
								org_ID = '$_REQUEST[orgID]',
								service_ID = '$_REQUEST[the_service]',
								tel1 = '$_REQUEST[tel1]',
								tel2 = '$_REQUEST[tel2]',
								tel3 = '$_REQUEST[tel3]',
								fax = '$_REQUEST[fax]',
								mail1 = '$_REQUEST[mail1]',
								mail2 = '$_REQUEST[mail2]',
								bip = '$_REQUEST[bip]',
								Pers_Maj = '$date_maj',
								delai_route = '$_REQUEST[delai_route]',
								localisation_ID = '$_REQUEST[localisation_type]',
								fonction_ID = '$_REQUEST[id_fonction]',
								portatif1 = '$_REQUEST[radio1]',
								portatif2 = '$_REQUEST[radio2]',
								tel_crise1 = '$_REQUEST[tel_crise1]',
								vecteur_ID = '$_REQUEST[vecteur_engage_ID]',
								passport_no = '$passport_no',
								passport_date = '$date_u',
								passport_qui = '$passport_qui',
								rpps = '$_REQUEST[rpps]'
							WHERE Pers_ID = '$_REQUEST[maj]'";
	$resultat = ExecRequete($requete,$connexion);
}
else
{
	if(!intervenant_existe($nom,$connexion))
	{	// Création du vecteur
		$date_maj = date("Y-m-j H:i:s");
		$requete="INSERT INTO personnel VALUES ('','$nom',
								'$prenom',
								'$_REQUEST[civilite_type]',
								'$_REQUEST[prof_type]',
								'',
								'$_REQUEST[orgID]',
								'$_REQUEST[the_service]',
								'$_REQUEST[date_maj]',
								'$_REQUEST[tel1]',
								'$_REQUEST[tel2]',
								'$_REQUEST[tel3]',
								'$_REQUEST[fax]',
								'$_REQUEST[mail1]',
								'$_REQUEST[mail2]',
								'$_REQUEST[bip]',
								'',
								'',
								'',
								'',
								'$_REQUEST[delai_route]',
								'$_REQUEST[localisation_type]',
								'$_REQUEST[id_fonction]',
								'',
								'$_REQUEST[radio1]',
								'$_REQUEST[radio2]',
								'$_REQUEST[tel_crise1]',
								'$_REQUEST[vecteur_engage_ID]',
								'$passport_no',
								'$date_u',
								'$passport_qui',
								'$_REQUEST[rpps]'
								)";
		$resultat = ExecRequete($requete,$connexion);
		$maj = mysql_insert_id();
	}
	else
	{
		print("Une personne du même nom existe déjà... ");
		print("<A HREF = \"vecteurs_maj.php\">Continuer");
	}	
}

$fichier= $_FILES['photo_victime']['name'];
$taille= $_FILES['photo_victime']['size'];
$tmp= $_FILES['photo_victime']['tmp_name'];
$type= $_FILES['photo_victime']['type'];
$erreur= $_FILES['photo_victime']['error'];
/*
echo"Nom originel => $fichier <br />";
echo"Taille => $taille <br />";
echo"Adresse temporaire sur le serveur => $tmp <br />";
echo"Type de fichier => $type <br />";
echo"Code erreur => $erreur. <br />";
*/
if($erreur == 0){
	$destination = "photos/personnel/".$maj.".jpg";
	//echo"nouveau nom => $destination. <br />";
	move_uploaded_file($tmp, $destination);
	chmod ($destination,07777);
	$requete="UPDATE personnel SET 	photo = '$destination' WHERE Pers_ID = '$_REQUEST[maj]'";
	$resultat = ExecRequete($requete,$connexion);
}
//print($requete."<br>\n");
header("Location:".$_REQUEST['back']."?personnelID=$maj&type=$_REQUEST[prof_type]&organisme=$_REQUEST[org_type]&auto=$auto");
?>
