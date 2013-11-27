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
session_start();
$langue = $_SESSION['langue'];
$member_id = $_SESSION['member_id'];
if(! $_SESSION['auto_sagec'])header("Location:logout.php");

include("en_tete.php");
require("pma_connect.php");
require("pma_connexion.php");
require 'utilitaires/requete.php';

entete($member_id,$langue);

$connect = Connexion(NOM,PASSE,BASE,SERVEUR);
$requete = "SELECT evenement_nom from evenement WHERE evenement_ID = '$_SESSION[evenement]'";
$resultat = ExecRequete($requete,$connect);
$rub=mysql_fetch_array($resultat);

			print("Evènement actif courant: ".$rub['evenement_nom']."<br>");
		print("</form>");
print("</body>");
print("</html>");

?>
