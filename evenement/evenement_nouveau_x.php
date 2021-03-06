<?php
//----------------------------------------- SAGEC --------------------------------
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
/**	programme: 			evenement_nouveau.php
*	date de cr�ation: 	12/11/2004
*	@author:			jcb
*	description:		Fonctionalit� permise � l'administrateur
*	@version:			1.2 - $Id: evenement_nouveau.php 23 2007-09-21 03:50:41Z jcb $
*	maj le:				14/10/2004
*	@package			Sagec
*/
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(!$_SESSION["autorisation"]>8) header("Location:logout.php");
$backPathToRoot = "../";
include($backPathToRoot."html.php");
require($backPathToRoot."pma_connect.php");
require($backPathToRoot."pma_connexion.php");
require $backPathToRoot.'utilitaires/requete.php';
require $backPathToRoot.'utilitaires/liste.php';
include_once($backPathToRoot."date.php");
include_once($backPathToRoot."administrateur/sauvegarde_TXT.php");
include($backPathToRoot."login/init_security.php");
//
$langue = $_SESSION['langue'];
//
// ENTETE
print("<html>");
print("<head>");
print("<title> Ev�nement courant </title>");
print("<meta name=\"author\" content=\"JCB\">");
print("<LINK REL=stylesheet HREF=\"".$backPathToRoot."pma.css\" TYPE =\"text/css\">");
print("</head>");
// CORPS
print("<BODY>");
print("<FORM ACTION =\"evenement_nouveau.php\" METHOD=\"POST\">");
$connect = Connexion(NOM,PASSE,BASE,SERVEUR);

//======================================  Retour  ===============================================
if($_POST['ok'])	// enregistrement du nouvel �v�nement
{
	/* Sauvegarde de l'�v�nement pr�c�dant */
	if($_SESSION['evenement'] > 1)
	{
		// administrateur/sauvegarde.php 
		sauvegarde_txt();
	}
	
	$requete = "SELECT* FROM evenement WHERE evenement_ID = '$_REQUEST[ev_courant_prec]'";
	$resultat = ExecRequete($requete,$connect);
	$rub=mysql_fetch_array($resultat);
	
	if($rub['evenement_nom']!=$_POST['titre'])//si l'�v�nement pr�c�dant a un nom diff�rent
	{
		
		$date = security::esc2Db($_REQUEST['date1']);
		$heure = security::esc2Db($_REQUEST['heure1']);
		$samu = security::esc2Db($_REQUEST['dossier_samu']);
		$sdis = security::esc2Db($_REQUEST['dossier_sdis']);
		$comment = security::esc2Db($_REQUEST['comment']);
		$titre = security::esc2Db($_REQUEST['titre']);
		$ppi = security::esc2Db($_REQUEST['ppi_id']);
		if($_REQUEST['actif'])$actif = 'oui';// �v�nement en cours 
		
		$requete = "INSERT INTO evenement VALUES('','$_POST[titre]','$date','$heure','0','$heure','0','0','$actif','$samu','$sdis','$comment')";
		$resultat = ExecRequete($requete,$connect);
		// r�cup�rer l'ID. Si ID = 1, il ne se passe rien
		$maj = mysql_insert_id();
		// mettre � jour la table alerte
		$requete = "UPDATE alerte SET evenement_ID = '$maj'";
		$resultat = ExecRequete($requete,$connect);
		// mettre � jour les structures temporaires r�utilisables ?
	}
	
	if($_POST['titre'] != "Aucun �v�nement en cours")
	{
			// diriger vers la page sp�cifique de l'�v�nement
			//header("Location:evenement_courant.php");
			if($_REQUEST['pco'])
			{
				$requete = "SELECT ts_ID FROM temp_structure WHERE ts_nom = 'PCO 1'";
				$resultat = ExecRequete($requete,$connect);
				$rep = mysql_fetch_array($resultat);
				$PCO_ID = $rep[ts_ID];// adresse du PCO
				if(!$rep[ts_ID])
				{
					$requete = "INSERT INTO `temp_structure` (`ts_ID`,`ts_nom`,`ts_type`,`ts_localisation`,`ts_contact`,`ts_lat`,`ts_long`,`cata_ID`, `ts_parent_ID`,`ts_active`,`ts_heure_activation`,`ts_heure_arret`,`ts_reutilisable`)VALUES ('', 'PCO 1', '11', '', '0', '0', '0', '$_SESSION[evenement]', '0','o', '$datetime ', '$datetime ', 'n')";
					$PCO_ID = mysql_insert_id() ;
				}
				else
					$requete = "UPDATE `temp_structure` SET `ts_heure_activation`='$datetime',`ts_heure_arret`='$datetime',`ts_active`='o' WHERE ts_ID='$rep[ts_ID]'";
				$resultat = ExecRequete($requete,$connect);
			}
			
			if($_REQUEST['pma'])
			{
				$requete = "SELECT ts_ID FROM temp_structure WHERE ts_nom = 'PMA 1'";
				$resultat = ExecRequete($requete,$connect);
				$rep = mysql_fetch_array($resultat);
				$PMA_ID = $rep[ts_ID]; // adresse du PMA
				if(!$rep[ts_ID])
					$requete = "INSERT INTO `temp_structure` (`ts_ID`,`ts_nom`,`ts_type`,`ts_localisation`,`ts_contact`,`ts_lat`,`ts_long`,`cata_ID`, `ts_parent_ID`,`ts_active`,`ts_heure_activation`,`ts_heure_arret`,`ts_reutilisable`)VALUES ('', 'PMA 1', '3', '', '0', '0', '0', '$_SESSION[evenement]', '$PCO_ID','o', '$datetime ', '$datetime', 'n')";
				else
					$requete = "UPDATE `temp_structure` SET `ts_heure_activation`='$datetime',`ts_heure_arret`='$datetime',`ts_active`='o' WHERE ts_ID='$rep[ts_ID]'";
				$resultat = ExecRequete($requete,$connect);
			}
			
			if($_REQUEST['chantier'])
			{
				$requete = "SELECT ts_ID FROM temp_structure WHERE ts_nom = 'chantier 1'";
				$resultat = ExecRequete($requete,$connect);
				$rep = mysql_fetch_array($resultat);
				if(!$rep[ts_ID])
					$requete = "INSERT INTO `temp_structure` (`ts_ID`,`ts_nom`,`ts_type`,`ts_localisation`,`ts_contact`,`ts_lat`,`ts_long`,`cata_ID`, `ts_parent_ID`,`ts_active`,`ts_heure_activation`,`ts_heure_arret`,`ts_reutilisable`)VALUES ('', 'chantier 1', '1', '', '0', '0', '0', '$_SESSION[evenement]', '$PMA_ID','o', '$datetime ', '$datetime', 'n')";
				else
					$requete = "UPDATE `temp_structure` SET `ts_heure_activation`='$datetime',`ts_heure_arret`='$datetime',`ts_active`='o' WHERE ts_ID='$rep[ts_ID]'";
				$resultat = ExecRequete($requete,$connect);
			}
			$datetime = uDateTime2MySql(time());
			

			if($_REQUEST['actif'])
			{
				// mettre � jour la variable globale
				$_SESSION["evenement"] = $maj;
				$requete = "UPDATE alerte SET evenement_ID = '$maj'";
				$resultat = ExecRequete($requete,$connect);
			}
		}
		else
		{
			// mettre � jour la table alerte
			$requete = "UPDATE alerte SET evenement_ID = 1";
			$resultat = ExecRequete($requete,$connect);
			// mettre � jour la variable globale
			$_SESSION["evenement"] = 1;
		}
}

