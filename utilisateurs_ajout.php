<?php
//----------------------------------------- SAGEC ------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003-2004 (Jean-Claude Bartier).
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
//----------------------------------------- SAGEC ----------------------------------------------
/**										
*	programme: 		utilisateurs_ajout.php					
*	date de création: 	02/01/2004						
*	auteur:			jcb							
*	description:		Ajout/ modification d'un utilisateur				
*	@version:		$Id: utilisateurs_ajout.php 43 2008-03-13 22:41:12Z jcb $								
*	maj le:			02/01/2004						
*/											
//----------------------------------------------------------------------------------------------
//Liste des vecteurs
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
if(!$_SESSION['auto_sagec'] && $_SESSION[autorisation]==10)header("Location:logout.php");

$langue = $_SESSION['langue'];
$member_id = $_SESSION['member_id'];

$backPathToRoot = "./";
$BackToRoot = $backPathToRoot;

include("utilitairesHTML.php");
require("pma_connect.php");
require("pma_connexion.php");
require("pma_requete.php");
require 'utilitaires/globals_string_lang.php';
include("utilisateurs_menu.php");
require "autorisations/droits.php";

include($backPathToRoot."login/init_security.php");

print("<HTML><HEAD><TITLE>Ajout Utilisateur</TITLE>");
?>
<SCRIPT>
function Choix(form)
{
	document.utilisateurs.submit();
}
</SCRIPT>
<?php
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\"></HEAD>");

print("<BODY>");
print("<FORM name =\"utilisateurs\"  ACTION=\"utilisateurs_enregistre.php\" METHOD=\"POST\">");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
// si la variable $utilisateur existe, c'est qu'il s'agit d'une maj, sinon c'est une création
if($_GET[utilisateur])
{
	$requete="SELECT * FROM utilisateurs WHERE ID_utilisateur = '$_GET[utilisateur]'";
	//print("$requete");
	$resultat = ExecRequete($requete,$connexion);
	$i = LigneSuivante($resultat);
	print("Mise à jour d'un utilisateur référencé<BR>");
	$organisme = $i->org_ID;
	print("<INPUT TYPE=\"HIDDEN\" NAME=\"organisme\" VALUE='$organisme'> ");
	print("<INPUT TYPE=\"hidden\" NAME=\"utilisateur\" VALUE=\"$_GET[utilisateur]\">");
}
else
	print("Nouvel utilisateur<BR>");

TblDebut(0,"100%");
	TblDebutLigne();
		TblCellule("Nom:");
		TblCellule("<INPUT TYPE=\"text\" NAME=\"nom\" VALUE=\"$i->nom\">");
		TblCellule("Prénom:");
		TblCellule("<INPUT TYPE=\"text\" NAME=\"prenom\" VALUE=\"$i->prenom\">");
	TblFinLigne();
	TblDebutLigne();
		TblCellule("Login:");
		TblCellule("<INPUT TYPE=\"text\" NAME=\"login\" VALUE=\"$i->login\">");
		TblCellule("Pass:");
		TblCellule("<INPUT TYPE=\"text\" NAME=\"pass\" VALUE=\"$i->pass\">");
		TblCellule("mail:");
		TblCellule("<INPUT TYPE=\"text\" NAME=\"mail\" VALUE=\"$i->email\">");
	TblFinLigne();
	TblDebutLigne();

		TblCellule("Organisme:");
		print("<TD>");// liste des organismes possibles. $orgID contient l'org_ID de l'organisme
			if($i->org_ID == 0)$i->org_ID = 85;
			SelectOrganisme($connexion,$i->org_ID,$langue,"Choix(this.form)");
		print("</TD>");
		print("<TD>");// liste des hôpitaux possibles. $ID_hopital contient l'Hop_ID de l'hôpital
			select_hopital($connexion,$i->Hop_ID,$langue,"Choix(this.form)");
		print("</TD>");
		print("<TD>");// liste des organismes possibles. $service contient le service_ID du service
			select_service2($connexion,$i->Hop_ID,$i->service_ID);
		print("</TD>");
	TblFinLigne();
TblFin();

