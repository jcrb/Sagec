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
//----------------------------------------- SAGEC --------------------------------------------------------
/**
 *
 * rpu.php
 *
 * Résumé de passage aux urgences
 * @date date de création: 	10/02/2007
 * @author jcb <jcb-bartierg@wanadoo.fr>
 * @version 1.0 $Id: rpu.php 23 2007-09-21 03:50:41Z jcb $
 * @package Sagec
 */
 
define(MUTATION,6);
define(TRANSFERT,7);
define(DOMICILE,8);

function choix($a,$b){
	if($a == $b) print ("SELECTED");
}

print("<Head>");
print("<link rel=\"stylesheet\" type=\"text/css\" href=\"rpu.css\">");
print("</head>");

print("<form name=\"RPU\" action=\"rpu.php\" method=\"get\">");

print("<div id=\"renseignements\">");
print("<FIELDSET>");
print("<LEGEND> Renseignements </LEGEND>");
print("<table>");
	print("<tr>");
		print("<td align=\"right\">N° d'admission</td>");
		print("<td><input type=\"text\" name=\"nip\" value=\"\"></td>");
		print("<td align=\"right\">ville</td>");
		print("<td><input type=\"text\" name=\"ville\" value=\"\"></td>");
		print("<td align=\"right\">code postal</td>");
		print("<td><input type=\"text\" name=\"zip\" value=\"\"></td>");
	print("</tr>");
	print("<tr>");
		print("<td align=\"right\">date de naissance</td>");
		print("<td><input type=\"text\" name=\"date_naissance\" value=\"jj/mm/aaaa\"></td>");
		print("<td align=\"right\">sexe</td>");print("<td>");
		
		print("<select name=\"sexe\" size=\"1\">");
			print("<option value=\"M\">Homme</option>");
			print("<option value=\"F\">Femme</option>");
			print("<option value=\"I\" selected>Indéterminé</option>");
		print("</select>");
	print("</td></tr>");
	print("<tr>");
		print("<td align=\"right\">date d'entrée</td>");
		print("<td><input type=\"text\" name=\"date_admission\" value=\"jj/mm/aaaa\"></td>");
		print("<td align=\"right\">heure d'entrée</td>");
		print("<td><input type=\"text\" name=\"heure_admission\" value=\"HH:MM\"></td>");
	print("</tr>");
print("</TABLE>");
print("</FIELDSET>");
print("</div>");

print("<div id=\"entree\">");
$mode_entree = $_REQUEST['mode_entree'];
print("<FIELDSET>");
print("<LEGEND> ENTREE </LEGEND>");
print("<TABLE>");
	print("<tr>");
		print("<td align=\"rigth\">mode d'entrée</td>");
		print("<td>");

		print("<select name=\"mode_entree\" size=\"1\" onChange = javascript:document.RPU.submit();>");
			print("<option value=\"0\" ");choix($mode_entree,0); print(">-- mode de entrée--</option>");
			print("<option value=\"6\" ");if($mode_entree==6) echo 'SELECTED';print(">Mutation</option>");
			print("<option value=\"7\" ");if($mode_entree==7) echo 'SELECTED';print(">Transfert</option>");
			print("<option value=\"8\" ");if($mode_entree==8) echo 'SELECTED';print(">Domicile</option>");
		print("</select>");
	print("</td></tr>");
	
	print("<tr>");
	$provenance = $_REQUEST['provenance'];
		print("<td align=\"rigth\">provenance</td>");
		print("<td>");
		
		print("<select name=\"provenance\" size=\"1\">");
		print("<option value=\"0\" ");choix($provenance,0);print(">Sans objet</option> ");
		if($mode_entree==MUTATION || $mode_sortie==TRANSFERT)
		{
			print("<option value=\"1\">En provenance d'une unité de soins de courte durée (MCO)</option>");
			print("<option value=\"2\">En provenance d'une unité de SSR</option>");
			print("<option value=\"3\" selected>En provenance d'une unité de soins de longue durée</option>");
			print("<option value=\"4\">En provenance d'une unité de psychiatrie</option>");
		}
		elseif($mode_entree==DOMICILE) 
		{
			print("<option value=\"5\">Prise en charge AUTRE que pour des raisons organisationnelles</option>");
			print("<option value=\"8\">Prise en charge pour des raisons organisationnelles</option>");
		}
		print("</select>");
	print("</td></tr>");
	print("</DIV");
	
	print("<tr>");
		print("<td align=\"rigth\">Transporteur</td>");
		print("<td>");
		
		print("<select name=\"Transport\" size=\"1\">");
			print("<option value=\"1\">Personnel</option>");
			print("<option value=\"2\">Ambulance</option>");
			print("<option value=\"3\">VSAB</option>");
			print("<option value=\"4\">SMUR</option>");
			print("<option value=\"5\">Hélicoptère</option>");
			print("<option value=\"6\">Forces de l'ordre</option>");
		print("</select>");
		
	print("</td></tr>");
	print("<tr>");
		print("<td align=\"rigth\">Accompagnement</td>");
		print("<td>");
		
		print("<select name=\"Transport_pec\" size=\"1\">");
			print("<option value=\"1\">Médical</option>");
			print("<option value=\"2\">Paramédical</option>");
			print("<option value=\"3\" selected>Aucun</option>");
		print("</select>");
		
	print("</td></tr>");
	print("<tr>");
		print("<td align=\"rigth\">motif de recours aux urgences</td>");
		print("<td><input type=\"text\" name=\"motif_recours\" value=\"\"></td>");
	print("</tr>");
	print("<tr>");
		print("<td align=\"rigth\">Gravite</td>");
		print("<td>");
		
		print("<select name=\"gravite\" size=\"1\">");
			print("<option value=\"1\">CCMU 1</option>");
			print("<option value=\"2\">CCMU 2</option>");
			print("<option value=\"3\">CCMU 3</option>");
			print("<option value=\"4\">CCMU 4</option>");
			print("<option value=\"5\">CCMU 5</option>");
			print("<option value=\"6\">CCMU P</option>");
			print("<option value=\"7\">CCMU D</option>");
		print("</select>");
	print("</td></tr>");
	
	print("<tr>");
		print("<td align=\"rigth\">diagnostic principal</td>");
		print("<td><input type=\"text\" name=\"diag1\" value=\"\"></td>");
	print("</tr>");
	
	print("<tr>");
		print("<td align=\"rigth\">diagnostics associés</td>");
		print("<td><input type=\"text\" name=\"diag2\" value=\"\"></td>");
	print("</tr>");
	
	print("<tr>");
		print("<td align=\"rigth\">actes</td>");
		print("<td><input type=\"text\" name=\"actes\" value=\"\"></td>");
	print("</tr>");
	
