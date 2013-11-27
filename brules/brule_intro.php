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
//----------------------------------------- SAGEC ---------------------------------------------//
//
//	programme: 		brule_intro.php
//	date de création: 	20/11/2005
//	auteur:			jcb
//	description:
//	version:			20/11/2005
//
//---------------------------------------------------------------------------------------------//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
print("<html>");

print("<head>");
print("<title>SAGEC67 - Portail Brûlés </title>");
print("<meta name=\"keywords\" content=\"\" lang=\"fr\">");
print("</head>");


switch($langue)
{
	case 'FR':
		print("AIDE À LA RECHERCHE D'UN CENTRE DE GRANDS BRÛLES");
		print("<br>");
		print("<p>");
		print("Cette partie du site est en cours de développement. Toutes les options ne sont pas encore fonctionelles et l'interface peut encore évoluer. La traduction de catte partie est également en cours <br> A terme ces pages devraient afficher tous les centres de brûlés répertoriés en Europe. A ce jour figurent la France, l'Allemagne, la Suisse et la Belgique");
		print("</p>");
		print("<p>");
		print("Merci de faire part de vos remarques, critiques, suggestions à l'adresse suivante: ");
		print("<a href=\"mailto:jcb-bartier@wanadoo.fr\">cliquez-ici</a>");
		break;
	case 'GE':
		print("HILFE FÜR DIE SUCHE NACH EINEM BURN CENTER");
		print("<br>");
		print("<p>");
		print("Dieser Teil des Gebiets wird entwickelt.  Alle Optionen sind nicht noch funktionell, und die Schnittstelle kann sich noch entwickeln.  Die Übersetzung ist ebenfalls im Gange.  Auf Zeit müßten diese Seiten alle in Europa klassierten Burn Centers anschlagen. Stellen Bis heute Frankreich, Deutschland, die Schweiz und Belgien");
		print("</p>");
		print("<p>");
		print("Danke der folgenden Adresse Ihre Bemerkungen, Kritiken, Anregungen mitzuteilen: ");
		print("<a href=\"mailto:jcb-bartier@wanadoo.fr\">hier drücken Sie</a>");
		break;
	case 'UK':
		print("HELP TO THE SEARCH OF A BURN CENTER");
		print("<br>");
		print("<p>");
		print("This part of the site is under development.  All the options are not yet functional and the interface can still evolve/move.  The translation of catte left is also in progress.  With term these pages should post all the burn centers indexed in Europe.  To date appear France, Germany, Switzerland and Belgium");
		print("</p>");
		print("<p>");
		print("Thank you to make share of your remarks, critical, suggestions with the following address: ");
		print("<a href=\"mailto:jcb-bartier@wanadoo.fr\">press here</a>");
		break;
}
print("</p>");
print("</html>");
?>