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
//---------------------------------------------------------------------------------------------------------
//
//
//	programme: 			passeport.php
//
//	date de création: 	13/03/2004										
//	auteur:				jcb								
//	description:		Crée un gadge pour un utilisateur		 				
//	version:			1.0									
//	maj le:				13/03/2004								
//														
//---------------------------------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(!$_SESSION['auto_sagec'])header("Location:logout.php");
$langue = $_SESSION['langue'];
require("pma_connect.php");
require("pma_connexion.php");
require("pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);


/**
*	dessin du badge
*/
function badge($personne_ID)
{
	global $connexion;

$requete = 	"SELECT Pers_Nom,Pers_Prenom,org_nom,perso_cat_nom,photo, personnel.perso_cat_ID, service_nom
		 FROM personnel,perso_cat, service,organisme
		 WHERE Pers_ID = '$personne_ID'
		 AND service.service_ID = personnel.service_ID
		 AND organisme.org_ID = personnel.org_ID
		 AND personnel.perso_cat_ID = perso_cat.perso_cat_ID
		 ";
$resultat = ExecRequete($requete,$connexion);
$rub=mysql_fetch_array($resultat);
//print($requete."<BR>");

$pays = "30";
$organisme = substr("000".$rub[org_ID],-3);
$service = "000";
$individu = substr("0000".$_GET['personnelID'],-4);
$code = $pays.$organisme.$service.$individu;
for($i=strlen($code)-1;$i >0; $i-=2)
{
	(int)$a = 3 * (int)$code[$i];
	(int)$b = (int)$code[$i-1];
	$mot = (int)$mot + (int)$a + (int)$b;
	//print($mot."<BR>");
}
$clef = 0;
while(($mot+$clef) % 10 != 0)
{
	$clef++;
}
$code = $code.$clef;

// DIMENSIONS EN PIXELS
/*
* 1 cm = 80 px
*/
$ht = "202px";
$l = "320px";
// couleur du cadre
switch($rub[perso_cat_ID])
{
	case 1:case 10: case 11:$color = "#FF3333";break;// medecin
	case 2:case 3: case 4: case 12:$color = "#66FF33";break;// ide
	case 5:$color = "#66FF33";break;// ambulanciers
	case 6:$color = "#FF66FF";break;// parm  
	case 7:$color = "#FFCC66";break;// secretaire
	case 8:$color = "#FFFF66";break;// logisticien
	default:$color = "#FFFFFF";
}

	// badge 
	print("<TABLE width=\"$l\" height=\"$ht\" border=\"8\" align=\"center\" cellspacing=\"0\" bordercolor=\"$color\" >");
		print("<TR align=\"center\">");
			print("<TD>");

				print("<TABLE width=\"$l\" height=\"$ht\" border=\"0\" align=\"center\" cellspacing=\"0\" background=\"images/logo1.png\">");
					print("<TR align=\"center\" class=\"time\">");
						print("<TD rowspan=\"2\">");
							//print("<IMG SRC=\"code_barre_fabrique.php?ean=$code\">");
							print("<IMG height=\"90\" width=\"80\" SRC=\"images/logohus.png\" valign=\"top\" align=\"left\">");
						print("</TD>");
						print("<TD>".$rub[org_nom]."</TD>");//Hôpitaux Universitaires de Strasbourg
						print("<TD rowspan=\"2\">");
							if($rub['photo'])
							{
								$photo = $rub['photo'];
								list($width, $height, $type, $attr) = getimagesize($photo);
								$h = 120;
								$w = $h*$width/$height;
								print("<IMG height=\"$h\" width=\"$w\" SRC=\"$photo\">");
							}
							else
							{
								$photo = "images/profil.jpeg";
								list($width, $height, $type, $attr) = getimagesize($photo);
								$h = 120;
								$w = $h*$width/$height;
								print("<IMG height=\"$h\" width=\"$w\" SRC=\"$photo\">");
							}
						print("</TD>");
					print("</tr>");
					print("<TR align=\"center\">");
						print("<TD align=\"center\"  class=\"time_bb\">".$rub[service_nom]."</TD>");
					print("</TR>");
					print("<TR class=\"time\">");
						print("<TD>");print($rub[Pers_Nom]);print("</TD>");
						print("<TD align=\"center\">");print($rub[Pers_Prenom]);print("</TD>");
						print("<TD align=\"center\">");print($rub[perso_cat_nom]);print("</TD>");
					print("</TR>");
					print("<TR>");
						//print("<TD>");print($rub[perso_cat_nom]);print("</TD>");
					print("</TR>");
					print("<TR class=\"time\">");
						print("<TD>");print("N° ");print("</TD>");
						print("<TD>");print($code);print("</TD>");
						print("<TD><IMG SRC=\"code_barre_fabrique.php?ean=$code\"></TD>");
					print("</TR>");
				print("</TABLE>");
			print("</TD>");
		print("</TR>");
	print("</TABLE>");
}

/**
*	main
*/

print("<head>");
print("<title> Gestion des organismes </title>");
print("<LINK REL=stylesheet HREF=\"pma.css\" TYPE =\"text/css\">");
print("</head>");

print("<body>");

print("<TABLE>");
	print("<TR>");
		print("<TD>");
			badge($_GET[personnelID]);
		print("</TD>");
		print("<TD>");
			badge($_GET[personnelID]);
		print("</TD>");
	print("</TR>");
print("</TABLE>");
print("</body>");
?>
