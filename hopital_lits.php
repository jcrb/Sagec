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
//----------------------------------------- SAGEC --------------------------------------------------------
//																										 
//	programme: 			hopital_lits.php																	 	
//	date de création: 	14/12/2003																		
//	auteur:				jcb																			
//	description:		Permet à un utilisateur autorisé, de mettre à jour les disponibilités d'un hopital
//	version:			1.0																				 
//	maj le:				14/12/2003																		
//																										
//---------------------------------------------------------------------------------------------------------
session_start();
require 'utilitaires/globals_string_lang.php';
include("utilitairesHTML.php");
require("pma_connect.php");
require("pma_connexion.php");

require ("menu_hopital.php");
MenuHopital($langue);

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$hopital = $organisation;
$type_s = 0;
$back = "hopital_lits.php";
Table_Lits($connexion,$hopital,$type_s,$langue,$back);
?>
