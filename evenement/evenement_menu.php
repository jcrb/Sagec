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
/**
//	programme: 			evenement_menu.php
//	date de création: 	12/11/2004
//	@author:			jcb
//	description:
//	@version:			1.0 - $Id: evenement_menu.php 25 2008-01-13 10:17:33Z jcb $
//	maj le:				14/08/2006
*/
//---------------------------------------------------------------------------------------------//
print("<head><meta http-equiv=\"content-type\" content=\"text/html; charset=ISO-8859-15\">");
print("<title>menu evènement</title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("</head>");

//print("<fieldset class=\"time_v\">");
//print("<legend> Menu </legend>");

print("<fieldset class=\"time_v\">");
	print("<legend> Quitter </legend>");
		print("<table width=\"100%\">");
		print("<TR><TD><A HREF=\"../ppi/ppi_frameset.php\" target=\"_parent\">Retour</A></TD></TR>");
		print("<TR><TD><A HREF=\"../evenements/evenement_main.php\" target=\"_blank\" >NOUVEAU DOSSIER</A></TD></TR>");
		print("</table>");
print("</fieldset>");



print("<fieldset class=\"time_v\">");
	print("<legend> Evènement </legend>");
		print("<table width=\"100%\">");
		print("<TR><TD><A HREF=\"evenements.php\" target=\"bottom\">Evènements</A></TD></TR>");
		print("<TR><TD><A HREF=\"evenement_nouveau.php\" target=\"bottom\">Nouveau</A></TD></TR>");
		print("<TR><TD><A HREF=\"evenement_maj.php\" target=\"bottom\">Mise à jour</A></TD></TR>");
		print("<TR><TD><A HREF=\"evenement_courant.php\" target=\"bottom\">Courant</A></TD></TR>");
		print("<TR><TD><A HREF=\"evenement_actif.php\" target=\"bottom\">Evènement ACTIF</A></TD></TR>");
		print("<TR><TD><A HREF=\"donnees_mto.php\" target=\"bottom\">Météo</A></TD></TR>");
		print("</table>");
print("</fieldset>");

print("<fieldset class=\"time_v\">");
	print("<legend> Plans </legend>");
		print("<table width=\"100%\">");
		print("<TR><TD><A HREF=\"evenement_plan.php\" target=\"bottom\">Plan</A></TD></TR>");
		print("<TR><TD><A HREF=\"evenement_plan_nouveau.php\" target=\"bottom\">Nouveau</A></TD></TR>");
		print("</table>");
print("</fieldset>");

print("<fieldset class=\"time_v\">");
	print("<legend> PPI </legend>");
		print("<table width=\"100%\">");
		print("<TR><TD><A HREF=\"../ppi/ppi_liste.php\" target=\"bottom\">PPI</A></TD></TR>");
		print("<TR><TD><A HREF=\"../ppi/ppi_nouveau.php\" target=\"bottom\">Nouveau</A></TD></TR>");
		print("</table>");
print("</fieldset>");

print("<fieldset class=\"time_v\">");
	print("<legend> Stockages </legend>");
		print("<table width=\"100%\">");
		print("<TR><TD><A HREF=\"../ppi/ppi_stockage/ppi_stock.php\" target=\"bottom\">Nouveau</A></TD></TR>");
		print("<TR><TD><A HREF=\"../ppi/ppi_stockage/stocks_liste.php\" target=\"bottom\">Liste</A></TD></TR>");
		print("</table>");
print("</fieldset>");

print("<fieldset class=\"time_v\">");
	print("<legend> Zones </legend>");
		print("<table width=\"100%\">");
		print("<TR><TD><A HREF=\"../pma/zone_liste.php\" target=\"bottom\">Liste des polygones</A></TD></TR>");
		print("<TR><TD><A HREF=\"\" target=\"bottom\">Liste</A></TD></TR>");
		print("</table>");
print("</fieldset>");

print("<fieldset class=\"time_v\">");
	print("<legend> Divers </legend>");
		print("<table width=\"100%\">");
		print("<TR><TD><A HREF=\"evenement_fin.php\" target=\"bottom\">Fin opérations</A></TD></TR>");
		print("<TR><TD><A HREF=\"vigie_pirate.php\" target=\"bottom\">Vigie pirate</A></TD></TR>");
		print("<TR><TD><A HREF=\"infos_speciales.php\" target=\"bottom\">Informations spéciales</A></TD></TR>");
		print("<TR><TD><A HREF=\"../pma/pma_frameset.php\" target=\"blank\">Structures</A></TD></TR>");
		print("<TR><TD><A HREF=\"http://gmaps-utility-library.googlecode.com/svn/trunk/mapiconmaker/1.1/examples/markericonoptions-wizard.html\" target=\"bottom\">Créer un marqueur</A></TD></TR>");
		print("</table>");
print("</fieldset>");
?>
