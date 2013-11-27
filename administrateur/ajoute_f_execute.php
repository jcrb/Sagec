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
//	programme: 		ajoute_f_execute.php
//	date de création: 	07/05/2005
//	auteur:			jcb
//	description:		Met le contenu du fichier Centaure dans une table
//	version:			1.0
//	maj le:			07/05/2005
//
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("utilitaire_upload.php");
print("<br>");
if($erreur==0)
{

	$nom_destination = $_POST['dossier'];
	if(move_uploaded_file($tmp, $nom_destination))
	{
		chmod ($nom_destination,07777);
		print("Le fichier ".$nom_destination." a été correctement transféré <br>");
	}
}
?>
