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
//	programme: 		direct.php
//	date de création: 	05/12/2004
//	auteur:			jcb
//	description:		Accès direct à Sagec
//	version:			1.0
//	maj le:			05/12/2004
//
//---------------------------------------------------------------------------------------------------------
require("controle_accès.php");
session_start();
$utilisateur_nom = autorise($_GET['login'], $_GET['password']);
if($utilisateur_nom)
{
	//print($utilisateur_nom);
	$_SESSION['langue'] = "FR";
	header("Location:apa.php");
}
?>