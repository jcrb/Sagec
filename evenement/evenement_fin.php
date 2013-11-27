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
//
//	programme: 		evenement_fin.php
//	date de création: 	12/11/2004
//	auteur:			jcb
//	description:
//	version:			1.0
//	maj le:			12/11/2004
//
//---------------------------------------------------------------------------------------------//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../pma_connect.php");
require("../pma_connexion.php");
require '../utilitaires/requete.php';

print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<BODY>");
print("<FORM ACTION =\"evenement_fin.php\" METHOD=\"GET\">");
$connect = Connexion(NOM,PASSE,BASE,SERVEUR);

if($_GET['ok'])
{
	/** cloture de l'évènement courant */
	$requete = "UPDATE evenement SET evenement_actif = 'clos' WHERE avenement_ID = '$_SESSION[evenement]'";
	$result = ExecRequete($requete,$connect);
	/** mise à zero de l'evènement courant */
	$_SESSION['evenement'] = 1;
	$requete = "UPDATE alerte SET evenement_ID = '1'";
	$result = ExecRequete($requete,$connect);
	$_SESSION["evenement"] = 1;
	print("<br>TOUTES LRS OPERATIONS EN COURS SONT TERMINEES - CLOTURE DE LA SESSION</br>");
	
	/**
	*	@TODO sauvegarder les données
	*/
}
else
{
	print("Confirmez la fin des opérations: ");
	print("<input type=\"submit\" name=\"ok\" value=\"confirmez\">");
}
?>