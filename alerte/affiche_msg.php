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

/**
* Affichage d'un message d'information important
*/
//----------------------------------------- SAGEC --------------------------------------------------------
//	programme: 			affiche_msg.php
//	date de cr�ation: 	28/05/2006							
//	auteur:				jcb				
//	description:		Affichage d'un message d'information important
//	version:			1.0				
//	maj le:				28/05/2006		
// @version $Id: affiche_msg.php 23 2007-09-21 03:50:41Z jcb $						
//---------------------------------------------------------------------------------------------------------

session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(! $_SESSION['auto_sagec'])header("Location:logout.php");

if($_REQUEST['ok'])
{
	//header("Location:../../logout.php");
	header("Location:../../sagec67.php");
}

$No_message = 0;
$message = "message_".$No_message.".txt";
/*
$f = fopen($message,"r");
$texte = fread($f);
fclose($f);
*/
print("<textarea name=\"text\" cols=\"30\" rows=\"5\" readonly> $texte");
print("</textarea>");
print("<input type=\"submit\" name=\"ok\" value=\"continuer\">");
?>