<?php
//----------------------------------------- SAGEC ------------------------------

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
//------------------------------------------------------------------------------
/** 
*	page_de_test.php
* 	teste affichage limité à qq lignes
*	date de création: 20/06/2008		 
*	@author:			jcb		  
*	@version:	$Id$	 
*	maj le:				
*	@package			sagec
*/
//------------------------------------------------------------------------------
session_start();
// page réservée à l'administrateur
if(!($_SESSION['auto_sagec'] &&($_SESSION['autorisation']>9))) header("Location:logout.php");
print("<fieldset class=\"Style22\">");
	print("<LEGEND >Développements en cours</LEGEND>");
	print("<p><a href=\"procedures/procedure_main.php\">Procédures</a></p>");
	print("<p><a href=\"reporting/analyse_usic_nhc.php\">Graphe USIC NHC</a></p>");
	print("<p><a href=\"pharmacies/extract_pharma_finess.php\">Finess pharmacie</a></p>");
	print("<p><a href=\"veille_sanitaire/alerte/alerte_frameset.php\">Activité SAU</a></p>");
	
	print("<p><a href=\"veille_sanitaire/alerte_new/alerte_main.php\">Activité SAU new</a></p>");
	
	print("<p><a href=\"dsa/dsa_nouveau.php\">DSA</a></p>");
	print("<p><a href=\"victime/test.php\">liste</a></p>");
	print("<p><a href=\"arh/test.php\">drass</a></p>");
	print("<p><a href=\"utilitaires/csv2mysql.php\">Import CSV</a></p>");
	print("<p><a href=\"hopital/listing_hopitaux.php\">Hôpitaux Allemands</a></p>");
	print("<p><a href=\"hopital/activite_et_capacite.php\">Activité et capacités</a></p>");
	print("<p><a href=\"temp/ekiga.php\">Appel Sagec 1 (essai Ekiga)</a></p>");
	print("<p><a href=\"sig/way_saisie.php\">Création SIG</a></p>");
	
	print("<p><a href=\"hopital/hopitaux_par_zone.php\">Hopitaux allemands</a></p>");
	print("<p><a href=\"pdf/test_pdf.php\">Test PDF</a></p>");
	print("<p><a href=\"administrateur/tables/type_objet/list.php\">maj tables</a></p>");
	
	print("<A HREF = \"wap/test1.php\">WAP test1</A><BR>");
	print("<A HREF = \"wap/test2.php\">WAP test2</A><BR>");
	
	print("<A HREF = \"ppi/plume/plume_test.php\">Plume</A><BR>");
	print("<A HREF = \"veille_sanitaire/rpu/lanceur_rpu.php\">teste RPU 2 XML</A><BR>");
	print("<A HREF = \"veille_sanitaire/rpu/routines_rpu.php\">routines RPU</A><BR>");
	print("<A HREF = \"veille_sanitaire/rpu/rpu_xpath.php\">routines XPATH</A><BR>");
	print("<A HREF = \"plan_blanc/gestion_samu/samu_frameset.php\">Plan Blanc</A><BR>");
	
	print("<A HREF = \"organisme2adresse.php\">Organisme2adresse</A><BR>");
	print("<A HREF = \"../Google/Digitaliseur/digitaliseur.php\" target=\"_blank\" >Digitaliseur</A><BR>");
	print("<A HREF = \"aa_google/rayon_danger.php\" target=\"_blank\" >Rayon de danger</A><BR>");
	print("<A HREF = \"serveur/serveur_main.php\" target=\"_blank\" >Serveur identifiant</A><BR>");
	print("<A HREF = \"dossier_cata/dossier_cata_main.php\" >Dossier cata</A><BR>");
	print("<A HREF = \"victime/create_data/index.php\" >Peuple la table victime</A><BR>");
	
	print("<A HREF = \"crisehus/crisehus_frameset.php\" >CELLULE DE CRISE HUS - Ancienne version</A><BR>");
		
print("</fieldset>");
?>
