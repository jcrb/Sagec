<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// Foobar is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//		
//----------------------------------------- SAGEC ---------------------------------------------//
/**	programme: 			resetPMA.php		
*	date de création: 	18/08/2003		 
*	@author:			jcb		  
*	description:		Remet à zero un certain nombre d'items variables
*	@version:			1.1	- $Id: resetPMA.php 23 2007-09-21 03:50:41Z jcb $	 
*	maj le:				18/08/2003	 
*	  					21/10/2005
*	@package			sagec
*/
//---------------------------------------------------------------------------------------------//
// 15 aout 2003 - jcb
// Reset du système
// Remet à 0 tous les paramètres variables. Ne doit être utilisé qu'en cas de nouvelle cata
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(! $_SESSION['auto_sagec'] && !$_SESSION['autorisation']==10)
	header("Location:logout.php");
require("pma_connect.php");
require("pma_connexion.php");
require("pma_requete.php");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$null ="0";

print("<form name=\"raz\" action=\"resetPMA.php\" method=\"get\">");
print("Remise à zéro des paramètres du programme<hr>");
print("<table>");
print("<input type=\"checkbox\" name=\"lits\"> réinitialisation des lits<br>");
print("<input type=\"checkbox\" name=\"evenement\" checked> réinitialisation l'évènement courant<br>");
print("<input type=\"checkbox\" name=\"alerte\" checked> réinitialisation de la liste des services alertés<br>");
print("<input type=\"checkbox\" name=\"victimes\" checked> réinitialisation des victimes<br>");
print("<input type=\"checkbox\" name=\"vecteurs\" checked> réinitialisation des vecteurs engagés<br>");
//print("<input type=\"checkbox\" name=\"personnels\" checked> réinitialisation des personnels engagés<br>");
print("<input type=\"checkbox\" name=\"blocnote\" checked> réinitialisation du bloc-note<br>");
print("<input type=\"checkbox\" name=\"listerouge\" checked> déblocage des contacts masqués<br>");
print("<input type=\"checkbox\" name=\"plans\" checked> réinitialisation des plans courants<br>");
print("<input type=\"checkbox\" name=\"infos\" checked> réinitialisation des informations courantes<br>");
print("<input type=\"checkbox\" name=\"temp\" checked> réinitialisation des structures temporaires<br>");
print("<input type=\"checkbox\" name=\"gravite\" checked> réinitialisation du tracking des victimes<br>");

print("<input type=\"checkbox\" name=\"taches\" checked> reinitialisation des taches<br>");

print("<input type=\"checkbox\" name=\"structure\" checked> désactivation du PMA<br>");
print("<input type=\"checkbox\" name=\"perso_présents\" checked> effacement de la table personnel présent et affecté<br>");
print("</table>");
print("<br><input type=\"submit\" name=\"ok\" value=\"Réinitialiser\"> ");
print("<input type=\"submit\" name=\"ok\" value=\"Annuler\"><br>");

