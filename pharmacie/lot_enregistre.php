<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
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
//----------------------------------------- SAGEC --------------------------------------------------------
//
//	programme: 		lot_enregistre.php
//	date de cr?ation: 	15/10/2004
//	auteur:			jcb
//	description:		enregistre les caract?ristiques d'un m?dicament
//	version:			1.0
//	maj le:			15/10/2004
//
//--------------------------------------------------------------------------------------------------------
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../";
require($backPathToRoot."dbConnection.php");

require $backPathToRoot.'utilitaires/globals_string_lang.php';


print_r($_REQUEST);

$ID_med = $_REQUEST['ID_med'];
$qte = $_REQUEST['qte'];
$stock = $_REQUEST['stock'];
$peremption = $_REQUEST['peremption'];
$local = $_REQUEST['ID_medlocal'];
$rangement = $_REQUEST['ID_psm'];
$malle = $_REQUEST['identifiant'];

$bouton = $_REQUEST['ok'];
$cat = $_REQUEST['cat'];


$requete="SELECT conteneur_ID FROM stock_conteneur
		WHERE med_localisation = '$_GET[ID_medlocal]'
		AND conteneur_nom = '$_REQUEST[ID_psm]'
		AND conteneur_no = '$_REQUEST[identifiant]'";
$resultat = ExecRequete($requete,$connexion);
$c = mysql_fetch_array($resultat);
$conteneur = $c['conteneur_ID'];

//print($requete."<br>");
//print($conteneur);


if(!$conteneur)
	$bouton = '';// on annule tout
	
$maj = $_REQUEST['maj'];

if($bouton == 'modifier')				/* modification */
{
	$requete = "UPDATE med_lot SET 	medic_ID = '$ID_med',
								med_lot_qte = '$qte',
								med_lot_perime = '$peremption',
								conteneur_ID = '$local',
								categorie = '$rangement',
								stock_actuel = '$stock'
							WHERE med_lot_ID = '$_REQUEST[maj]'";
	$resultat = ExecRequete($requete,$connexion);
	$id = $maj;
}
else if($bouton == 'enregistrer')	/* insertion */
{
	$requete="INSERT INTO med_lot VALUES('',
								'$_GET[ID_med]',
								'$_GET[qte]',
								'$_GET[peremption]',
								'$conteneur',
								'$cat'
								)";
	$resultat = ExecRequete($requete,$connexion);
	$id = mysql_insert_id();
}
else if($bouton == 'dupliquer')		/* nouvelle insertion */
{
	$requete="INSERT INTO med_lot VALUES('',
								'$_GET[ID_med]',
								'$_GET[qte]',
								'$_GET[peremption]',
								'$conteneur',
								'$cat'
								)";
	$resultat = ExecRequete($requete,$connexion);
	$id = mysql_insert_id();
}
else if($bouton == 'supprimer')		/* suppression */
{
	$requete="DELETE FROM med_lot WHERE med_lot_ID = '$maj'";
	ExecRequete($requete,$connexion);
	$id = '';
}

//
//print($requete1."<br>");
print($requete."<br>");
/*
if($cat == 1)
	header("Location:medicament_lot.php?lot=$id");
else
	header("Location:materiel_lot.php?lot=$id");
	*/
?>
