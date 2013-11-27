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
//	programme: 		stockage_enregistre.php
//	date de cr?ation: 	15/10/2004
//	auteur:			jcb
//	description:		enregistre les caract?ristiques d'un m?dicament
//	version:			1.0
//	maj le:			15/10/2004
//
//--------------------------------------------------------------------------------------------------------
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
//
// nouveau m?dicament
// v?rifie qu'il n'existe pas
/*
$requete1="SELECT conteneur_ID FROM medicament WHERE medic_nom = '$_GET[ID_special]'
								AND medic_dci = '$_GET[ID_dci]'
								AND medic_presentation = '$_GET[present]'
								AND medic_dosage = '$_GET[poso]'
								AND medic_volume = '$_GET[volume]'
								";
$resultat1 = ExecRequete($requete1,$connexion);
if(!$rub=mysql_fetch_array($resultat1))
*/
if($_GET[ok]=='enregistrer')
{
	$requete="INSERT INTO stock_conteneur VALUES('',
								'$_GET[ID_psm]',
								'$_GET[no_malle]',
								'',
								'$_GET[ID_stock]',
								'$_GET[ID_medlocal]',
								'$_GET[ID_stockage]'
								)";
	$resultat = ExecRequete($requete,$connexion);
	$maj = mysql_insert_id();
}
else if($_GET[ok]=='modifier')
{
	$requete = "UPDATE stock_conteneur SET	med_type_stock = '$_GET[ID_stock]',
								med_localisation = '$_GET[ID_medlocal]',
								conteneur_nom = '$_GET[ID_psm]',
								conteneur_no = '$_GET[no_malle]',
								stockage_ID = '$_GET[ID_stockage]'
							WHERE conteneur_ID = '$_GET[maj]'";
	$resultat = ExecRequete($requete,$connexion);
	$maj = $_GET[maj];
}
else if($_GET[ok]=='supprimer')
{

}
//
//print($requete1."<br>");
//print($requete."<br>");
header("Location:stockage_saisie.php?stock=$maj");
?>
