<?php
//----------------------------------------- SAGEC --------------------------------------------------------

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
/**																										
*	programme: 			apa_login.php									
*	date de création: 	09/09/2003																		
*	auteur:				jcb																				
*	description:		Page de login pour un ambulancier	
*													 											 
*	@version $Id$																			 
*	maj le:				02/11/2003	Ajout maj du fichier connexion ligne 59																	 //
*/																									
//---------------------------------------------------------------------------------------------------------
// ouverture d'une session
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
// identification d'un membre
require 'utilitaires/globals_string_lang.php';
require("pma_connect.php");
include("utilitaires/table.php");
include("HTML.php");
print("<HTML><HEAD><TITLE>Liste des vecteurs</TITLE>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\"></HEAD>");
include("apa_entete.php");

if($login !="" && $password !="")
{
	require("PMA_Connexion.php");	// paramètres privés de connexion
	require 'utilitaires/Requete.php';
	// connexion à la base de données
	$connect = Connexion(NOM,PASSE,BASE,SERVEUR);
	$query = "SELECT apa_member_ID, org_ID,apa_member_admin FROM apa_member WHERE apa_member_login ='$login' AND apa_member_pass='$password'";
	$query = "SELECT ID_utilisateur, org_ID,admin FROM utilisateurs WHERE login ='$login' AND pass='$password'";
	$result = ExecRequete($query,$connect);
	$utilisateur = LigneSuivante($result);
	// Il s'agit d'un utilisateur répertorié
	if($utilisateur)
	{
		// on affecte la clé de l'enregistrement à la variable member_id
		$apa_id = $utilisateur->ID_utilisateur;
		$organisme_id = $utilisateur->org_ID;
		// enregistrement des variables de session
		session_register("apa_id");
		// admistrateur ?
		$administrateur = $utilisateur->admin;
		session_register("administrateur");
		// enregistrement de la langue
		$langue = "FR";
		session_register("langue");
		// variabe bloquant l'afficahe des menus de Sagec
		$nomenu = "1";
		session_register("nomenu");
		// identifiant de l'entreprise
		session_register("organisme_id");
		// mise à jour du fichier connexion
		$date_maj = date("Y-m-j H:i:s");
		$ip = getenv("REMOTE_ADDR");
		$requete="INSERT INTO connexion VALUES('','$apa_id','$date_maj','$ip','$organisme_id')";
		$result = ExecRequete($requete,$connect);
	}
}

if(session_is_registered("apa_id"))
{
	$mot = "Vous êtes enregistré en tant qu'utilisateur n°";
	echo $mot.$apa_id."<br>";
	if($organisme_id != 0)
	{
		$mot = "Mise à jour des véhicules disponibles";
		echo "<a href = \"apa.php\"><H1>$mot</H1></a><br>";
	}
	$mot = "Page d'informations";
	echo "<a href = \"apa_info.php\"><H1>$mot</H1></a><br>";
	$mot = "Quitter la session";
	echo "<a href = \"logout.php\"><H1>$mot</H1></a><br>";
}

else
{
	if(isset($userid))
	{
		//en cas de tentative et d'échec d'une ouverture de session avec authentification
		$mot = $string_lang['MSG_SITE_ACCESSIBLE'][$langue];
		echo $mot;
	}
	else
	{
		// l'utilisateur n'a pas encor essayé d'ouvrir une session ou l'a fermée 
		$mot = $string_lang['MSG_IDENTIFICATION'][$langue];
		echo $mot;
	}

	// AFFICHAGE DU DIALOGUE D'IDENTIFICATION 
	print("<html>");
	print("<head>");
	print("<LINK REL=stylesheet HREF=\"PMA.css\" TYPE =\"text/css\">");
	print("</head>");
	
	print("<form action=\"apa_login.php\" method=\"post\">");
	TblDebut(0,"100%");
	TblDebutLigne();
		TblCellule("<B>Pour vous connecter vous devez être un utilisateur enregistré</B>",1,1,"TITRE");
	TblFinLigne();
	TblFin();
	// zone identification
	print("<fieldset>");
	TblCellule("<legend>".$string_lang['SESSION_IDENTIFICATION'][$langue]."</legend>");
	TblDebut(0,"50%");
	TblDebutLigne();
		TblCellule("Login:");
		TblCellule("<input type=\"text\" name=\"login\" class=\"text\"/>");
	TblFinLigne();
	TblDebutLigne();
		TblCellule("Mot de passe:");
		TblCellule("<input type=\"password\" name=\"password\" class=\"text\">");
		TblCellule("<p><input type=\"submit\" name=\"submit\" value=\" VALIDEZ \" class=\"submit\"></p>");
	TblFinLigne();
	TblFin();
	print("</fieldset>");

	print("</form>");
}

?>
