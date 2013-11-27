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
// Cr?ation / mise ? jour d'un zone
// zone.php
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
//
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
//=============================== Enregistrer les modifications ==============================
if($_GET['ok'] && $_GET['nom']){
	if($_GET['action']=='modidier'){
		$requete="UPDATE zone SET
				zone_nom = '$_GET[nom]',
				pays_ID = '$_GET[pays]'
				WHERE zone_ID = '$_GET[ID_zone]'
				";
		$resultat = ExecRequete($requete,$connexion);
	}
	else{
		$requete="INSERT INTO zone VALUES('$_GET[ID_zone]','$_GET[nom]','$_GET[pays]')";
		$resultat = ExecRequete($requete,$connexion);
		//$maj= mysql_insert_id();
	}
	//print($requete);
	$maj=$_GET['ID_zone'];
	header("Location:zone.php?zone_ID=$maj");
}
elseif($_GET['nouveau'])
{
	print("<input type=\"hidden\" name=\"action\" value=\"ajouter\">");
}
//=============================== Forme ==============================
print("<html>");
print("<head>");
print("<title> SAGEC 67 </title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");
//
print("<BODY onload=\"document.zone.nom_hop.focus()\">");
// cr?ation d'une form
print("<FORM name =\"zone\"  ACTION=\"zone.php\" METHOD=\"GET\">");
if($_GET['zone_ID']){
	$titre="Modifier un zone";
	$requete="SELECT*FROM zone WHERE zone_ID='$_GET[zone_ID]'";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	print("<input type=\"hidden\" name=\"action\" value=\"modifier\">");
}
else{
	$titre="Ajouter un zone";
}
print("<fieldset>");
print("<legend>$titre</legend>");
print("<table>");
	print("<tr>");
		print("<td>nom</td>");
		print("<td><input type=\"text\" name=\"nom\" value=\"$rub[zone_nom]\"></td>");
	print("</tr>");
	print("<tr>");
		print("<td>nœ zone</td>");
		print("<td><input type=\"text\" name=\"ID_zone\" value=\"$rub[zone_ID]\"></td>");
	print("</tr>");
	print("<tr>");
		print("<td>pays</td>");
		print("<td>");
			$requete="SELECT pays_ID, pays_nom FROM pays WHERE visible='o'";
			$resultat = ExecRequete($requete,$connexion);
			print("<select name=\"pays\" size=\"1\">");
			print("<OPTION VALUE = \"0\">[-- aucun --] </OPTION> \n");
			while($p=mysql_fetch_array($resultat))
			{
				print("<OPTION VALUE=\"$p[pays_ID]\" ");
				if($rub['pays_ID'] == $p['pays_ID']) print(" SELECTED");
				print("> $p[pays_nom] </OPTION> \n");
			}
			@mysql_free_result($resultat);
			print("</SELECT>\n");
		print("</td>");
	print("</tr>");
	print("<tr>");
		print("<td>&nbsp;</td>");
		print("<td><input type=\"submit\" name=\"ok\" value=\"valider\"></td>");
		print("<td><input type=\"submit\" name=\"nouveau\" value=\"Nouveau\"></td>");
	print("</tr>");
print("</table>");
print("</fieldset>");
//=============================== Liste des zone ==============================
$requete="SELECT * FROM zone";
$resultat = ExecRequete($requete,$connexion);
print("<table>");
	print("<tr>");
		print("<td>nom</td>");
		print("<td>num?ro</td>");
		print("<td>pays</td>");
	print("</tr>");
	while($rub=mysql_fetch_array($resultat)){
		print("<tr>");
		print("<td><a href=\"zone.php?zone_ID=$rub[zone_ID]\">$rub[zone_nom]</a></td>");
		print("<td>$rub[zone_ID]</td>");
		print("<td>$rub[pays_ID]</td>");
		print("</tr>");
	}
print("</table>");

print("</body>");
print("</html>");
?>
