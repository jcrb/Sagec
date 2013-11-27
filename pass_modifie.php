<?php
//----------------------------------------- SAGEC ------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003-2004 (Jean-Claude Bartier).
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
//----------------------------------------- SAGEC ----------------------------------------------//
//												//
//	programme: 		pass_modifie.php						//
//	date de création: 	28/03/2004							//
//	auteur:			jcb								//
//	description:		Modifie et crypte de façon irréversible un mot de passe		//
//	version:		1.0								//
//	maj le:			28/03/2004							//
//	Variables globales	$_GET[utilisateur]	utilisateur_ID				//
//----------------------------------------------------------------------------------------------//
//Liste des vecteurs
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
require("pma_connect.php");
require("pma_connexion.php");
require("pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
//
print("<HTML><HEAD><TITLE>Modifier un mot de passe</TITLE>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\"></HEAD>");
//
if($_POST[ok])
{
	if($_POST[pass1] == $_POST[pass2])
	{
		$pass=crypt(trim(htmlspecialchars(addslashes($_POST['pass1']))),"azerty");
		$requete= "UPDATE utilisateurs SET pass = '$pass' WHERE ID_utilisateur = '$_POST[utilisateur]'";
		$resultat = ExecRequete($requete,$connexion);
		print("<A HREF=\"utilisateurs_ajout.php?utilisateur= $_POST[utilisateur]\">Changement validé. Retour</A>");
	}
	else
	print("Erreur de saisie, recommencez");
}
print("<BODY>");
print("<FORM name =\"pass_modifie\"  ACTION=\"pass_modifie.php\" METHOD=\"POST\">");
print("<INPUT TYPE=\"hidden\" NAME=\"utilisateur\" VALUE=\"$_GET[utilisateur]\">");
print("Affecter un nouveau mot de passe à l'utilisateur ".$_GET[utilisateur]."<BR>");
print("<TABLE>");
	print("<TR>");
		print("<TD>");
			print("nouveau mot de passe: ");
			print("<INPUT TYPE=\"password\" NAME=\"pass1\">");
		print("</TD>");
	print("</TR>");
	print("<TR>");
		print("<TD>");
			print("confirmer mot de passe: ");
			print("<INPUT TYPE=\"password\" NAME=\"pass2\">");
		print("</TD>");
	print("</TR>");
print("</TABLE>");
print("<INPUT TYPE=\"submit\" NAME=\"ok\" VALUE=\"Valider\"><BR>");
print("</FORM></BODY></HTML>");
?>