print("</table>");
print("</div>");

print("<div id=\"sortie\">");
print("<FIELDSET>");
print("<LEGEND class=\"time\"> SORTIE </LEGEND>");
//$onChange = "document.RPU.submit();";
$mode_sortie = $_REQUEST['mode_sortie'];
print("<table>");
?>
<tr align="left" bgcolor="#FFA500">
	<td>Mode de sortie</td>
	<td><select name="mode_sortie" size="1" onChange = javascript:document.RPU.submit();>
		<option value="0" <?php if($mode_sortie==0) echo 'SELECTED'; ?> >-- mode de sortie--</option>
		<option value="6" <?php if($mode_sortie==6) echo 'SELECTED'; ?> >Mutation</option>
		<option value="7" <?php if($mode_sortie==7) echo 'SELECTED'; ?> >Transfert</option>
		<option value="8" <?php if($mode_sortie==8) echo 'SELECTED'; ?> >Domicile</option>
		<option value="9" <?php if($mode_sortie==9) echo 'SELECTED'; ?> >Décès</option>
	</select></td>
</tr>
<?php



$destination = $_REQUEST['destination'];
print("<tr align=\"left\" bgcolor=\"#FFA500\">");
	print("<td>Destination</td>");
	print("<td><select name=\"destination\" size=\"1\" onChange = javascript:document.RPU.submit();>");
	print("<option value=\"0\" ");choix($destination,0);print(">Sans objet</option> ");
	if($mode_sortie==MUTATION || $mode_sortie==TRANSFERT)
	{
		print("<option value=\"1\" ");choix($destination,1);print(">Hospitalisation dans une unité de soins de courte durée (MCO)</option> ");
		print("<option value=\"2\" ");choix($destination,2);print(">Hospitalisation dans une unité de soins de soins de suite ou de réadaptation</option> ");
		print("<option value=\"3\" ");choix($destination,3);print(">Hospitalisation dans une unité de soins de longue durée</option> ");
		print("<option value=\"4\" ");choix($destination,4);print(">Hospitalisation dans une unité de psychiatrie</option> ");
	}
	elseif($mode_sortie==DOMICILE)
	{
		print("<option value=\"6\" ");choix($destination,6);print(">Retour au domicile dans le cadre d'une HAD</option> ");
		print("<option value=\"7\" ");choix($destination,7);print(">Dans une structure d'hébergement médico-sociale</option> ");
	}
	print("</select></td>");
print("</tr>");

$orientation = $_REQUEST['orientation'];
print("<tr align=\"left\" bgcolor=\"#FFA500\">");
	print("<td>Orientation</td>");
	print("<td><select name=\"orientation\" size=\"1\" onChange = javascript:document.RPU.submit();>");
	print("<option value=\"0\" ");choix($destination,0);print(">Sans objet</option> ");
	if($mode_sortie==MUTATION || $mode_sortie==TRANSFERT)
	{
		print("<option value=\"HDT\" ");choix($orientation,"HDT");print(">Hospitalisation sur demande d'un tiers</option> ");
		print("<option value=\"HO\" ");choix($orientation,"HO");print(">Hospitalisation d'office</option> ");
		print("<option value=\"SC\" ");choix($orientation,"SC");print(">Hospitalisation dans une unité de surveillance continue</option> ");
		print("<option value=\"SI\" ");choix($orientation,"SI");print(">Hospitalisation dans une unité de Soins Intensifs</option>");
		print("<option value=\"REA\" ");choix($orientation,"REA");print(">Hospitalisation dans une unité de Réanimation</option>");
	}
	elseif($mode_sortie==DOMICILE)
	{
		print("<option value=\"FUGUE\" ");choix($orientation,"FUGUE");print(">Fugue</option> ");
		print("<option value=\"SCAM\" ");choix($orientation,"SCAM");print(">Sortie contre avis médical</option> ");
		print("<option value=\"PSA\" ");choix($orientation,"PSA");print(">Sortie contre avis médical</option> ");
		print("<option value=\"REO\" ");choix($orientation,"REO");print(">Réorientation directe sans soins</option> ");
	}
	print("</select></td>");
print("</tr>");
print("</table>");
print("</FIELDSET>");
print("</div>");

print("<a href=\"lire_ccam.php\">Lire CCAM</a>");

print("</form>");
?>