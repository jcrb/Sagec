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
//---------------------------------------------------------------------------------------------------------
//
/** 		contact_main.php
*	date de création: 	05/08/2005
*	@author:			jcb
*	description:		saisie / modification d'un contact. Seule une personne appartenant au
*						SAMU67 peut modifier le contenu de cette page (cf.ligne 139)
*						Les données confidentielles ne peuvent être lues que si le niveau
*						d'autorisation est maximal
*	@version:			$Id: contact_main.php 23 2007-09-21 03:50:41Z jcb $
*	@package Sagec
*/
//---------------------------------------------------------------------------------------------------------
require 'utilitaires/globals_string_lang.php';

?>
<script>
function Choix()
{
	document.Hopital.submit();
}
function ferme()
{
	if(typeof(fenLangue)=="object" && fenLangue.closed==false)
		fenLangue.close();
}
/*
	alerte_supprimer
	no 		n° de l'enregistrement à supprimer
	id 		paramètres pour le retour
	back 	adresse de retour
	param 	nom de la variable pour le retour. par ex. pour un intervenant on aura param = personne et
			id = personne_ID
*/
function alerte_supprimer(no,id,back,param,backpath)
{
	if(confirm("Voulez-vous vraiment supprimer cet enregistrement ?"))
	{
		location.replace(backpath + "contact/contact_supprime.php?enregistrement_ID=" + no + "&back="+ back +"&param="+param+"&id="+id);
		/*"&back=../intervenant_saisie.php&personne="*/
	}
}
/*
	newContact()
	id identifiant de l'objet auquel se rattache le contact
	type opération à effectuer: création=0, modifier=1, supprimer=2
	nature caractéristique de l'objet auquel se rattache le contact: personne, organisme, service, etc.
	enregistrement_id n°de l'enregistrement dans le fichier contact
*/
function newContact(id,type,nature,enregistrement_id,path)//type= 0 nouveau 1 = modifier 2 = supprimer /SAGEC67_v3/services/contact/contact_saisie.php
{
	/*path = "sagec3";*/
	adresse = "/"+path+ "/contact/contact_saisie.php?personne_id="+id+"&type="+type+"&enregistrement="+enregistrement_id+"&nature="+nature;
fenContact=window.open(adresse,"contacts","width=700,height=250,scrolling=no,toolbar=no,menubar=no,location=center,directories=no,status=no");
/*adresse = "/SAGEC67_v3/contact/contact_saisie.php?personne_id="+id+"&type="+type+"&enregistrement="+enregistrement_id+"&nature="+nature;
fenContact=window.open(adresse,"contacts","width=700,height=250,scrolling=no,toolbar=no,menubar=no,location=center,directories=no,status=no");*/
}
</script>

<?php
//$langue = $_SESSION['langue'];
include("utilitaires/table.php");
//require_once 'utilitaires/globals_string_lang.php';
require("pma_connect.php");
require("pma_connexion.php");
include_once("utilitairesHTML.php");

