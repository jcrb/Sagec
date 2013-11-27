<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
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
//
//---------------------------------------------------------------------------------------------------------
/**						
*	programme: 			new_password.php
*	date de création: 	5/3/2004
*	@author:			jcb																				
*	@description:		Permet à l'utilisateur de modifier son mot de passe.									
*	@version:			$Id: new_password.php 6 2006-08-02 10:40:30Z jcb $																			
*	maj le:				02/08/2006	
*	@package 			Sagec																	 
*/
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION["langue"];
$back = $_GET['back'];
if(!$back)$back = $_REQUEST['back'];

// identification d'un membre
require 'utilitaires/globals_string_lang.php';
include("utilitaires/table.php");
$modif = false;

if($_REQUEST['login'] && $_REQUEST['password'])
{
	require("pma_connexion.php");	// paramètres privés de connexion
	require("pma_connect.php");// fonction connexion
	require 'utilitaires/requete.php';
	$login = $_REQUEST['login'];
	$password=crypt(trim(htmlspecialchars(addslashes($_REQUEST['password']))),"azerty");
	// connexion à la base de données
	$connect = connexion(NOM,PASSE,BASE,SERVEUR);
	//$query = "SELECT apa_member_ID FROM apa_member WHERE apa_member_login ='$login' AND apa_member_pass='$password'";
	$query = "SELECT ID_utilisateur FROM utilisateurs WHERE login ='$login' AND pass='$password'";
	$result = ExecRequete($query,$connect);
	$utilisateur = LigneSuivante($result);
	// Il s'agit d'un utilisateur répertorié
	if($utilisateur)
	{
		//$password2 = trim(htmlspecialchars(addslashes($_SESSION['password2'])));
		//$password2 = md5($password2);
		if(strlen($_REQUEST['password2']) < '6' )
		{
			$error = 3;
		}
		elseif($_REQUEST['password2'] != $_REQUEST['password3'])
			$error = 1;
		else
		{
			$password2=crypt(trim(htmlspecialchars(addslashes($_REQUEST['password2']))),"azerty");
			$query = "UPDATE utilisateurs SET pass = '$password2' WHERE ID_utilisateur = $utilisateur->ID_utilisateur";
		//print($query);
			$result = ExecRequete($query,$connect);
			$modif=true;
		}
	}
	else
	{
		$error = 2;
	}
}

// AFFICHAGE DU DIALOGUE D'IDENTIFICATION 
	print("<html>");
	print("<head>");
	print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
	print("</head>");
	print("<form action=\"new_password.php\" method=\"POST\">");
	TblDebut(0,"100%");
	TblDebutLigne();
		TblCellule("<B>SAGEC 67</B>",1,1,"TITRE");
	TblFinLigne();
	TblFin();

// zone identification
	print("<fieldset>");
	//TblCellule("<legend>".$string_lang['SESSION_IDENTIFICATION'][$langue]."</legend>");
	TblCellule("<legend>Modifier le mot de passe</legend>");
	TblDebut(0,"75%");
	TblDebutLigne();
		TblCellule($string_lang['SESSION_LOGIN'][$langue]);
		TblCellule("<input type=\"text\" name=\"login\" class=\"text\" value=\"$_REQUEST[login]\"/>");
		//TblCellule("<a href = \"$back\">RETOUR</a><br>");
		TblCellule("<input type=\"submit\" name=\"submit\" value=\" OK \" class=\"submit\">");
	TblFinLigne();
	TblDebutLigne();
		TblCellule($string_lang['SESSION_PASSWORD'][$langue]);
		TblCellule("<input type=\"password\" name=\"password\" class=\"text\" value=\"\">");
	TblFinLigne();
	TblDebutLigne();
		//TblCellule($string_lang['SESSION_PASSWORD'][$langue]);
		TblCellule("Nouveau mot de passe");
		TblCellule("<input type=\"password\" name=\"password2\" class=\"text\">");
	TblFinLigne();
	TblDebutLigne();
		//TblCellule($string_lang['SESSION_PASSWORD'][$langue]);
		TblCellule("Nouveau mot de passe");
		TblCellule("<input type=\"password\" name=\"password3\" class=\"text\">");
		if($modif)
			TblCellule("Le mot de passe a été modifié");
	TblFinLigne();
	if($error != 0)
	{
		print("<tr><td class=\"verda\">");
		switch($error)
		{
		case 1:print("Le nouveau mot de passe est incorrect");break;
		case 2:print("Erreur de login ou de password");break;
		case 3:print("Le mot de passe doit comporter au moins 6 caractères");break;
		}
		$modif= false;
		print("</td></tr>");
	}
	TblFin();
print("</fieldset>");

print("<p><input type=\"hidden\" name=\"back\" value=\"$back\"></p>");
//print("<p><input type=\"submit\" name=\"submit\" value=\" OK \" class=\"submit\"></p>");
print("<p><a href = \"$back\">RETOUR</a></p>");

print("<p class=\"time\">Un mot de passe doit comporter au minimum 6 caractères. Il peut comporter des chiffres, des lettres, un panachage des deux. Pour les lettres, on peut mélanger des majuscules et des minuscules en se souvenant que le mot de passe est sensible à la casse; ainsi 'AAAAAA' est différent de 'aaaaaa' </p>");
print("</form>");
?>
