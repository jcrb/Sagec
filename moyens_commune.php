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
/**----------------------------------------- SAGEC --------------------------------------------------------
*											
* programme: 		moyens_commune.php						
* date de création: 	03/10/2003							
* @author:			jcb	
* @package Sagec								
* description:		Affiche les ressources disponibles pour une commune
						SMUR compétent, APA proches, etc.					
* @version $Id: moyens_commune.php 37 2008-02-27 06:46:04Z jcb $							
* maj le:			02/11/2003	suppression bouton recherche													
-------------------------------------------------------------------------------------------------------*/
session_start();
if(! $_SESSION['auto_sagec'])header("Location:logout.php");

error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];

require("moyens_commune_menu.php");
include("utilitairesHTML.php");
require("pma_connect.php");
require("pma_connexion.php");
require("pma_requete.php");
require 'utilitaires/globals_string_lang.php';
entete_sagec($titre="Moyens de secours par commune","center","./");

print("<HTML><HEAD><TITLE>APA</TITLE>");
print("<meta http-equiv=\"Content-Type\" content=\"text/html\" charset=\"charset=ISO-8859-1\"/>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
?>
<script>
	function SetBorder(Objet,Color)
{
    Objet.style.backgroundColor=Color;
}
</script>
<?php
print("</HEAD>");
print("<BODY>");//onkeypress=return(carClavier(event))
print("<FORM name =\"Commune\"  ACTION=\"moyens_commune.php\" METHOD=\"get\">");

MenuCommunes($langue);

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

TblDebut(0,"75%");
	TblDebutLigne();
		$mot = $string_lang['SELECTIONNER_COMMUNE'][$langue];
		TblCellule("<H3>$mot</H3>");
		print("<TD>");
			// la valeur de $commune est fournit par la méthode select_ville
			// la commune sélectionnée est retournée dans la variable $ville_id
			// l'instruction JavaScript "document.Commune.submit()" est incluse dans le select
			// de sorte que la mise à jour se fasse automatiquement
			select_ville_france($connexion,$_REQUEST['ville_id'],67,$langue,"document.Commune.submit()");
			$rub = get_carac_ville($connexion,$_REQUEST['ville_id']);
			if($rub['ville_longitude'] != 0)
			{
				// 13 est un facteur de zoom
				$back = "moyens_commune.php&ville_id=$_REQUEST[ville_id]";
				print("<a class=\"time\" href=\"pds/google_pds/pds_google.php?ville=$_REQUEST[ville_id]&long=$rub[ville_longitude]&lat=$rub[ville_latitude]&alt=13&back=$back\">  Localiser </a>");
			}
		print("</TD>");
		print("<TD>");

	if($_REQUEST['ville_id'])
	{
	// Identification des secteurs
	$requete = "SELECT ville_nom,ville_Insee,ville.secteur_Adps_ID,secteur_smur_nom,secteur_apa_nom,secteur_adps_nom,secteur_adps.secteur_adps_ID,secteur_apa.secteur_apa_ID, modalite
			FROM ville, secteur_smur, secteur_adps, secteur_apa
			WHERE ville_ID = '$_REQUEST[ville_id]'
			AND ville.secteur_smur_ID = secteur_smur.secteur_smur_ID
			AND ville.secteur_adps_ID = secteur_adps.secteur_adps_ID
			AND ville.secteur_apa_ID = secteur_apa.secteur_apa_ID
			";

	$resultat = ExecRequete($requete,$connexion);
	$rep = mysql_fetch_array($resultat);
	$secteur_SMUR = $rep['secteur_smur_nom'];
	$secteur_APA = $rep['secteur_apa_nom'];
	$secteur_PDS = $rep['secteur_adps_nom'];
	$secteur_SMUR_no = $rep['secteur_smur_ID'];
	$secteur_APA_no = $rep['secteur_apa_ID'];
	$secteur_PDS_no = $rep['secteur_Adps_ID'];
	$INSEE = $rep['ville_Insee'];
	$secteur_regule = $rep['modalite'];

	print("<table class=\"time\" border=\"1\" cellspacing=\"0\">");
		print("<tr>");
			print("<td bgcolor=\"#FF9900\">Secteur SMUR ".$secteur_SMUR."</td>");
			print("<td bgcolor=\"#FFCC00\">Secteur APA ".$secteur_APA."</td>");
			print("<td bgcolor=\"#FFFF00\">Secteur PDS ".$secteur_PDS." - ".$secteur_PDS_no);
				if($secteur_regule==1) print(" (secteur régulé)");
				else print(" (secteur non régulé)");
				print("</td>");
		print("</tr>");
	print("</table>");
	//}
	
	TblFinLigne();
	TblFin();

	TblDebut(1,"100%",0);
//=========================================== SMUR ==============================================================
	$ligne_color = "tomato";
	print("<TR class=\"time\" bgcolor=$ligne_color OnMouseOver=SetBorder(this,'lightsteelblue'); OnMouseOut=SetBorder(this,'$ligne_color'); >");
		TblCellule("SMUR");
		//$mot = get_smur($connexion,$rub[2]);
		TblCellule($secteur_SMUR);
		TblCellule(" ");
		TblCellule(" ");
		TblCellule(" ");
		TblCellule(" Mise à jour");
	TblFinLigne();
//======================================== Médecin de garde ====================================================
	$ligne_color = "tomato";
	print("<TR  class=\"time\" bgcolor=$ligne_color OnMouseOver=SetBorder(this,'lightsteelblue'); OnMouseOut=SetBorder(this,'$ligne_color'); >");
		TblCellule("Médecin de garde");
		TblCellule($secteur_PDS);
		TblCellule("Dr XY ");
		TblCellule(" ");
		TblCellule(" ");
		TblCellule(" Mise à jour");
	TblFinLigne();
//=========================================== APA ==============================================================
	$ligne_color = "PaleGoldenrod";
	print("<TR bgcolor=$ligne_color class=\"time\">");
		// liste des apa
		// On sélectionne les apa du secteur concerné avec affichage de leur adresse et n° de tel.
		// les informations proviennet de 4 tables différentes.
		// la table adresse sert de table intermédiaire entre les tables commune et organisme
		// la table contact est liée à la table organisme
		// organisme.organisme_type_ID = '4' correspond aux APA
		// $rub est un tableau contenant touts les champs de commune. $rub[3] = secteur concerné

		$requete=	"SELECT org_ID,org_nom,tel1,ville_nom
					FROM organisme,ville
					WHERE organisme.organisme_type_ID = '4'
					AND ville.secteur_apa_ID = '$secteur_APA_no'
					AND organisme.ville_ID = ville.ville_ID
					";
		//print($requete."<BR>");
		$resultat = ExecRequete($requete,$connexion);
		// nombre de lignes retournées par résultat
		$i = mysql_num_rows($resultat) + 1;

		print("<TD rowspan='$i'>APA</TD>");
		print("<TD rowspan='$i'>secteur n° \"$secteur_APA\"</TD>");

		while($rub=mysql_fetch_array($resultat))
		{
			$rep = est_apa_disponible($connexion,$rub[org_ID]);
			$nb_vehicules = $rep[0];
			if($nb_vehicules > 0)
			{
				print("<TR bgcolor=$ligne_color id=TD2 	 class=\"time_n\"									OnMouseOver=javascript:SetBorder(this,'lightsteelblue');
					OnMouseOut=javascript:SetBorder(this,'$ligne_color'); >");
					//TblCellule(" ");
					TblCellule($rub[org_nom]." - ".$rub[ville_nom]);
					//TblCellule($rub[contact_tel1]);
					TblCellule(numTel($rub[tel1]));
					TblCellule("moyens disponibles: ".$nb_vehicules);
					TblCellule(maDate($rep[1],"dh"));
				TblFinLigne();
			}
			else
			{
				print("<TR bgcolor=$ligne_color id=TD2 	 class=\"time_n\"									OnMouseOver=javascript:SetBorder(this,'lightsteelblue');
					OnMouseOut=javascript:SetBorder(this,'$ligne_color'); >");
					TblCellule($rub[org_nom]." - ".$rub[ville_nom]);
					TblCellule(numTel($rub[tel1]));
					TblCellule("&nbsp;");
					TblCellule(maDate($rep[1],"dh"));
				TblFinLigne();
			}
		}
		@mysql_free_result($resultat);
	TblFinLigne(); 
//=========================================== MEDECINS ==========================================================
	print("<TR bgcolor=\"gold\" class=\"time\">");

		// uniquement les médecins de la commune
		$requete = "SELECT med_nom,med_adresse,med_ID,med_tel
					FROM mg67
					WHERE mg67.code_insee = '$INSEE'
					ORDER BY med_nom
					";
		// tous les médecins du secteur
		$requete = "SELECT med_nom,med_adresse,med_ID,med_tel,med_tel2,med_tel3
					FROM mg67,ville
					WHERE ville.secteur_Adps_ID = '$secteur_PDS_no'
					AND mg67.code_insee = ville.ville_insee
					ORDER BY ville_insee
					";
		// tous les médecins du secteur
		$requete = "SELECT med_nom,med_adresse,med_ID,med_tel,med_tel2,med_tel3,ville_nom
					FROM mg67,ville
					WHERE mg67.secteur_pds_ID = '$secteur_PDS_no'
					AND mg67.ville_ID = ville.ville_ID
					ORDER BY code_insee
					";
		//print($requete);
		$resultat = ExecRequete($requete,$connexion);
		// nombre de lignes retournées par résultat
		$i = mysql_num_rows($resultat) + 1;
		print("<TD rowspan='$i'>Médecins</TD>");
		print("<TD rowspan='$i'>secteur \"$secteur_PDS\"</TD>");
		while($rub=mysql_fetch_array($resultat))
		{
			print("<TR bgcolor=\"gold\" class=\"time\" id=TD3 OnMouseOver=javascript:SetBorder(this,'lightsteelblue'); OnMouseOut=javascript:SetBorder(this,'gold'); >");
			//TblCellule($rub[medecin_nom]." - ".$rub[medecin_prenom]);
			TblCellule($rub['med_nom']." - ".$rub['med_adresse']." - ".$rub['ville_nom']);
			print("<td>$rub[med_tel]");
				if($rub['med_tel2']) print('<br>'.$rub['med_tel2']);
				if($rub['med_tel3']) print('<br>'.$rub['med_tel3']);
			print("</td>");
			//TblCellule($rub['med_tel'].'<br>'.$rub['med_tel2'].'<br>'.$rub['med_tel3']);
			TblCellule("<a href=\"medecin/agenda.php?medid=$rub[med_ID]&back=moyens_commune.php\">agenda</a>");
			TblCellule(" ");
			TblFinLigne();
		}
		@mysql_free_result($resultat);
		//TblCellule("non implémenté");
	TblFinLigne();
//=========================================== PHARMACIES ======================================================
	$ligne_color = "lime";
	
	$requete = "SELECT pharmacie.nom, pharmacie.adresse,pharmacie.tel, pharmacie.fax, pharmacie.long, pharmacie.lat 
					FROM pharmacie,ville
					WHERE pharmacie.ID_commune = ville_ID
					AND ville_ID = '$_REQUEST[ville_id]'
					";
	$resultat = ExecRequete($requete,$connexion);
	while($rub=mysql_fetch_array($resultat))
	{
		print("<TR  class=\"time\" bgcolor=$ligne_color OnMouseOver=javascript:SetBorder(this,'lightsteelblue'); OnMouseOut=javascript:SetBorder(this,'$ligne_color'); >");
		TblCellule("Pharmacies");
		TblCellule("");
		TblCellule($rub['nom']." - ".$rub['adresse']);
		TblCellule($rub['tel']);
		TblCellule(" ");
		TblCellule(" ");
		TblFinLigne();
	}
//=========================================== INFIRMIERES =====================================================
	$ligne_color = "yellow";
	print("<TR  bgcolor=$ligne_color OnMouseOver=javascript:SetBorder(this,'lightsteelblue'); OnMouseOut=javascript:SetBorder(this,'$ligne_color'); >");
		TblCellule("IDE");
		TblCellule("non implémenté");
		TblCellule(" ");
		TblCellule(" ");
		TblCellule(" ");
		TblCellule(" ");
	TblFinLigne();
TblFin();
}

print("</BODY>");
print("</html>");
?>
