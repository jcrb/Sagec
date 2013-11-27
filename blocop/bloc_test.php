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
//----------------------------------------- SAGEC ---------------------------------------------
/**
 * bloc_test.php
 * @package Sagec
 * @version $Id: sagec67.php 19 2006-11-19 18:21:13Z jcb $
 * @author JCB
 * @date: 20/12/2006
 */											
//---------------------------------------------------------------------------------------------
?>
<html>
<head>
	<link rel=stylesheet href="blocop.css" type="text/css"/>
	<style>
		.indisponible{
			background-color: red;
			text-align: center;
			color: black;
		}
		.dispo_operationnelle{
			background-color: green;
			text-align: center;
			color: white;
		}
</style>
	<script>
		function color(id)
		{
			if(id.className=='indisponible')
			{
				id.className='dispo_operationnelle';
				id.value = 'Disponible';
			}
			else
			{
				id.className='indisponible';
				id.value = 'Indisponible';
			}
		}
	</script>
</head>

<form name="truc" action="bloc_test.php">
<table>
  <tr>
    <td id="c1" class="indisponible" onClick="color(c1);">
      
    </td>
    <td class="rouge">
      toujours blanc
    </td>
  </tr>
  <tr>
    <td>
      ligne rouge
    </td>
    <td>
      <input type=text value="cellule rouge" id="rouge" />
    </td>
  </tr>
</table>


<input type=button onclick="maj();">
</form>
</html>
<?
?>