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
// logout.php 
// Désenregistre les variables de session et ferme la session
// si on passe une variable appelée $back contenant l'adresse de retour, le programme
// sera redirigé vers cette adresse
session_start();
require 'utilitaires/globals_string_lang.php';
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$old_user = $_SESSION["member_id"];// variable de session
$langue = $_SESSION["langue"];
unset($_SESSION['member_id']);
session_unset();
session_destroy(); 
header("Location: langue.php");
?>