//================================================ Debut ======================================================
// affichage du texte
$requete = "SELECT * FROM evenement WHERE evenement_ID = '$_SESSION[evenement]'";
$resultat = ExecRequete($requete,$connect);
$rub=mysql_fetch_array($resultat);
// on enregistre dans un champ cach� la valeur de l'�v�nement courant pr�c�dant
print("<input type=\"hidden\" name=\"ev_courant_prec\" value=\"$rub[evenement_ID]\">");
print("<table>");
/*
print("<TR>");
	print("<TD>Ev�nement courant</TD>");
	print("<TD><input type=\"text\" name=\"ev_courant\" value=\"$rub[evenement_nom]\" size=\"50\"></TD>");
	print("<TD><input type=\"submit\" name=\"ok\" value=\"Valider\"></TD>");
print("</TR>");
*/
print("<TR>");
	print("<TD>Nouvel �v�nement</TD>");
	print("<TD><input type=\"text\" name=\"titre\" value=\"\" size=\"50\"></TD>");
	print("<TD><input type=\"submit\" name=\"ok\" value=\"Valider\"></TD>");
print("</TR>");
print("<TR>");
	print("<TD>Date de cr�ation</TD>");
	$date = date("Y-m-j");
	print("<TD><input type=\"text\" name=\"date1\" value=\"$date\" size=\"10\"></TD>");
print("</TR>");
print("<TR>");
	print("<TD>Heure de cr�ation</TD>");
	$heure = date("H:i:s");
	print("<TD><input type=\"text\" name=\"heure1\" value=\"$heure\" size=\"10\"></TD>");
print("</TR>");
print("<TR>");
	print("<TD>Commentaires</TD>");
	print("<TD><TEXTAREA name=\"comment\" value=\"$rub[comment]\" cols=\"50\" rows=\"5\"></textarea></TD>");
print("</TR>");
print("<TR>");
	print("<TD>N� dossier SAMU</TD>");
	print("<TD><input type=\"text\" name=\"dossier_samu\" value=\"$rub[dossier_samu]\" size=\"10\"></TD>");
print("</TR>");
print("<TR>");
	print("<TD>N� dossier SDIS</TD>");
	print("<TD><input type=\"text\" name=\"dossier_sdis\" value=\"$rub[dossier_sdis]\" size=\"10\"></TD>");
print("</TR>");
print("<TR>");
	print("<TD>PPI associ�</TD>");
	print("<TD>");
		$null["aucun"]=0;
		genere_select("ppi_id", "ppi","ppi_ID","ppi_nom",$connect,'',$null,'','',false);
	print("</TD>");
print("</TR>");
print("<TR>");
	print("<tr><td><input type=\"checkbox\" name=\"actif\" value=\"o\" checked> en faire l'�v�nement ACTIF ?</tr>");
	print("<tr><td><input type=\"checkbox\" name=\"chantier\" value=\"o\" checked> cr�er un premier chantier</tr>");
	print("<tr><td><input type=\"checkbox\" name=\"pma\" value=\"o\" checked> cr�er un premier PMA</tr>");
	print("<tr><td><input type=\"checkbox\" name=\"pco\" value=\"o\" checked> cr�er un premier PCO</tr>");
print("</TR>");

print("</table>");
print("</BODY>");
print("</FORM>");
print("</html>");
?>
