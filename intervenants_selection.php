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
//----------------------------------------- SAGEC ----------------------------------------------//
//												//
//	programme: 		Intervenants_selection.php					//
//	date de création: 	11/10/2003							//
//	auteur:			jcb								//
//	description:		$v_type = type de vecteur (VLM = 1...)
//				$type_v = état du vecteur (disponible...)			//
//	version:		1.0								//
//	maj le:			11/10/2003							//
//												//
//----------------------------------------------------------------------------------------------//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];

require("intervenants_menu.php");
include("utilitairesHTML.php");
require("pma_connect.php");
require("pma_connexion.php");
require("pma_requete.php");
require 'utilitaires/globals_string_lang.php';

print("<HTML><HEAD><TITLE>Liste des Intervenants</TITLE>");
print("<SCRIPT>");
	print("function coche_arrive(objet,checked){");
	// maj et checked sont des variables cachées de la forme Intervenants (cf intervenants_selection))
	print("document.Intervenants.maj_arrive.value = objet;");
	print("document.Intervenants.checked_arrive.value = checked;");
	print("document.Intervenants.submit();");
	print("}");
	print("</SCRIPT>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\"></HEAD>");

print("<FORM name =\"Intervenants\"  ACTION=\"intervenants_selection.php\" METHOD = \"GET\">");

print("<INPUT TYPE=\"HIDDEN\" NAME=\"perso_type_ID\" VALUE=\"$_GET[perso_type_ID]\">");
print("<INPUT TYPE=\"HIDDEN\" NAME=\"maj\" VALUE=\"$_GET[maj]\">");
print("<INPUT TYPE=\"HIDDEN\" NAME=\"checked\" VALUE=\"$_GET[checked]\">");
print("<INPUT TYPE=\"HIDDEN\" NAME=\"maj_arrive\" VALUE=\"$_GET[maj_arrive]\">");
print("<INPUT TYPE=\"HIDDEN\" NAME=\"checked_arrive\" VALUE=\"$_GET[checked_arrive]\">");
print("<INPUT TYPE=\"HIDDEN\" NAME=\"org_type\" VALUE=\"$_GET[org_type]\">");

menu_intervenants($_SESSION['langue']);
$mot = $string_lang['SELECTIONNER_INTERVENANT'][$langue];
Print("<H3>$mot</H3>");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

if($_GET['maj'] > 0)
{
	if($_GET['checked'])
		$check = "o";
	else
		$check ="";
	$requete="UPDATE personnel SET alerte = '$check' WHERE Pers_ID = '$_GET[maj]'";
	//print($requete."<BR>");
	$resultat = ExecRequete($requete,$connexion);
}

if($_GET['maj_arrive'] > 0)
{
	if($_GET['checked_arrive'])
	{
		$check = "o";
		$date = time();
	}
	else
	{
		$check ="";
		$date = "";
	}
	//print($date);
	$requete="UPDATE personnel SET arrive = '$check',heure_arrive = '$date' WHERE Pers_ID = '$_GET[maj_arrive]'";
	$resultat = ExecRequete($requete,$connexion);
	//print($requete."<BR>");
}

//TblDebut(0,"100%");
print("<table width=\"100%\" cellspacing=\"0\">");
	TblDebutLigne("A3");
		$mot = $string_lang['TYPE_INTERVENANT'][$langue];
		TblCellule($mot);
			print("<TD>");
				SelectTypeIntervenant($connexion,$_GET['perso_type_ID'],$langue);// perso_type_ID
			print("</TD>");
		
		$mot = $string_lang['ORGANISME'][$langue];
		TblCellule($mot);
			print("<TD>");
			if(!$_GET['org_type']){
				$_GET['org_type']="85";// SAMU par Défaut
				$_GET['the_service']="111";// SAMU par Défaut
			}
			SelectOrganisme($connexion,$_GET['org_type'],$langue,"document.Intervenants.submit();");//Choix(this.form)
			print("</TD>");
			
		$mot = $string_lang['SERVICE'][$langue];
		TblCellule($mot);
			print("<TD>");
			if(!$_GET['the_service'])$_GET['the_service']="111";// SAMU par Défaut
			select_service($connexion,$_GET['org_type'],$_GET['the_service']);// retourne the_service
			print("</TD>");
		
		$mot = $string_lang['NON_ALERTE'][$langue];
		if($_GET['engage']=="1")
			TblCellule("$mot<INPUT TYPE=\"CHECKBOX\" NAME=\"engage\" VALUE=\"1\" CHECKED>");
		else
			TblCellule("$mot<INPUT TYPE=\"CHECKBOX\" NAME=\"engage\" VALUE=\"1\" ");
			
		$mot = $string_lang['VALIDER'][$langue];	
		TblCellule("<INPUT TYPE=\"SUBMIT\" VALUE=\"$mot\" NAME=\"ok\" SIZE = \"30\" ");
	TblFinLigne();
TblFin();

//Table_Vecteurs($connexion,$v_type,$type_v,$engage,$langue); 
//Table_Intervenants($connexion,$_GET['perso_type_ID'],$_GET['org_type'],$_GET['the_service'],$_GET['engage'],$langue);
Table_Intervenants($connexion,$_GET['perso_type_ID'],$_GET['org_type'],$the_service,$_GET['engage'],$langue);
  
print("</html>");

?>
