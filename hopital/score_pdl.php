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
//--------------------------------------------------------------------------------------------------------
/** 
*	score_pdl.php
* 	Calcul du score PDL
*	date de création: 		 
*	@author:			jcb		  
*	@version:	$Id$	 
*	maj le:				
*	@package			sagec
*/
//--------------------------------------------------------------------------------------------------------
session_start();
require_once "utilitaires_hopital.php";
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require("../utilitaires/google/orthodro.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

print("<html>");
print("<head>");
	print("<title>page_test</title>");
	print("<meta http-equiv=\"content-type\" content=\"text/html; charset=iso-8859-1\" />");
	print("<link href=\"hopital.css\" rel=\"stylesheet\" type=\"text/css\" />");
print("</head>");

print("<body>");
echo '<form action="" method="get" id="catalogue">';

if($_REQUEST['btn']==" CALCULER ")
{
	$hop_receveur = $_REQUEST['hop_dz2'];
	$hop_demandeur = $_REQUEST['hop_dz1'];
	$requete = "SELECT ad_longitude, ad_latitude
				FROM hopital, adresse
				WHERE Hop_ID = '$hop_receveur'
				AND hopital.adresse_ID = adresse.ad_ID
				";
	$resultat = ExecRequete($requete,$connexion);
	$req = mySql_fetch_array($resultat);
	$latA = $req['ad_latitude'];
	$longA = $req['ad_longitude'];
	
	$requete = "SELECT ad_longitude, ad_latitude
				FROM hopital, adresse
				WHERE Hop_ID = '$hop_demandeur'
				AND hopital.adresse_ID = adresse.ad_ID
				";
	$resultat = ExecRequete($requete,$connexion);
	$req = mySql_fetch_array($resultat);
	$latB = $req['ad_latitude'];
	$longB = $req['ad_longitude'];
	
	// distance Entzheim - hopital demandeur
	$lat_entz = 48.546660;
	$lng_entz = 7.632019;
	$d1 = orthodro($lat_entz,$lng_entz,$latB,$longB);
	print("D1 = ".$d1."<br>");
	//print($lat_entz." ".$latB." ".$lng_entz." ".$longB."<br>");
	// distance hopital demandeur - hopital receveur
	$d2 = orthodro($latA,$longA,$latB,$longB);
	print("Distance Orthodromique: ".$d2."<br>");
	$t = $d2 / 4;
	print("Temps de vol estimé: ".$t." mn<br>");
	$d3 = $d1 + $d2;
	print("distance totale = ".$d3." km<br>");
	$dCritique = $d2/$d3;
	print("D critique = ".$dCritique."<br>");
}

/**
*	entête
*/
print("<div id=\"formtitle\">Calcul du score PDL</div>");

/**
*	corps
*/
print("<div id=\"content\">");
	print("<fieldset id=\"coordonnees\">");
	print("<legend> Pathologie </legend>");
	?>
		<label for="pat1"><input type="radio" name="pathologie" id="pat1" value="6"checked="checked" > Urgence vitale non stabilisée évolutive</label><br />
		<label for="pat2"><input type="radio" name="pathologie" id="pat2" value="4" > Urgence vitale stabilisée évolutive</label><br />
		<label for="pat3"><input type="radio" name="pathologie" id="pat3" value="2" > Urgence vitale stabilisée non évolutive</label><br />
	
	</fieldset>
	
	<fieldset id="coordonnees">
		<legend> Trajet </legend>
		Hôpital demandeur <?php liste_hop_dz("hop_dz1",$hop_demandeur); ?><br>
		Hôpital receveur  <?php liste_hop_dz("hop_dz2",$hop_receveur); ?><br>
	</fieldset>
	<?php
print("</div>");

/**
*	pied de page
*/
print("<div id=\"formfooter\" align=\"center\">");
	print("<p>");			
	print("<table class=\"curseur\" >");//border-color:none;
		print("<tr>");
			print("<td class=\"curseur\">");
			echo '<input type="submit" value=" CALCULER " name="btn">';
			print("</td>");
		print("</tr>");
	print("</table>");
	print("</p>");
print("</div>");

print("</body>");
print("</html>");
?>
