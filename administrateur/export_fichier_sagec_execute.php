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
//
//	programme: 		export_fichier_sagec_execute.php
//	date de cr�ation: 	20/08/2005
//	auteur:			jcb
//	description:		r�cup�re un fichier php sur le serveur
//	version:			1.2
//	maj le:			20/08/2005
//
//--------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------
if($_REQUEST['ok'])
{
	$v = $_REQUEST['fichier'];
	header("Content-disposition: filename=".basename($v));
	header("Content-type: application/octetstream");
	header("Pragma: no-cache");
	header("Expires: 0");
	readfile("$v");
	exit();
}
?>