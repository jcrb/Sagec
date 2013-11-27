<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
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
//		
/*
Saisie de l'identifiant d'un patient dans la variable $identifiant qui sera transmise
au programme Tri2
*/
session_start();
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$langue = $_SESSION['langue'];
$member_id = $_SESSION['member_id'];
include("en_tete.php");
require 'utilitaires/globals_string_lang.php';

entete($member_id,$langue);
?>
<html>
	<head>
		<title>Saisir un nouvel identifiant</title>
		<script  type="text/javascript" src="utilitaires.js"></script>
		<link rel="stylesheet" href="div.css" type="text/css" media="all" />
		<script>
			function controle()
			{
				if(document.forms[0].identifiant.value != "")
				{
					return true;
				}
				else
				{
					alert('il faut obligatoirement un identifiant');
					return false;
				}
			}
		</script>
	</head>

	<body onload="document.getElementById('code').focus()" bgcolor="#ffffff">
	<!--
		<form action="victime/victime_saisie.php" method="GET" onsubmit="return controle()">
	
	-->
		<form action="victimes_saisie.php" method="GET" onsubmit="return controle()">
	
		<table width="542" border="0" cellspacing="2" cellpadding="0">
			<tr>
				<td >
					<div align="right"><H2><?php print($string_lang['NOUVEAU_PATIENT'][$langue]); ?></H2></div>
				</td>
			</tr>
			<tr>
				<td><div align="right"> <?php print($string_lang['IDENTIFIANT'][$langue]); ?></div> </td>
				<td><div align="right"><input type="text" name="identifiant" size="24" border="0" id="code" onFocus="_select('code');" onBlur="deselect('code');"></td>
				<?php $mot=$string_lang['NOUVEAU_PATIENT'][$langue]; 
				print("<td><div align=\"right\"><input type=\"submit\" name=\"Soumettre\" value=\"$mot\" width =\"100\" border=\"0\"></div></td>");
				?>
			</tr>
		</table>
		<p></p>
	</body>
</form>
</html>
