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
//																							   //
//	programme: 			biotox_inventaire_maj.php													   //
//	date de création: 	02/02/2004															   //
//	auteur:				jcb																	   //
//	description:		Création de cartes
//														 				   //
//	version:			1.0																	   //
//	maj le:				02/02/2004										                       //
//																							   //  
//---------------------------------------------------------------------------------------------//
require("PMA_Connect.php");
require("PMA_Connexion.php");
require("PMA_Requete.php");
require("biotox_utilitaires.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
if($_GET['dotation_ID'])
{
	$requete = "UPDATE dotation SET 
					ville_ID = '$_GET[type_ville]',
					materiel_ID = '$_GET[type_materiels]',
					dotation_qte = '$_GET[qte]',
					fournisseur_ID = '$_GET[type_fournisseur]',
					acheteur_ID = '$_GET[type_acheteur]',
					date_achat = '$_GET[achat]',
					marque_ID = ''
					WHERE dotation_ID = '$_GET[dotation_ID]'";
}
else
{
	$requete = "INSERT INTO dotation VALUES(
												'',
												'$_GET[type_ville]',
												'$_GET[type_materiels]',
												'',
												'$_GET[qte]',
												'$_GET[type_fournisseur]',
												'$_GET[type_acheteur]',
												'$_GET[achat]',
												''
												)";
	$dotation_ID = mysql_affected_rows();
	
}
//print($requete);
$resultat = ExecRequete($requete,$connexion);
header("Location: biotox_inventaire_resultats.php");//?type_ville=$ville&type_materiels=$materiel


?>
