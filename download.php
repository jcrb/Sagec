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
//----------------------------------------- SAGEC --------------------------------------------------------
//													//
//	programme: 		download.php								//
//	date de création: 	10/04/2004								//
//	auteur:			jcb									//
//	description:		Export d'un fichier text vers le client					//
//	version:		1.0									//
//	maj le:			10/04/2004								//
//													//
//--------------------------------------------------------------------------------------------------------
// $_GET[filname] 	nom du fichier ex.mon_archive.txt
// $_GET[dir]		nom d'accès complet ex. /var/www/html/SAGEC 67/archives/mon_archive.txt
//--------------------------------------------------------------------------------------------------------
//
 $type = "text/plain";
 header("Content-disposition: attachment; filename=$_GET[filname]");
 header("Content-Type: application/force-download");
 header("Content-Transfer-Encoding: $type\n"); // Surtout ne pas enlever le \n
 header("Content-Length: ".filesize($_GET[dir]));
 header("Pragma: no-cache");
 header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0, public");
 header("Expires: 0");
 readfile($_GET['dir']);

//print("nom fichier: ".$_GET['filname']."<BR>");
//print("nom accès: ".$_GET['dir']."<BR>");
 ?>