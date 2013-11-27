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

 if (!isset ($FichierHTML))
 {
   $FichierHTML = 1;

   // Fonctions produisant des conteneurs HTML

   function Ancre ($url, $libelle, $classe=-1)
   {
    $optionClasse = "";
    if ($classe != -1) $optionClasse = " CLASS='$classe'";
    return "<A HREF='$url'" .  "$optionClasse>$libelle</A>\n";
   }

   function Image ($url, $largeur=-1, $hauteur=-1, $bordure=0)
   {
    $attrLargeur = "";
    $attrHauteur = "";
    if ($largeur != -1) $attrLargeur = " WIDTH  = '$largeur' ";
    if ($hauteur != -1) $attrHauteur = " HEIGHT = '$hauteur' ";

    return "<IMG SRC='$url'" .  $attrLargeur
            . $attrHauteur . " BORDER='$bordure'>\n";
   }

   // crée une balise qui pointe vers une page
   function Url($adresse,$intitule)
   {
   	echo "<a href = \"$adresse\"> $intitule</a><br>";
   }
 }

/**
* entête pour Sagec
* @data $titre, facultatif, titre principal de la page
* @data $place, alignement, center par défaut
* @data $path, chemin relatif ./ ou ./../ etc.
*/
function entete_sagec($titre="&nbsp;",$place="center",$path="")
{
	print("<table width=\"100%\" border=\"1\" bordercolor=\"#660066\">");//http://apharportable2/projet1/SAGEC67_v3
	print("<tr>");
		$adresse = $path."images/SAGEC_Alsace.png";//print($adresse);
		print("<td width=\"21%\"><div align=\"center\"><img src=\"$adresse\" width=\"156\"height=\"79\"></div></td>");
		print("<td width=\"79%\"><div align=\"$place\"><H2>$titre</H2></td>");
	print("</tr>");
	print("</table>");
}
/**
* entête pour Sagec
* @data $titre, facultatif, titre principal de la page
* @data $place, alignement, center par défaut
* @data $menu, phrase contenant les items du sous menu horizontal
* @data $path, chemin relatif ./ ou ./../ etc.
*/
function entete_sagec2($titre="&nbsp;",$place="center",$menu="",$path="")
{
	print("<table width=\"100%\" border=\"1\" bordercolor=\"#660066\" cellspacing=\"0\">");
	print("<tr>");
		$adresse = $path."images/SAGEC_Alsace.png";//print($adresse);
		print("<td width=\"21%\" rowspan=\"2\"><div align=\"center\"><img src=\"$adresse\" width=\"156\" height=\"79\" ></div></td>");
		print("<td width=\"79%\"><div align=\"$place\"><H2>$titre</H2></td>");
	print("</tr>");

	print("<tr>");
		print("<TD bgcolor=\"#cccccc\"><div align=\"center\" height=\"15\">$menu</div></TD>");
	print("</tr>");
	print("</table>");
}

/**
* entête pour Sagec
* @data $titre, facultatif, titre principal de la page
* @data $place, alignement, center par défaut
* @data $menu, phrase contenant les items du sous menu horizontal
* @data $path, chemin relatif ./ ou ./../ etc.
*/
function entete_sagec_css($titre="&nbsp;",$place="center",$menu="",$path="")
{
	$rowspan = "";
	if (isset ($menu) && $menu != "")
		$rowspan = "rowspan=2";
	print("<table class='entete_table' >");
	print("<tr>");
		$adresse = $path."images/SAGEC_Alsace.png";//print($adresse);
		print("<td class='entete_logo' $rowspan><img src='$adresse' width='156' height='79'></td>");
		print("<td class='entete_titre'><div align='$place'><H2>&nbsp;$titre</H2></td>");
	print("</tr>");

	if (isset ($menu) && $menu != ""){
		print("<tr>");
			print("<TD class='entete_menu'><div align=\"center\">$menu</div></TD>");
		print("</tr>");
	}
	print("</table>");
}
?>
