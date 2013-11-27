<?php
//----------------------------------------- SAGEC --------------------------------------------------------
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
//	programme: 		utilitaire_upload.php
//	date de création: 	07/05/2005
//	auteur:			jcb
//	description:		décrit le fichier uploadé
//	version:			1.0
//	maj le:			07/05/2005
//
//--------------------------------------------------------------------------------
//
$fichier= $_FILES['fichier']['name'];
$taille= $_FILES['fichier']['size'];
$tmp= $_FILES['fichier']['tmp_name'];
$type= $_FILES['fichier']['type'];
$erreur= $_FILES['fichier']['error'];

print("<table border=\"1\">");
print("<tr><td>Nom originel</td><td>$fichier</td></tr>");
print("<tr><td>Taille</td><td>$taille</td></tr>");
print("<tr><td>Adresse temporaire sur le serveur</td><td>$tmp</td></tr>");
print("<tr><td>Type de fichier</td><td>$type</td></tr>");
print("<tr><td>Code erreur</td><td>$erreur</td></tr>");
if ($err = $_FILES['fichier']['error']){
	if($err == UPLOAD_ERR_INI_SIZE)
  		$err = "Le fichier est plus gros que le max autorisé par PHP";
	elseif($err == UPLOAD_ERR_FORM_SIZE)
		$err = "Le fichier est plus gros qu'indiqué dans le formulaire";
	elseif($err == UPLOAD_ERR_PARTIAL)
  		$err = "Le fichier n'a été que partiellement téléchargé";
	elseif($err == UPLOAD_ERR_NO_FILE)
  		$err = "Aucun fichier n'a été téléchargé.";
} else $err = "fichier correctement téléchargé" ;
print("<tr><td>analyse</td><td>$err</td></tr>");
print("</table>");
?>