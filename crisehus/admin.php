<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003-2005 (Jean-Claude Bartier).
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
//----------------------------------------- SAGEC --------------------------------
/**
*	programme: 		admin.php.php
*	date de cr�ation: 	08/12/2005
*	auteur:			jcb
*	description:
*	@version:		$Id: admin.php 36 2008-02-22 16:05:49Z jcb $
*	maj le:			08/12/2005
*/
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(! $_SESSION['auto_sagec'] && !$_SESSION['autorisation']==10)
	header("Location:../logout.php");
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$null ="0";

print("<form name=\"raz\" action=\"admin.php\" method=\"get\">");
print("Remise � z�ro des param�tres du programme<hr>");

print("<table>");
print("<input type=\"checkbox\" name=\"blocnote\"> r�initialisation de la main courante et de la liste des taches<br>");
print("</table>");

print("<br><input type=\"submit\" name=\"ok\" value=\"R�initialiser\"> ");
print("<input type=\"submit\" name=\"ok\" value=\"Annuler\"><br>");

//==============================  remise � 0 de la main courante ===================================
	if($_GET['blocnote'])
	{
		$requete = "DELETE FROM livrebord_service WHERE LBS_groupe = 2";
		$resultat = ExecRequete($requete,$connexion);
		print("Main courante effac�e<br>");
		$requete = "UPDATE tache_DG SET tache_faite = 'n',tache_heure=''";
		$resultat = ExecRequete($requete,$connexion);
		print("<br>Liste des taches effac�e<br>");
	}

print("<br><hr>");
?>
<a href="admin_check_main.php">Mise � jour des check-listes</a>
<br><hr>
<a href="cc_lits_planBlanc_update.php">Mise � jour des lits disponibles</a>
<br><hr>
<a href="cc_main.php">Menu principal</a>