// Définition des autorisations
if($_SESSION['autorisation']==10)
{
	print("<fieldset><legend> Autorisations </legend>");
	TblDebut(0,"100%");
		TblDebutLigne();
			TblCellule("niveau autorisé:");
			//-----------------------------------------------------
			print("<TD>");
			print("<SELECT NAME=\"auto\">");
				for($k="1";$k<11;$k++)
				{
					print("<OPTION VALUE=\"$k\" ");
					if($k == $i->autorisation) print(" SELECTED");
					print(">$k</OPTION> \n");
				}
			print("</SELECT>");
			print("</TD>");
		TblFinLigne();
		TblDebutLigne();
			//-----------------------------------------------------
			print("<TD>");
			$check ="";
			if($i->auto_apa=='o')$check = "checked";
			print("<INPUT TYPE=\"checkbox\" NAME=\"apa\" $check > Autorisation APA");
			print("</TD>");
			//-----------------------------------------------------
			print("<TD>");
			$check ="";
			if($i->auto_sagec=='o')$check = "checked";
			print("<INPUT TYPE=\"checkbox\" NAME=\"sagec\" $check > Autorisation SAGEC");
			print("</TD>");
			//-----------------------------------------------------
			print("<TD>");
			$check ="";
			if($i->auto_arh=='o')$check = "checked";
			print("<INPUT TYPE=\"checkbox\" NAME=\"arh\" $check > Autorisation ARH");
			print("</TD>");
			//-----------------------------------------------------
		TblFinLigne();
		TblDebutLigne();
			//-----------------------------------------------------
			print("<TD>");
			$check ="";
			if($i->auto_org=='o')$check = "checked";
			print("<INPUT TYPE=\"checkbox\" NAME=\"org\" $check > Autorisation Organisme");
			print("</TD>");
			//-----------------------------------------------------
			print("<TD>");
			$check ="";
			if($i->auto_hopital=='o')$check = "checked";
			print("<INPUT TYPE=\"checkbox\" NAME=\"hop\" $check > Autorisation Hôpital");
			print("</TD>");
			//-----------------------------------------------------
			print("<TD>");
			$check ="";
			if($i->auto_service=='o')$check = "checked";
			print("<INPUT TYPE=\"checkbox\" NAME=\"service\" $check > Autorisation Service");
			print("</TD>");
			//-----------------------------------------------------
			print("<TD>");
			$check ="";
			if($i->auto_ccrise=='o')$check = "checked";
			print("<INPUT TYPE=\"checkbox\" NAME=\"ccrise\" $check > Autorisation C.de crise");
			print("</TD>");
		TblFinLigne();
	TblFin();
	TblDebut(0,"100%");
		TblDebutLigne();
			print("<TD>");
			$check ="";
			if($i->auto_mg=='o')$check = "checked";
			print("<INPUT TYPE=\"checkbox\" NAME=\"auto_mg\" $check oncheck =\"Choix(this.form)\" > Autorisation MG");
			print("</TD>");
			if($i->auto_mg=='o')
			{
				print("<TD>");
					print("Sélectionner le médecin dans la liste: ");
					SelectMG67($connexion,$i->code_gen);// retourne med_id
				print("</TD>");
			}
		TblFinLigne();
	TblFin();
	TblDebut(0,"100%");
		print("<tr>");
			print("<td>");
			$check ="";
			if($i->auto_regul_pds=='o')$check = "checked";
			print("<INPUT TYPE=\"checkbox\" NAME=\"auto_pds\" $check oncheck =\"Choix(this.form)\" > Régulation PDS");
			print("</TD>");
			
			print("<TD>");
			print("Modifier hôpital ");
			print("<SELECT NAME=\"modif_hopital\">");
				for($k="0";$k<10;$k++)
				{
					print("<OPTION VALUE=\"$k\" ");
					if($k == $i->modif_hopital) print(" SELECTED");
					print(">$k</OPTION> \n");
				}
			print("</SELECT>");
			print("</TD>");

			print("<td>");
			$check ="";
			if($i->auto_test=='o')$check = "checked";
			print("<INPUT TYPE=\"checkbox\" NAME=\"auto_test\" $check oncheck =\"Choix(this.form)\" > tests");
			print("</TD>");
			
			print("<td>");
			$check ="";
			if($i->auto_ppi=='o')$check = "checked";
			print("<INPUT TYPE=\"checkbox\" NAME=\"auto_ppi\" $check oncheck =\"Choix(this.form)\" > ppi");
			print("</TD>");
			
			/** accès à la liste des victimes et aux synoptiques mais pas au dossier médical */
			print("<td>");
			$check ="";
			if($i->auto_victime =='o')$check = "checked";
			print("<INPUT TYPE=\"checkbox\" NAME=\"auto_victime\" $check oncheck =\"Choix(this.form)\" > Liste victimes");
			print("</TD>");
		print("</tr>");
		print("<tr>");
			/** accès liste hopitaux pour saisie rapide */
			print("<td>");
			$check ="";
			if($i->auto_leistelle =='o')$check = "checked";
			print("<INPUT TYPE=\"checkbox\" NAME=\"auto_leistelle\" $check oncheck =\"Choix(this.form)\" > Leitstelle");
			print("</TD>");
		print("</tr>");
		
	TblFin();

	print("</fieldset>");
}
TblDebut(0,"100%");
	TblDebutLigne();
		TblCellule("<INPUT TYPE=\"submit\" NAME=\"ok\" VALUE=\"Valider\">");
		TblCellule("<A HREF=\"pass_modifie.php?utilisateur=$_GET[utilisateur]\">Affecter un nouveau mot de passe</A>");
	TblFinLigne();
	TblDebutLigne();
		// mise à jour des droits utilisateurs
		if (est_autorise("TEST"))
		{
			print("<td>");
			$log="autorisations/gestion_droits_utilisateurs.php?login=".$i->login;
			print("<a href=\"$log\">gestion des droits utilisateurs</a>");
			print("</td>");
		}
	TblFinLigne();
TblFin();
print("</FORM></BODY></HTML>");
?>
