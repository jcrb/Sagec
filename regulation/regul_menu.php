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
/**----------------------------------------- SAGEC --------------------------------------------------------
*											
* programme: 			regul_menu.php						
* date de création: 	08/10/2009							
* @author:				jcb	
* @package 				Sagec								
* description:			menu pour le dossier regulation											
-------------------------------------------------------------------------------------------------------*/
//session_start();
//if(! $_SESSION['auto_sagec'])header("Location:logout.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="content-type" content=""text/htm; charset=ISO-8859-15"  >

    <title>Régulation</title>
	 <link rel="stylesheet" href="div.css" type="text/css" media="all" />
    <link rel="stylesheet" type="text/css" media="screen" href="formstyle.css" />
    <link rel="stylesheet" type="text/css" media="print" href="impression.css" />
   <!--  <link href="regul_map.css" rel="stylesheet" type="text/css" /> -->
</head
<div id="sup">
	<h2>
		<? echo Régulation;?>
	</h2>
	<div id="sousup">
		<a href="../sagec67.php">Menu principal</a>
	</div>
</div>

<p><h2><a href="regul_ask.php">geolocalisation</a></h2></p>
<?php
?>