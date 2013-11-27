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
//	programme: 		resultat.php
//	date de création: 	12/02/2005
//	auteur:			jcb
//	description:		Exécution d'unstructions SQL
//	version:			1.0
//	maj le:			12/02/2005
//
//--------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
require("../../pma_connect.php");
require("../../pma_connexion.php");
require '../../utilitaires/requete.php';
require("../../html.php");
$connect = Connexion(NOM,PASSE,BASE,SERVEUR);

// éliminer les caractères interdits rajoutés par HTML
function CheckValidName($str1)
{
    //$invalide = array('\\','/',':','*','?','"','<','>','|');
    $invalide = array('\\','/','|',';');
    $i=0;
    while ($invalide[$i])
    {
        $str1 = strtr($str1, $invalide[$i], " ");
        $i++;
    }
                
    return $str1;
}

print("<HTML><HEAD><TITLE>SQL</TITLE>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\"></HEAD>");

print("<FORM name =\"resultat\">");
//print("Requête SQL<br><br>");
if($_GET["ok"]=='valider')
{
	$requete = CheckValidName($_GET["requete"]);
	$resultat = ExecRequete($requete,$connect);
	if($resultat)
	{
		print("Requete: ");
		print($requete);
		print(" Réussie <br>");
	}
}
print("</FORM>");
print("</HTML>");
?>
