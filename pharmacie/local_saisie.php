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
//----------------------------------------- SAGEC --------------------------------------------------------
//
//	programme: 		local_saisie.php
//	date de création: 	30/01/2005
//	auteur:			jcb
//	description:		saisie/modification d'une zone de stockage
//	version:			1.0
//	maj le:			30/01/2005
//
//--------------------------------------------------------------------------------------------------------

session_start();
//if(! $_SESSION['auto_sagec'])header("Location:logout.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../"; 
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");

//include_once("./utilitaires_MED.php");
include_once($backPathToRoot."utilitaires/table.php");
require_once $backPathToRoot.'utilitaires/globals_string_lang.php';
include_once($backPathToRoot."utilitairesHTML.php");
//include_once("utilitaires_MED.php");
?>
<html>
<head>
	<title> local_saisie </title>
	<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">
	<LINK REL=stylesheet TYPE = \"text/css\" HREF = \"pharma.css\">
	<SCRIPT>
		function Choix()
		{
			document.local.submit();
		}
		function open_popup_window(n,v,organisme)
		{
			switch(n)
			{
				case 'new_batiment':url = "batiment_saisie.php?org="+organisme;break;
				case 'rename_batiment':url = "batiment_saisie.php?maj="+v+"org="+organisme;break;
			}
        	args = 'toolbar=no,location=no,directories=no,status=no,menubar=no,' +
                'scrollbars=no,resizable=yes,' +
                'width=480,height=200,left=20,top=20';
        	result = window.open(url, "whatever", args);
	   	window.opener.location.reload();//rafraichissement de la page
		}
	</SCRIPT>
</head>
<body BGCOLOR="#ffffff">
	<form name ="local"  ACTION="local_saisie.php" METHOD="GET">

<?php

print("local: ".$_REQUEST['local']."<br>");
if($_REQUEST['local'])// c'est une mise à jour
{
	$requete="SELECT *
	 		FROM stockage
			WHERE stockage_ID = '$_REQUEST[local]'
			";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	print("<p>Modifier un local de stockage</p>");
	print("<INPUT TYPE=\"HIDDEN\" NAME=\"local\" VALUE=\"$_GET[local]\">");
}
else
	print("<p>Nouveau local de stockage</p>");

print("<table>");

print("<tr>");
	print("<td>Localisation</td>");
	print("<td>");
		SelectOrganisme($connexion,$rub['org_ID'],$langue,$onChange="Choix()");//$org_type
	print("</td>");
	print("<td>&nbsp;</td>");
print("</tr>");

print("<tr>");
	print("<td>Bâtiment</td>");
	print("<td>");
		SelectBatiment($connexion,$rub['org_ID'],$rub['stockage_batiment_ID'],$langue,$onChange="");//$ID_batiment
		if($_GET['local'])// c'est une mise à jour
			print("<input type=\"button\" name=\"rename_batiment\" value=\"Modifier\"onclick=\"open_popup_window('rename_batiment',$rub[stockage_batiment_ID],$rub[org_ID])\">");

	print("</td>");
	print("<td><input type=\"button\" name=\"new_batiment\" value=\"Nouveau\"
	 onclick=\"open_popup_window('rename_batiment','0',$rub[org_ID])\"></td>");
print("</tr>");

print("<tr>");
	print("<td>Etage</td>");
	print("<td><input type=\"text\" name=\"etage\" value=\"$rub[stockage_etage]\"></td>");
	print("<td>&nbsp;</td>");
print("</tr>");
print("<tr>");
	print("<td>Local</td>");
	print("<td><input type=\"text\" name=\"piece\" value=\"$rub[stockage_local]\"></td>");
	print("<td>&nbsp;</td>");
print("</tr>");
print("<tr>");
	print("<td>&nbsp;</td>");
	print("<td><input type=\"submit\" name=\"ok\" value=\"Validez\"></td>");
	print("<td>&nbsp;</td>");
print("</tr>");
print("</table>");
?>
</body>
</html>