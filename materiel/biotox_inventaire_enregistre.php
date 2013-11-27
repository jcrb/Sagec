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
//		
//----------------------------------------- SAGEC ---------------------------------------------//
//											 //
//	programme: 		biotox_inventaire_enregistre.php			//
//	date de création: 	02/02/2004							//
//	auteur:			jcb							//
//	description:		Création de cartes//
//	version:		1.0							//
//	maj le:			02/02/2004						//
//												 //
//---------------------------------------------------------------------------------------------//
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require("../biotox_utilitaires.php");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
/*
for($i=0; $i<count($_GET["qte"]);$i++)
{
	print($_GET["id_fournisseur"][$i]." | ".$_GET["id_acheteur"][$i]." | ".$_GET["qte"][$i]." | ".$_GET["date"][$i]."<br>");
}*/

if($_GET["num_rows"]==0)
{
	$qte=$_GET["qte"][0];
	$id_fournisseur=$_GET["id_fournisseur"][0];
	$id_acheteur=$_GET["id_acheteur"][0];
	$date=$_GET["date"][0];
	$requete="INSERT INTO dotation VALUES('',
				'$_GET[ville_id]',
				'$_GET[materiel_id]',
				'',
				'$qte',
				'$id_fournisseur',
				'$id_acheteur',
				'$date',
				'')";
}
else
{
	//$no=array();
	for($i=0; $i<$_GET["num_rows"];$i++)
	{
		$qte=$_GET["qte"][$i];
		$id_fournisseur=$_GET["id_fournisseur"][$i];
		$id_acheteur=$_GET["id_acheteur"][$i];
		$date=$_GET["date"][$i];
		$no=$_GET["inventaire"][$i];
		$requete="UPDATE dotation SET
				dotation_qte = '$qte',
				fournisseur_ID = '$id_fournisseur',
				acheteur_ID = '$id_acheteur',
				date_achat = '$date',
				marque_ID = ''
				WHERE dotation_ID ='$no'
				";
		//print($requete);
	}
}
$resultat = ExecRequete($requete,$connexion);
header("Location:stock_saisie.php?type_ville=$_GET[ville_id]&type_materiels=$_GET[materiel_id]&type_fournisseur=0");
?>