if($_GET['ok']=='Réinitialiser')
{
	//===============================  Remise à 0 des lits  =====================================
	if($_GET['lits'])
	{
		$requete = "UPDATE lits SET	lits_supp = $null,
							lits_occ = lits_sp,
							lits_liberable = $null,
							lits_cata = $null,
							lits_dispo = $null,
							date_maj=''";
		$resultat = ExecRequete($requete,$connexion);
		print("Lits reinitialisés<br>");
	}
	//===============================  Remise à 0 des lits  =====================================
	if($_GET['evenement'])
	{
		$_SESSION['evenement']='1';
		print("Evènement courant reinitialisés<br>");
	}
	//===============================  Remise à 0 des services alertés  =====================================
	if($_GET['alerte'])
	{
		$requete = "UPDATE service SET	Service_Alerte = 'n',heure_alerte = $null";
		$resultat = ExecRequete($requete,$connexion);
		print("liste des services alertés réinitialisée<br>");
	}

	//==============================  remise à 0 des patients  ===================================
	if($_GET['victimes'])
	{
		$requete = "DELETE FROM victime";
		$resultat = ExecRequete($requete,$connexion);
		print("listing des victimes effacé<br>");
	}

	//==============================  remise à 0 des moyens engagés  =============================
	if($_GET['vecteurs'])
	{
		$requete = "UPDATE vecteur SET Vec_Engage = $null";
		$resultat = ExecRequete($requete,$connexion);
		print("Vecteurs disponibles effacés<br>");
	}

	//==============================  remise à 0 des personnels rappelés ou présents  ============
	if($_GET['personnels'])
	{
		$requete="UPDATE personnel SET	alerte = '',
				arrive='',
				heure_arrive='',
				localisation_ID='',
				portatif1='',
				portatif2='',
				tel_crise1=''
				";
		$resultat = ExecRequete($requete,$connexion);
		print("Affectation des personnels effacé<br>");
	}

	//==============================  remise à 0 du bloc note  ===================================
	if($_GET['blocnote'])
	{
		$requete = "TRUNCATE TABLE livrebord";
		$resultat = ExecRequete($requete,$connexion);
		$requete = "TRUNCATE TABLE livrebordQR";
		$resultat = ExecRequete($requete,$connexion);
		print("Livre de bord effacé<br>");
	}
	//==============================  remise à 0 des plans courants  ===================================
	if($_GET['plans'])
	{
		$requete = "TRUNCATE TABLE plan_courant";
		$resultat = ExecRequete($requete,$connexion);
		print("Plans courants effacés<br>");
		// crée un enregistrement vide pour autoriser l'update des ppi 
		$requete = "INSERT INTO plan_courant VALUES('','','','','','','')";
		$resultat = ExecRequete($requete,$connexion);
	}
	//==============================  remise à 0 des informations courantes  ===================================
	if($_GET['infos'])
	{
		$requete = "TRUNCATE TABLE info";
		$resultat = ExecRequete($requete,$connexion);
		print("Informations courantes effacées<br>");
	}
	//==============================  remise à 0 des structures temporaires ===================================
	if($_GET['temp'])
	{
		$requete = "DELETE FROM temp_structure WHERE ts_reutilisable='n' OR ts_reutilisable=''";
		$resultat = ExecRequete($requete,$connexion);
		print("Structures temporaires effacées<br>");
	}
	//==============================  remise à 0 de la table victime_gravite ===================================
	if($_GET['gravite'])
	{
		$requete = "TRUNCATE TABLE victime_gravite";
		$resultat = ExecRequete($requete,$connexion);
		print("Table victime_gravite vidée<br>");
	}
	//==============================  remise à 0 de la table personnel ===================================
	// mise à 0 des champs fonctions et localisation
	if($_GET['intervenant'])
	{
		$requete = "UPDATE personnel SET localisation_ID = '0',fonction_ID='0'";
		$resultat = ExecRequete($requete,$connexion);
		print("Table personnel mise à jour<br>");
	}
	//==============================  remise à 0 des structures temporaires ===================================
	if($_GET['structure'])
	{
		$requete = "UPDATE temp_structure SET ts_active = 'n'";
		$resultat = ExecRequete($requete,$connexion);
		print("Structures actives désactivées<br>");
	}
	//==============================  remise à 0 de la table personnel affecté ===================================
	if($_GET['perso_présents'])
	{
		$requete = "TRUNCATE TABLE perso_affectation";
		$resultat = ExecRequete($requete,$connexion);
		print("Table perso_affectation vidée<br>");
	}
	//============================== reinitialisation des taches ===================================================
	if($_GET['taches'])
	{
		include_once("crise/CheckList/efface_tache.php");
		efface_tache.php;
		print("Les tâches sont réinitialisées<br>");
	}
	
}

elseif($_GET['ok']=='Annuler')
{
	header("Location:administrateur_menu.php");
}
print("</form>");
?>
