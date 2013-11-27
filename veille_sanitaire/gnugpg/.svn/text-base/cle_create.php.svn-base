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
//
//	programme: 		cle_create.php
//	date de création: 	15/05/2005
//	auteur:			jcb
//	description:		exporte une clé de cryptage
//	version:			1.0
//	maj le:			15/05/2005
//
//--------------------------------------------------------------------------------
//
//========================== Cryptographie =================================
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(! $_SESSION['auto_hopital'])header("Location:logout.php");

require('../gnugpg/gnuPG_class.inc');
require("../../html.php");
include("cle_menue.php");

// create the instance, giving the program path and home directory
$gpg = new gnuPG('/usr/local/bin/gpg', '/var/www/html/SAGEC67_v3/veille_sanitaire');

	// get the keys in the keyring
	print("<br>");
	print("Créer une clé<br><br>");
	print("Pas encore fonctionnel...<br><br>");

print("<form name=\"newkey\">");

print("<table>");
	print("<tr>");
		print("<td>nom associé à la clé</td>");
		print("<td><input type=\"text\" name=\"RealName\" value=\"\"></td>");
	print("</tr>");
	print("<tr>");
		print("<td>phrase de commentaire</td>");
		print("<td><input type=\"text\" name=\"Comment\" value=\"\"></td>");
	print("</tr>");
	print("<tr>");
		print("<td>email associé à la clé</td>");
		print("<td><input type=\"text\" name=\"mail\" value=\"\"></td>");
	print("</tr>");
	print("<tr>");
		print("<td>Pass phrase</td>");
		print("<td><input type=\"text\" name=\"Passphrase\" value=\"\"></td>");
		print("<td>Sorte de mot de passe. Elle doit être complexe, pas trop courte, difficile à trouver, mélanger des majuscules, minuscules, chiffres et symboles. Ex: Epg(3£9mVfAjpD!</td>");
	print("</tr>");
print("</table>");
print("<br><input type=\"submit\" name=\"Valider\" value=\"Valider\">");
print("</form>");

if($_GET['Valider'])
{
	$gpg->GenKey($RealName, $Comment, $Email, $Passphrase, 0, 'DSA', 1024, 'ELG-E', 1024);
	print("Create key<br>");
}

?>