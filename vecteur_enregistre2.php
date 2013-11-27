<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// Foobar is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//		
//---------------------------------------------------------------------------------------------------------
//																										 //
//	programme: 			vecteur_enregistre																	 //
//	date de création: 	19/08/2003																		 //
//	auteur:				jcb																				 //
//	description:		enregistre un nouveau vecteur ou met à jour									 //
//	version:			1.1																				 //
//	maj le:				06/09/2003																		 //
//	appelé par:			vecteur_maj.php
// 	Variables transmises	$nom	nom du vecteur
//						 	$maj	correspond à Vec_ID. Vaut 0 si maj et à Vec_ID sinon
//							$engage	vaut oui si cochée, n'est pas transmise sinon'
//							$type_v	état du vecteur
//							$Type_de_vecteur
//							$indicatif
//							$tel																									 //
//---------------------------------------------------------------------------------------------------------
require("pma_connect.php");
require("pma_connexion.php");
require("pma_requete.php");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$Type_de_vecteur += 1;

// teste s'il existe un vecteur ayant le même nom
function vecteur_existe($nom,$connexion)
{
	if($maj == 0)// uniquement si demande de création
	{
		$requete="SELECT Vec_Nom FROM vecteur WHERE Vec_Nom = '$nom'";
		$resultat = ExecRequete($requete,$connexion);
		$donnees = mysql_fetch_array($resultat);
		if($donnees)return true;
		else return false;
	}
}

if($maj)
{	// update du vecteur
	$date_maj = time();
	$requete="UPDATE vecteur SET 	Vec_ID = '$maj',
								Vec_Nom = '$nom',
								Vec_Engage = '$engage',
								Vec_Etat = '$type_v',
								Vec_Type = '$v_type',
								Vec_Indicatif = '$indicatif',
								Vec_Tel = '$tel',
								Vec_Maj = '$date_maj',
								org_ID = '$org_type'
							WHERE Vec_ID = '$maj'";
	$resultat = ExecRequete($requete,$connexion);
	//print($requete."<br>\n");
}
else
{
	if(!vecteur_existe($nom,$connexion))
	{	// Création du vecteur
		$date_maj = time();
		$requete2="INSERT INTO vecteur VALUES ('','$nom','$engage','$type_v','$v_type','$indicatif','$tel','$date_maj','$org_type')";
		$resultat = ExecRequete($requete2,$connexion);
		//print($requete2);
	}
	else
	{
		print("Un vecteur du même nom existe déjà... ");
		print("<A HREF = \"vecteurs_maj.php\">Continuer");
	}
		
}
header("Location:vecteur_maj.php");

?>
