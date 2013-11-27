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

// communes_secteur.php
require("pma_connect.php");
require("pma_connexion.php");
require("pma_requete.php");
include("utilitairesHTML.php");

print("<HTML><HEAD><TITLE>Liste des vecteurs</TITLE>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\"></HEAD>");
print("<FORM name =\"Lits\"  ACTION=\"communes_secteurs.php\" METHOD=\"GET\">");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
print("Sélectionner un secteur: ");

if($_GET['zone'] == 'apa')
{
	SelectSecteur($connexion,$_GET['secteur_ID']); // au retour secteur_ID contient le n° du secteur concerné
	Liste_des_communes($connexion,$_GET['secteur_ID'],'apa');
}
else
{
	SelectSecteurPds($connexion,$_GET['secteur_ID']);
	Liste_des_communes($connexion,$_GET['secteur_ID'],'pds');
}

print("</FORM>");
?>
