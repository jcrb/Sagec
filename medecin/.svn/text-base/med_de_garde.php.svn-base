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
//													//
//	programme: 			med_de_gardee.php							//
//	date de création: 	03/10/2003								//
//	auteur:				jcb									//
//	description:		Affiche les ressources disponibles pour une commune
//						SMUR compétent, APA proches, etc.					//
//	version:			1.2									//
//	maj le:				02/11/2003	suppression bouton recherche				//
//													//
//---------------------------------------------------------------------------------------------------------
session_start();
if(! $_SESSION['auto_sagec'])header("Location:logout.php");

error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];

require("../html.php");
include("../utilitairesHTML.php");
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
require '../utilitaires/globals_string_lang.php';
require("../date.php");
//include ("html.php");
$a = "<a href=\"../blocnote_lire.php\">main courante</a>";
$b = "<a href=\"../samu_menu.php\">menu précédant</a>";
$c = "<a href=\"garde.php\">gardes</a>";
$menu = " | ".$a." | ".$b." | ";
$menu .=$c." | ";
entete_sagec2($titre="Médecin de garde du secteur","center","$menu");

print("<HTML><HEAD><TITLE>APA</TITLE>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
//<script language="javascript" src="http://www.pagesjaunes.fr//formulaire/PJ_9AD1_F116.js">
?>
<SCRIPT language = JavaScript>

var bufferFrappe="";
var timer;

if(navigator.appName=="Netscape" && navigator.appVersion.substr(0,1)=="4")
	document.onkeypress = carClavier;

function carClavier(e)
{
	if(typeof(timer)!="undefined")
		clearTimeout(timer);
	if(window.event)
	{
		frappe=String.fromCharCode(window.event.key(code));// pour IE
	}
	else
	{
		frappe=String.fromCharCode(e.wich); // pour Netscape
	}
	bufferFrappe += frappe;
	timer = setTimeout('chercheUrl(bufferFrappe)',450);
	if(window.event && window.event.keyCode==32)
		return false;
}

function chercheUrl(frappe)
{
	for(ancre=0; ancre<document.anchors.length; ancre++)
	{
		if(frappe.replace(/ /g,'_')==document.anchors[ancre].name.substr(0,frappe.length))
		{
			document.location="#"+document.anchors[ancre].name;
			break;
		}
	}
	bufferFrappe="";
}

function SetBorder(Objet,Color)
{
    Objet.style.backgroundColor=Color;
}
function couleur()
{
	//alert("vous êtes sur une ligne APA");
	bgcolor="aqua";
}
</SCRIPT>
<?php
print("</HEAD>");

print("<BODY onkeypress=return(carClavier(event))>");
print("<FORM name =\"Commune\"  ACTION=\"med_de_garde.php\" METHOD=\"POST\">");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

print("<br>");
//TblDebut(0,"75%");
//	TblDebutLigne();
		$mot = $string_lang['SELECTIONNER_COMMUNE'][$langue];
		print("<H3>$mot</H3>");
//		TblCellule("<H3>$mot</H3>");
//		print("<TD>");
			// la valeur de $commune est fournit par la méthode select_commune
			// la commune sélectionnée est retournée dans la variable $commune_id
			// l'instruction JavaScript "document.Commune.submit()" est incluse dans le select
			// de sorte que la mise à jour se fasse automatiquement
			select_commune($connexion,$_REQUEST['commune_id'],$langue,"document.Commune.submit()");//print("</H3>");
			$rub = get_carac_commune($connexion,$_REQUEST['commune_id']);
			//TblCellule("<INPUT TYPE=\"submit\" NAME = \"CHERCHER\">");
//		print("</TD>");
//	TblFinLigne();
//TblFin();

if($_REQUEST['commune_id'])
{
	// Identification des secteurs
	$requete = "SELECT com_nom,com_INSEE,secteur_smur_nom,secteur_apa_nom,secteur_adps_nom,commune.secteur_smur_ID,commune.secteur_adps_ID,commune.secteur_apa_ID,modalite
			FROM commune, secteur_smur, secteur_adps, secteur_apa
			WHERE com_ID = '$_REQUEST[commune_id]'
			AND commune.secteur_smur_ID = secteur_smur.secteur_smur_ID
			AND commune.secteur_adps_ID = secteur_adps.secteur_adps_no
			AND commune.secteur_apa_ID = secteur_apa.secteur_apa_ID
			";
	$resultat = ExecRequete($requete,$connexion);
	$rep = mysql_fetch_array($resultat);
	$secteur_SMUR = $rep['secteur_smur_nom'];
	$secteur_APA = $rep['secteur_apa_nom'];
	$secteur_PDS = $rep['secteur_adps_nom'];
	$secteur_SMUR_no = $rep['secteur_smur_ID'];
	$secteur_APA_no = $rep['secteur_apa_ID'];
	$secteur_PDS_no = $rep['secteur_adps_ID'];
	$secteur_modalite = $rep['modalite'];// définit le mode de travail dans ce secteur
											// 0 = visite + consultation
											// 1 = consultations exclusivement
											// 2 = visites exclusivement

	/*
	$requete = "SELECT med_ID FROM mg67_garde WHERE secteur_pds_ID = $secteur_PDS_no AND '$date' IN (date_debut,date_fin)";
	$resultat = ExecRequete($requete,$connexion);
*/
	print("<table>");
		print("<tr>");
			print("<td>Secteur SMUR ".$secteur_SMUR." | </td>");
			print("<td>Secteur APA ".$secteur_APA." | </td>");
			print("<td>Secteur PDS ".$secteur_PDS." - ".$secteur_PDS_no."</td>");
		print("</tr>");
	print("</table>");

	if($secteur_modalite == 1)
	{
		print("<table>");
			print("<tr>");
				print("<td><blink><h3 class=\"alerte\">Secteur régulé: ne jamais communiquer le n° du médecin de garde</h3></blink></td>");
			print("</tr>");
		print("</table>");
	}


// test pages jaunes
/*
?>
<script language="javascript" src="http://www.pagesjaunes.fr//formulaire/PJ_9AD1_F116.js"></script>
<input type="button" name="pj" value="Pages Jaunes" onclick="pages_jaunes();">
<?
*/
//======================================= MEDECIN DE GARDE =====================================================
$today = today();// aujourd'hui à 0h
$j = jour_de_la_semaine($today);// jour de la semaine
if($j=='samedi')$heure_debut = $today + 12*3600;
elseif($j=='dimanche')$heure_debut = $today + 8*3600;
else $heure_debut = $today + 20*3600;

$heure_debut = $today;
$heure_fin = $heure_debut+24*3600;
$requete = "SELECT med_nom,med_adresse,mg67.med_ID,med_tel,med_tel2,med_tel3
			FROM mg67,mg67_garde
			WHERE mg67.secteur_pds_ID = '$secteur_PDS_no'
			AND mg67.med_ID = mg67_garde.med_ID
			AND mg67_garde.date_debut BETWEEN '$heure_debut' AND '$heure_fin';
			";
$resultat = ExecRequete($requete,$connexion);
$rub=mysql_fetch_array($resultat);
$medecin_de_garde = $rub['med_ID'];
print("<br>".$j." ".date("j/m/Y")." médecin de garde pour le secteur: ".$rub['med_nom']."<br><br>");

//=========================================== MEDECINS ==========================================================
print("<table>");
	print("<TR bgcolor=\"gold\" class=\"time\">");
	/*
		$requete = "SELECT medecin_nom, medecin_prenom, medecin.secteur_adps_no,medecin_ID
					FROM medecin,com_adps,commune
					WHERE medecin.secteur_adps_ID = com_adps.secteur_adps_ID
					AND com_adps.com_INSEE = commune.com_INSEE
					AND commune.com_ID = '$_POST[commune_id]'
					";*/
		$requete = "SELECT med_nom,med_adresse,med_ID,med_tel,med_tel2,med_tel3
					FROM mg67
					WHERE mg67.secteur_pds_ID = '$secteur_PDS_no'
					ORDER BY med_nom
					";
		//print($requete);
		$resultat = ExecRequete($requete,$connexion);
		// nombre de lignes retournées par résultat
		$i = mysql_num_rows($resultat) + 1;
		print("<TD rowspan='$i'>Médecins</TD>");
		//print("<TD rowspan='$i' width=\"20\">secteur \"$secteur_PDS\"</TD>");
		while($rub=mysql_fetch_array($resultat))
		{
			if($rub['med_ID']==$medecin_de_garde)
				print("<TR bgcolor=\"orange\" id=TD3 OnMouseOver=javascript:backgroundColor='gold'; OnMouseOut=javascript:SetBorder(this,'lightsteelblue'); >");
			else
			print("<TR bgcolor=\"lightsteelblue\" id=TD3 OnMouseOver=javascript:backgroundColor='gold'; OnMouseOut=javascript:SetBorder(this,'lightsteelblue'); >");
			//TblCellule($rub[medecin_nom]." - ".$rub[medecin_prenom]);
			TblCellule($rub['med_nom']." ( ".$rub['med_adresse']." ) ".$rub['com_nom']);
			TblCellule($rub['med_tel']);
			TblCellule($rub['med_tel2']);
			TblCellule($rub['med_tel3']);
			TblCellule("<a href=\"agenda.php?medid=$rub[med_ID]&back=medecin/med_de_garde.php&commune=$_REQUEST[commune_id]\">agenda</a>");
			TblCellule("<a href=\"med_maj.php?medid=$rub[med_ID]&back=medecin/med_de_garde.php&commune=$_REQUEST[commune_id]\">modifier</a>");
			TblCellule("<a href=\"http://www.mappy.fr\" TARGET = \"_blank\">accès</a>");
			TblCellule(" ");
			TblFinLigne();
		}
		@mysql_free_result($resultat);
		//TblCellule("non implémenté");
	TblFinLigne();
print("</table>");
}
print("</body>");
?>