/**
* Affichage du dialogue pour un contact
* @param $contact: valeur du contact
* @param $type opération à effectuer: création=0, modifier=1, supprimer=2
* @param $nature caractéristique de l'objet auquel se rattache le contact: personne, organisme, service, etc.
* @param $contact_id: identifiant du contact dans le fichier contact
* @param $back: chemin complet vers la fenêtre appelante
* @param $variable_retour: nom de la variable à renvoyer pour q'au retour la fenêtre affiche la bonne fiche
* @param $modif: autorisation de modifier. Faux par défaut. Mettre à 'o' si la personne connectée ne peut modifier que ses propres n°
* @param $backpath chemin d'accès pour que la suppression fonctionne correctement. 
*/
function contact($contact,$type,$nature,$contact_id,$back,$variable_retour,$tri,$modif="n",$backpath="./")
{
	//print($contact." - ".$type." - ".$nature." - ".$contact_id." - ".$back." - ".$variable_retour." - ".$tri." - ".$modif."<br>");
	//print_r($_SESSION);
	
	include "sagec.conf";// +++ DEFINI LA VARIABLE PATH +++ a voir er 1er si pb
	$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
	$langue = $_SESSION['langue'];
	require 'utilitaires/globals_string_lang.php';
	print("<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\" class=\"Style24\" bgcolor=\"#ffffcc\">");
	// ouvre la fenpetre de saisie des informations
	print("<tr>");
	print("<TD> Contacts </td>");
	print("<td><A HREF= javascript:newContact($contact,$type,$nature,0,'$SAGEC_DOSSIER');>".$string_lang['CONTACT_NOUVEAU'][$langue]."</A><td>");
	print("</tr>");
	print("</table>");
	// affiche le tableau des valeurs connues
	print("<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\" class=\"Style22\">");
	print("<TR>");
	//print("<TD><B><A href=\"$back?tri=type&ID_hopital=$contact\">Type</a></B></TD>");
	print("<TD><B><A href=\"$back?tri=type&$variable_retour=$contact\">".$string_lang['TYPE'][$langue]."</a></B></TD>");
	print("<TD><B><A href=\"$back?tri=nature&$variable_retour=$contact\">".$string_lang['NATURE'][$langue]."</a></B></TD>");
	print("<TD><B>".$string_lang['LOCALISATION'][$langue]."</B></TD>");
	print("<TD><B><A href=\"$back?tri=valeur&$variable_retour=$contact\">".$string_lang['VALEUR'][$langue]."</a></B></TD>");
	print("<TD><B>&nbsp;</B></TD>");
	print("<TD><B>&nbsp;</B></TD>");
	print("</TR>");
	// sélectionne les données connues du contacts 'il y en a, et les affiche dans une table
	$requete="SELECT type_contact_nom,contact_nom,valeur,confidentialite_ID,contact_lieu,contact_ID
			FROM contact,type_contact
			WHERE identifiant_contact = '$contact'
			AND nature_contact_ID = '$nature'
			AND contact.type_contact_ID = type_contact.type_contact_ID
			";
		if($tri=='nature') $requete.=" ORDER BY contact_nom";
		elseif($tri=='type') $requete.=" ORDER BY type_contact_nom";
		elseif($tri=='valeur') $requete.=" ORDER BY valeur";
		//print($requete);
	$resultat = ExecRequete($requete,$connexion);
	while($rub=mysql_fetch_array($resultat))
	{
		print("<TR>");
		$mot=$string_lang[$rub['type_contact_nom']][$langue];
		TblCellule("<div align=\"left\" class=\"Style23\"> $mot</td>");
		TblCellule("<div align=\"left\" class=\"Style23\"> $rub[contact_nom]</td>");
		if($rub[contact_lieu]==1)
			print("<td><div align=\"left\" class=\"Style23\">".$string_lang['DOMICILE'][$langue]."</td>");
		else
			print("<td><div align=\"left\" class=\"Style23\">".$string_lang['TRAVAIL'][$langue]."</td>");
		if($rub['confidentialite_ID'] == 1)
		{
			if($rub[type_contact_nom]=="SITE_INTERNET") //site internet
				print("<td><div align=\"left\" class=\"Style23\"><a href=\"$rub[valeur]\">$rub[valeur]</a></td>");
			elseif($rub[type_contact_nom]=="MAIL") //site internet
				print("<td><div align=\"left\" class=\"Style23\"><a href=\"mailto:$rub[valeur]\">$rub[valeur]</a></td>");
			else
			{
				//$mot=NumTel($rub['valeur']);
				$mot=$rub['valeur'];
				if(!$mot) $mot=$rub['valeur'];
					print("<td><div align=\"left\" class=\"Style23\"> $mot</td>");
			}
			if($_SESSION["service"]==111)//seul le SAMU67 peut modifier les données
				$acces=true;
		}
		else if($rub['confidentialite_ID'] == 2)
		{
			print("<td><div align=\"center\" class=\"time_r\"> Liste Rouge</td>");
			$acces=false;
			if($_SESSION['autorisation']==10)
				$acces=true;
		}
		else
		{
			print("<td><div align=\"center\" class=\"time_r\"> Classifié</td>");//button_drop.png
			$acces=false;
			if($_SESSION['autorisation']==10)
				$acces=true;
		}
		
		// si on autorise formellement
		if($modif == 'o')
			$acces = true;
			
		//on ne peut accéder que si on est autorisé
		if($acces)
		{
			$modifier=1;
			$image = "/".$SAGEC_DOSSIER."/images/button_edit.png";// /sagec3/images/button_edit.png
			print("<td><div align=\"center\" class=\"time_r\">
			<A href=javascript:newContact($contact,$modifier,$nature,$rub[contact_ID],'$SAGEC_DOSSIER');>
			<img src=\"$image\" Title=\"modifier\" border=\"0\"></a></div></td>");
			//<img src=\"/SAGEC67_v3/images/button_edit.png\" Title=\"modifier\" border=\"0\"></a></div></td>");
			
			$mot1=$rub['contact_ID'];
			$mot2="'personnelID'";
	//$back = "'../hopital.php'";
	//$variable_retour = "'ID_hopital'";
			print("<td><div align=\"center\" class=\"time_r\">
			<A href=javascript:alerte_supprimer($mot1,$contact,$back,$variable_retour,'$backpath');>
			<img src=\"/".$SAGEC_DOSSIER."/images/button_drop.png\" Title=\"supprimer\" border=\"0\"></a></div></td>");
		}
		else
		{
			print("<td>&nbsp;</td>");
			print("<td>&nbsp;</td>");
		}
		print("</TR>");
	}
	print("</table>");
}

?>
