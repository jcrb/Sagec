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
//	programme: 		resume.php
//	date de création: 	06/02/2005
//	auteur:			jcb
//	description:		saisies de constantes
//	version:			1.0
//	maj le:			06/02/2005
//
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../";
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."date.php");
$victime=$_REQUEST['dossier'];print("victime ID = ".$victime);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
  <head>
  <meta http-equiv="content-type" content="ent="text; charset=ISO-8859-1" f>
  <meta http-equiv="Content-Language" content="fr" />
  <title>Bilan Secouriste</title>
  <LINK REL="stylesheet" HREF="apa.css" TYPE ="text/css">
  <style type="text/css" media="screen">@import url(../sig/css/normal.css);</style>
   <!--[if IE]><style type="text/css" media="screen">@import url(../sig/css/ie.css);</style><![endif]-->
   <!--[if lte IE 6]><style type="text/css" media="screen">@import url(../sig/css/ie6.css);</style><![endif]-->
</head>


<body>
	<div id="en-tete">
 		<ul>
  			<li><a href="apa_nouvelle_victime.php"><span>Nouveau</span></a></li>
  			<li><a href="apa_liste_victimes.php"><span>Liste</span></a></li>
  			<li><a href=""><span> Dossier Med </span></a></li>
  			<li id="actif"><a href="apa_resume.php?victime=$victimeID"><span> Résumé </span></a></li>
 		</ul>
 	</div>

<?php

//sélection des données

$requete = "SELECT date,exam_ID,resultat 
				FROM dm_constantes2 
				WHERE victime_ID = '$victime' 
				ORDER BY date DESC,exam_ID";
$resultat = ExecRequete($requete,$connexion);
while($rub = mysql_fetch_array($resultat))
{
	$date[$rub[date]] = $rub[date];
	$data[$rub[date]][$rub[exam_ID]] = $rub[resultat];
}

print("Tableau des constantes <br>");
print("<table border=\"1\" cellspacing=\"0\">");
print("<tr>");
	print("<td>date</td>");
	print("<td> Fc </td>");
	print("<td> PAs </td>");
	print("<td>PAd</td>");
	print("<td>Fr</td>");
	print("<td>SaO2</td>");
	print("<td>EtCO2</td>");
	print("<td>Diurèse</td>");
	print("<td>Glycémie</td>");
	print("<td>GCS</td>");
	print("<td>Temp</td>");
print("</tr>");

	foreach($date as $k)
	{
		print("<tr>");
		print("<td>".uDatetime2French($k)."</td>");
		for($j=1;$j<11;$j++)
		{
			if($data[$k][$j]>0)
				print("<td align=\"center\">".$data[$k][$j]."</td>");
			else
				print("<td>&nbsp;</td>");
		}
		print("</tr>");
	}
print("</table>")
?>
</body>
</html>