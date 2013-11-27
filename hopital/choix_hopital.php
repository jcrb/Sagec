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
//----------------------------------------- SAGEC ---------------------------------------------
//
//	programme: 		choix_hopital.php
//	date de création: 	18/08/2008
//	auteur:			jcb
//	description:
//	version:			1.0
//	maj le:			18/08/2008
//
//---------------------------------------------------------------------------------------------
/**
* Règles applicables à la saisie des victimes
* 
* Limiter le nombre d'hôpital à afficher
*/
session_start();
//if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$langue = $_SESSION['langue'];
$member_id = $_SESSION['member_id'];
$path="../";
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../"; 
include_once($backPathToRoot."dbConnection.php");
$listeID = 2; //n°de la liste pour la table hopital_visible NB: NE PAS MODIFIER
?>

<head><meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<script src="../ajax/ajax.js" type="text/javascript"></script>
<script src="../ajax/JSON.js" type="text/javascript"></script>
<LINK REL ="stylesheet" TYPE ="text/css" HREF ="hopital2.css">
<script>
	function vide()
	{
	if(objet_hxr.readyState == 4)
	{
		if(objet_hxr.status == 200)
		{
		}
		else
		{
			alert("Erreur serveur: "+objet_hxr.status+" - "+objet_hxr.statusText);
			objet_hxr.abort();
			objet_hxr = null;
		}
	}
	}
	function check(n)
	{
		objet_hxr = createXHR();
		var cases = document.getElementsByTagName('input');
		for(var i=0; i<cases.length; i++)
		{
			if(cases[i].type == 'checkbox' && cases[i].value == n)
			{
				if(cases[i].checked)
				{
					objet_hxr.open("get","choix_hopital_enregistre.php?action=insert&value="+n,true);
				}
				else
				{
					objet_hxr.open("get","choix_hopital_enregistre.php?action=del&value="+n,true);
				}
				objet_hxr.onreadystatechange = vide;
				objet_hxr.send(null);
			}
		}
	}
</script>
</head>
<body>
<form name="liste">

<div id="entete">
	<p><b>Wählen Sie die Krankenhäuser zu aktualisieren</b></p>
</div>

<table bgcolor="#CCFFFF" id="grille">
<?php

//$requete = "SELECT Hop_nom, Hop_ID from hopital ORDER BY Hop_nom";
$zone = 100;
$requete = "SELECT hopital.Hop_ID,Hop_nom,ville_nom 
					FROM hopital,adresse,ville
					WHERE hopital.adresse_ID = adresse.ad_ID 
					AND adresse.ville_ID = ville.ville_ID 
					AND ville.zone_ID = '$zone'
					ORDER BY ville_nom
				";
$resultat = ExecRequete($requete,$connexion);

while($rub=mysql_fetch_array($resultat))
{
	$requete = "SELECT * FROM hopital_visible WHERE hop_ID = '$rub[Hop_ID]' AND org_ID='$_SESSION[organisation]' AND liste_ID = '$listeID'";
	$resultat2 = ExecRequete($requete,$connexion);
	$rep=mysql_fetch_array($resultat2);
	if($rep['hop_ID']) $check = "checked";else $check="";
	print("<tr>");
		print("<td align=\"left\"><input type=\"checkbox\" name=\"ch[]\" value=\"$rub[Hop_ID]\" $check onClick=\"check(".$rub[Hop_ID].")\">");
		print(" ".$rub[Hop_nom]."</td>");
		print("<td>".$rub[ville_nom]."</td>");
	print("</tr>");
}
?>
</table>
</form>
</body>