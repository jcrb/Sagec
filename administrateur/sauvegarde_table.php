<?php
//----------------------------------------- SAGEC --------------------------------------------------------

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
//	programme: 		sauvegarde_table.php
//	date de création: 	10/11/2004
//	auteur:			jcb
//	description:		sauvegarde des données dans un fichier
//	version:			1.2
//	maj le:			10/11/2004
//
//--------------------------------------------------------------------------------------------------------
// la liste s'affiche par ordre cronologique inverse
// la liste est rafraichie toutes les 30 secondes
// le nom du rédacteur apparait
//--------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];

include("../utilitaires/table.php");
require '../utilitaires/globals_string_lang.php';
require("../pma_connect.php");
require("../pma_connexion.php");
require '../utilitaires/requete.php';
require("../html.php");
require("utilitaires_table.php");
$tab = "\t";
$connect = Connexion(NOM,PASSE,BASE,SERVEUR);

print("<HTML><HEAD><TITLE>Sauvegarde</TITLE>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\"></HEAD>");

print("<FORM name =\"taches\"  ACTION=\"sauvegarde_table.php\" METHOD=\"get\">");

if($_GET['ok'])
{
	//======================= structure de la table =====================================
	$requete = "SHOW COLUMNS FROM $_GET[table]";
	$resultat = ExecRequete($requete,$connect);
	print("<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" class=\"Style22\">");
		print("<TR>");
			print("<td>Champ</td>");
			print("<td>Type</td>");
			print("<td>Null</td>");
			print("<td>Clé</td>");
			print("<td>Défaut</td>");
			print("<td>Extra</td>");
		print("</TR>");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<TR>");
			print("<td>$rub[Field]</td>");
			print("<td>$rub[Type]</td>");
			print("<td>$rub[Null]</td>");
			print("<td>$rub[Key]</td>");
			print("<td>$rub[Default]</td>");
			print("<td>$rub[Extra]</td>");
		print("</TR>");
	}
	print("</table></br>");
	//----------------------- fichier -------------------------------
	$racine="../temp/";
	$v = $racine.$_GET['table'].".txt";
	$fp = fopen($v,"w");
	//---------------------------------------------------------------

	$requete = "SELECT * FROM $_GET[table]";
	$resultat = ExecRequete($requete,$connect);
	print("<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" class=\"Style22\">");
	while($rub=mysql_fetch_array($resultat))
	{
		print("<TR>");
		$ligne="";
		for($i=0;$i<count($rub)/2;$i++)
		{
			$ligne.=$rub[$i].$tab;
			if($rub[$i]=="")
				print("<TD>&nbsp;</TD>");
			else
				print("<TD>$rub[$i]</TD>");
		}
		$ligne.= "\n";
		//----------------------- fichier -------------------------------
		fwrite($fp,$ligne);
		//---------------------------------------------------------------

		print("</TR>");
	}
	//----------------------- fichier -------------------------------
	fclose($fp);
	//---------------------------------------------------------------
	
	print("</table>");
}

print("Nom de la table: ");
listetable($connect);
//print("<input type=\"text\" name=\"table\" value=\"$v\">");table
print("<INPUT TYPE=\"submit\" NAME=\"ok\" VALUE=\"valider\">");

print("</HTML>");
?>
