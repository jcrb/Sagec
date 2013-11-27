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
//-------------------------------------------------------------------------------------------------------
/**
* garde_assu_cus.php
* permet de saisir le tableau de garde des ASSU sur la CUS et de le modifier
*
* @author Jean-Claude Bartier
* @version 1.3
* @copyright jcb
*/
//-------------------------------------------------------------------------------------------------------
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require("utilitaire_tr.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$aujourdui = $_GET['date'];
if(!$aujourdui)$aujourdui= getdateCourante();

print("<head>");
print("<title>menu assu</title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<form name=\"tab_gard\" METHOD=\"GET\" ACTION=\"enregistre_garde_cus.php\">");
print("<input type=\"hidden\" name=\"date\" value=\"$aujourdui\">");
print("<FIELDSET class=\"time_v\">");
print("<legend> $aujourdui </legend>");
//------------------------------ récupérer les ASSU actives ------------------------------
$requete = "SELECT apa_assu.org_ID,org_nom FROM apa_assu,organisme WHERE secteur_apa_ID = 6 AND apa_assu.org_ID = organisme.org_ID";
$resultat = ExecRequete($requete,$connexion);
while($rub=mysql_fetch_array($resultat))
{
	$assu_nom[]=$rub[org_nom];
	$assu_org[]=$rub[org_ID];
}
@mysql_free_result($resultat);
//for($i=0;$i<count($assu_org);$i++)
//	print($assu_org[$i]." ".$assu_nom[$i]."<br>");
//-------------------------------------------Tableau -----------------------------------
print($aujourdui."<br>");
$requete="SELECT org_ID,periode,ordre FROM garde_cus WHERE date = '$aujourdui'";
$resultat = ExecRequete($requete,$connexion);
//$garde=mysql_fetch_array($resultat);
while($rub=mysql_fetch_array($resultat))
{
	//$garde[]=$rub['org_ID'];
	//$periode[]=$rub['periode'];
	//$ordre[]=$rub['ordre'];
	$A[$rub['periode']][$rub['ordre']] = $rub['org_ID'];
	if($rub['periode']=="J")$max_jour++;
	else $max_nuit++;
}
$max_jour--;
$max_nuit--;
/*
$j="J";
for($i=0;$i<6;$i++)
{
	print($A["J"][$i]."<br>");
	print($A["N"][$i]."<br>");
}*/

print("<TABLE WIDTH=\"100%\">");
print("<TR>");
	print("<td>&nbsp;</td>");
	print("<td>Jour</td>");
	print("<td>Nuit</td>");
print("</TR>");

//--------------------------------- afficher le tableau ----------------------------------
// $assu_nom = tableau des 5 ASSU disponibles
// $assu_org = tableau des org_ID des 5 ASSU disponibles
// $A[periode][ordre] = tableau des ASSU de gardes pour ce jour
$moment="J";
$ordre = $max_jour;
/**
*	$nb_assu_disponible
*	Limite à 5 le nombre d'ASSU simultannément disponibles sur la CUS
*/
$nb_assu_disponible = 5;
for($i=0;$i<$nb_assu_disponible;$i++)
{
	print("<TR>");
	for($j=0;$j<3;$j++)
	{
		$n = $i+1;
		if($j==0)print("<td>ASSU $n</td>");
		else
		{
			print("<td>");
			print("<select name=\"ID_assu[]\" size=\"1\">");
			print("<OPTION VALUE = \"0\">-- choisir --</OPTION> \n");
			for($k=0;$k<count($assu_nom);$k++)
			{
				print("<OPTION VALUE=\"$assu_org[$k]\" ");
				if($assu_org[$k] == $A[$moment][$ordre]) print(" SELECTED");
				print(">$assu_nom[$k]</OPTION> \n");
			}
			print("</SELECT>\n");
			print("</td>");
			if($moment=="J")
			{
				$moment="N";
				$max_jour--;
				$ordre = $max_nuit;
			}
			else
			{
				$moment="J";
				$max_nuit--;
				$ordre = $max_jour;
			}
		}
	}
	print("</TR>");
}
print("<TABLE>");
//--------------------------------------------------------------------------------------
print("</FIELDSET>");
print("<input TYPE=\"submit\" VALUE=\"Valider\" NAME=\"btn1\">");
print("</form>");
?>
