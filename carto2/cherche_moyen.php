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
//													//
//	programme: 		cherche_moyen.php							//
//	date de création: 	15/04/2004								//
//	auteur:			jcb									//
//	description:		Affiche un entête		//
//	version:		1.0									//
//	maj le:			15/04/2004								//
//													//
//--------------------------------------------------------------------------------------------------------
//
//--------------------------------------------------------------------------------------------------------
session_start();
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
/*
$requete = "SELECT ville_nom, ville_lambertX, ville_lambertY
		FROM ville, organisme, hopital
		WHERE ville.ville_ID = organisme.org_ID
		AND organisme.org_ID = hopital.org_ID
		";*/
$requete = "SELECT ville_nom, ville_lambertX, ville_lambertY,organisme.org_ID
		FROM ville, organisme,hopital
		WHERE ville.ville_ID = organisme.ville_ID
		AND organisme.org_ID = hopital.org_ID
		AND Hop_Smur = 'o'
		";
$resultat = $resultat = ExecRequete($requete,$connexion);
print("Résultat<BR>");
while($rub = mysql_fetch_array($resultat))
{
	print("- ".$rub[ville_nom]." ".$rub[ville_lambertX]." ".$rub[ville_lambertY]." // ".$rub[org_ID]."<BR>");
}
?>