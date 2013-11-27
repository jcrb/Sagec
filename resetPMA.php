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
*	date de cr�ation: 	18/08/2003		 
*	@author:			jcb		  
*	description:		Remet � zero un certain nombre d'items variables
*	@version:			1.1	- $Id: resetPMA.php 23 2007-09-21 03:50:41Z jcb $	 
*	maj le:				18/08/2003	 
*	  					21/10/2005
*	@package			sagec
*/
//---------------------------------------------------------------------------------------------//
// 15 aout 2003 - jcb
// Reset du syst�me
// Remet � 0 tous les param�tres variables. Ne doit �tre utilis� qu'en cas de nouvelle cata
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
print("Remise � z�ro des param�tres du programme<hr>");
print("<table>");
print("<input type=\"checkbox\" name=\"lits\"> r�initialisation des lits<br>");
print("<input type=\"checkbox\" name=\"evenement\" checked> r�initialisation l'�v�nement courant<br>");
print("<input type=\"checkbox\" name=\"alerte\" checked> r�initialisation de la liste des services alert�s<br>");
print("<input type=\"checkbox\" name=\"victimes\" checked> r�initialisation des victimes<br>");
print("<input type=\"checkbox\" name=\"vecteurs\" checked> r�initialisation des vecteurs engag�s<br>");
//print("<input type=\"checkbox\" name=\"personnels\" checked> r�initialisation des personnels engag�s<br>");
print("<input type=\"checkbox\" name=\"blocnote\" checked> r�initialisation du bloc-note<br>");
print("<input type=\"checkbox\" name=\"listerouge\" checked> d�blocage des contacts masqu�s<br>");
print("<input type=\"checkbox\" name=\"plans\" checked> r�initialisation des plans courants<br>");
print("<input type=\"checkbox\" name=\"infos\" checked> r�initialisation des informations courantes<br>");
print("<input type=\"checkbox\" name=\"temp\" checked> r�initialisation des structures temporaires<br>");
print("<input type=\"checkbox\" name=\"gravite\" checked> r�initialisation du tracking des victimes<br>");

print("<input type=\"checkbox\" name=\"taches\" checked> reinitialisation des taches<br>");

print("<input type=\"checkbox\" name=\"structure\" checked> d�sactivation du PMA<br>");
print("<input type=\"checkbox\" name=\"perso_pr�sents\" checked> effacement de la table personnel pr�sent et affect�<br>");
print("</table>");
print("<br><input type=\"submit\" name=\"ok\" value=\"R�initialiser\"> ");
print("<input type=\"submit\" name=\"ok\" value=\"Annuler\"><br>");

if($_GET['ok']=='R�initialiser')
{
	//===============================  Remise � 0 des lits  =====================================
	if($_GET['lits'])
	{
		$requete = "UPDATE lits SET	lits_supp = $null,
							lits_occ = lits_sp,
							lits_liberable = $null,
							lits_cata = $null,
							lits_dispo = $null,
							date_maj=''";
		$resultat = ExecRequete($requete,$connexion);
		print("Lits reinitialis�s<br>");
	}
	//===============================  Remise � 0 des lits  =====================================
	if($_GET['evenement'])
	{
		$_SESSION['evenement']='1';
		print("Ev�nement courant reinitialis�s<br>");
	}
	//===============================  Remise � 0 des services alert�s  =====================================
	if($_GET['alerte'])
	{
		$requete = "UPDATE service SET	Service_Alerte = 'n',heure_alerte = $null";
		$resultat = ExecRequete($requete,$connexion);
		print("liste des services alert�s r�initialis�e<br>");
	}

	//==============================  remise � 0 des patients  ===================================
	if($_GET['victimes'])
	{
		$requete = "DELETE FROM victime";
		$resultat = ExecRequete($requete,$connexion);
		print("listing des victimes effac�<br>");
	}

	//==============================  remise � 0 des moyens engag�s  =============================
	if($_GET['vecteurs'])
	{
		$requete = "UPDATE vecteur SET Vec_Engage = $null";
		$resultat = ExecRequete($requete,$connexion);
		print("Vecteurs disponibles effac�s<br>");
	}

	//==============================  remise � 0 des personnels rappel�s ou pr�sents  ============
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
		print("Affectation des personnels effac�<br>");
	}

	//==============================  remise � 0 du bloc note  ===================================
	if($_GET['blocnote'])
	{
		$requete = "TRUNCATE TABLE livrebord";
		$resultat = ExecRequete($requete,$connexion);
		$requete = "TRUNCATE TABLE livrebordQR";
		$resultat = ExecRequete($requete,$connexion);
		print("Livre de bord effac�<br>");
	}
	//==============================  remise � 0 des plans courants  ===================================
	if($_GET['plans'])
	{
		$requete = "TRUNCATE TABLE plan_courant";
		$resultat = ExecRequete($requete,$connexion);
		print("Plans courants effac�s<br>");
		// cr�e un enregistrement vide pour autoriser l'update des ppi 
		$requete = "INSERT INTO plan_courant VALUES('','','','','','','')";
		$resultat = ExecRequete($requete,$connexion);
	}
	//==============================  remise � 0 des informations courantes  ===================================
	if($_GET['infos'])
	{
		$requete = "TRUNCATE TABLE info";
		$resultat = ExecRequete($requete,$connexion);
		print("Informations courantes effac�es<br>");
	}
	//==============================  remise � 0 des structures temporaires ===================================
	if($_GET['temp'])
	{
		$requete = "DELETE FROM temp_structure WHERE ts_reutilisable='n' OR ts_reutilisable=''";
		$resultat = ExecRequete($requete,$connexion);
		print("Structures temporaires effac�es<br>");
	}
	//==============================  remise � 0 de la table victime_gravite ===================================
	if($_GET['gravite'])
	{
		$requete = "TRUNCATE TABLE victime_gravite";
		$resultat = ExecRequete($requete,$connexion);
		print("Table victime_gravite vid�e<br>");
	}
	//==============================  remise � 0 de la table personnel ===================================
	// mise � 0 des champs fonctions et localisation
	if($_GET['intervenant'])
	{
		$requete = "UPDATE personnel SET localisation_ID = '0',fonction_ID='0'";
		$resultat = ExecRequete($requete,$connexion);
		print("Table personnel mise � jour<br>");
	}
	//==============================  remise � 0 des structures temporaires ===================================
	if($_GET['structure'])
	{
		$requete = "UPDATE temp_structure SET ts_active = 'n'";
		$resultat = ExecRequete($requete,$connexion);
		print("Structures actives d�sactiv�es<br>");
	}
	//==============================  remise � 0 de la table personnel affect� ===================================
	if($_GET['perso_pr�sents'])
	{
		$requete = "TRUNCATE TABLE perso_affectation";
		$resultat = ExecRequete($requete,$connexion);
		print("Table perso_affectation vid�e<br>");
	}
	//============================== reinitialisation des taches ===================================================
	if($_GET['taches'])
	{
		include_once("crise/CheckList/efface_tache.php");
		efface_tache.php;
		print("Les t�ches sont r�initialis�es<br>");
	}
	
}

elseif($_GET['ok']=='Annuler')
{
	header("Location:administrateur_menu.php");
}
print("</form>");
?>
