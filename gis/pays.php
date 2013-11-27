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
// Création / mise à jour d'un pays
// pays.php
// version 1.2
// auteur jcb
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
	if($_GET['ID_pays']){
		$requete="UPDATE pays SET
				pays_nom = '$_GET[nom]',
				pays_prefixe = '$_GET[tel]',
				visible = '$_GET[visible]',
				iso2 = '$_GET[iso2]',
				iso3 = '$_GET[iso3]',
				iso_number = '$_GET[iso_number]'
				WHERE pays_ID = '$_GET[ID_pays]'
				";
		$resultat = ExecRequete($requete,$connexion);
		$maj=$_GET['ID_pays'];
	}
	else{
		$requete="INSERT INTO pays VALUES('','$_GET[nom]','$_GET[tel]','$_GET[visible]','$_GET[iso2]','$_GET[iso3]','$_GET[iso_number]')";
		$resultat = ExecRequete($requete,$connexion);
		$maj= mysql_insert_id();
	}
	//print($requete);
	header("Location:pays.php?pays_ID=$maj");
}
//=============================== Forme ==============================
print("<html>");
print("<head>");
print("<title> SAGEC 67 </title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");
//
print("<BODY onload=\"document.pays.nom_hop.focus()\">");
// création d'une form
print("<FORM name =\"pays\"  ACTION=\"pays.php\" METHOD=\"GET\">");
if($_GET['pays_ID']){
	$titre="Modifier un pays";
	$requete="SELECT*FROM pays WHERE pays_ID='$_GET[pays_ID]'";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	print("<input type=\"hidden\" name=\"ID_pays\" value=\"$_GET[pays_ID]\">");
}
else{
	$titre="Ajouter un pays";
}
print("<fieldset>");
print("<legend>$titre</legend>");
print("<table>");
	print("<tr>");
		print("<td>nom</td>");
		print("<td><input type=\"text\" name=\"nom\" value=\"$rub[pays_nom]\"></td>");
		print("<td>code ISO 3166 à 2 lettres</td>");
		print("<td><input type=\"text\" name=\"iso2\" value=\"$rub[iso2]\"></td>");
	print("</tr>");
	print("<tr>");
		print("<td>préfixe tel</td>");
		print("<td><input type=\"text\" name=\"tel\" value=\"$rub[pays_prefixe]\"></td>");
		print("<td>code ISO 3166 à 3 lettres</td>");
		print("<td><input type=\"text\" name=\"iso3\" value=\"$rub[iso3]\"></td>");
	print("</tr>");
	print("<tr>");
		print("<td>visible</td>");
		if($rub['visible'])
		print("<td class=\"time\"><INPUT TYPE=\"CHECKBOX\"  NAME=\"visible\" CHECKED value=\"o\"></td>");
	else
		print("<td class=\"time_b\"><INPUT TYPE=\"CHECKBOX\"  NAME=\"visible\" checked ></td>");
		print("<td>code ISO 3166 à 3 chiffres</td>");
		print("<td><input type=\"text\" name=\"iso_number\" value=\"$rub[iso_number]\"></td>");
	print("</tr>");
	print("<tr>");
		print("<td>&nbsp;</td>");
		print("<td><input type=\"submit\" name=\"ok\" value=\"valider\"></td>");
	print("</tr>");
print("</table>");
print("</fieldset>");
//=============================== Liste des pays ==============================
$requete="SELECT * FROM pays ORDER BY pays_nom";
$resultat = ExecRequete($requete,$connexion);
print("<table>");
	print("<tr>");
		print("<td>nom</td>");
		print("<td>préfixe</td>");
		print("<td>visible</td>");
		print("<td>ISO 2</td>");
		print("<td>ISO 3</td>");
		print("<td>ISO code</td>");
	print("</tr>");
	while($rub=mysql_fetch_array($resultat)){
		print("<tr>");
		print("<td><a href=\"pays.php?pays_ID=$rub[pays_ID]\">$rub[pays_nom]</a></td>");
		print("<td><div align=\"right\">$rub[pays_prefixe]</div></td>");
		print("<td><div align=\"middle\">$rub[visible]</div></td>");
		
		print("<td><div align=\"middle\">$rub[iso2]</div></td>");
		print("<td><div align=\"middle\">$rub[iso3]</div></td>");
		print("<td><div align=\"middle\">$rub[iso_number]</div></td>");
		print("</tr>");
	}
print("</table>");

print("</body>");
print("</html>");
?>
