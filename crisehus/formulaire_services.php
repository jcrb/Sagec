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
//----------------------------------------- SAGEC --------------------------------------------------------
/**
*	programme: 		formulaire_services.php
*	description:	lits disponibles en cas de crise
*	date de création: 	23/02/2008
*	@author:			jcb
*	@version:		$Id: formulaire_services.php 40 2008-03-03 07:25:43Z jcb $
*	maj le:			
*/
//---------------------------------------------------------------------------------------------------------
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
	<title>Uformulaire plan blanc</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<link href="crise.css" rel="stylesheet" type="text/css" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
</head>

<body onload="document.getElementById('nom').focus()">
	<form id="catalogue" action="enregistre_lits.php" method="post">
	
	<div id="formtitle">Plan Blanc - Etat actuel et prévisionnel des lits</div>
	
	<div id="content">
	
		<fieldset id="coordonnees">
		<legend> Disponibilités en lits</legend>
		
		<p>
		<table>
			<tr>
				<th>Code UF</td>
				<th>Lits disponibles immédiatement</th>
				<th>Lits disponibles dans 6h</th>
				<th>Lits disponibles dans 12h</th>
				<th>Lits disponibles dans 24h</th>
			</tr>
			<?php for ($i=0; $i<5; $i++)
			{ ?>
			<tr>
				<td><input type="text" name="uf[]" size="4" value="1234" id=""></td>
				<td><input type="text" name="lits_t0[]" size="4" id=""></td>
				<td><input type="text" name="lits_t1[]" size="4" id=""></td>
				<td><input type="text" name="lits_t2[]" size="4" id=""></td>
				<td><input type="text" name="lits_t3[]" size="4" id=""></td>
			</tr>
			<?php } ?>
		</table>
		</p>
		
		
	</fieldset>
	<br />
	
	</div>
	
	<div id="formfooter">
		<p>			
			<input type="submit" name="BtnSubmit" id="valid" value="Valider" />
			<input type="reset" name="BtnClear" id="annul" value="Annuler" />
		</p>
	</div>
	
	</form>
</body>

</html>
