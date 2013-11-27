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
//	programme:			captcha.php
//	date de création:	09/04/2008
//	auteur:				dnd
//	description:		récupère un couple question / réponse retourne la question et met la réponse en 
//						session (SES_LOGIN_REPONSE)
//	version:			1.0
//
//---------------------------------------------------------------------------------------------------------

// ouverture d'une session
session_start();

require($backPathToRoot."utilitaires/stringUtil.php");

function getShellQuestion ($locale){
	
	$url = "http://localhost:8080/Captcha/GetCaptcha?lang=".$locale;
	//$url = "http://localhost/tomcat/Captcha/GetCaptcha?lang=".$locale;            
	$http_page = file_get_contents($url);
	print ("$http_page");
	
	$output = array ();
	$pos = strrpos($http_page, "|");
	if ($pos === false){
		print ("Erreur, pas de séparateur");
	}
	else {
		$output[0] = captchaStrToHtml(substr($http_page, 0, $pos));
		$output[1] = strtoupper(trim(substr($http_page, $pos +1, strlen($http_page))));
	}
	// met la réponse dans la session
	$_SESSION["SES_LOGIN_REPONSE"] = $output[1]; 

	// retourne la question
	return $output[0];
}
?>
