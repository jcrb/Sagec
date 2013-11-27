<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
// This file is part of SAGEC67 Copyright (C) 2003-2005 (Jean-Claude Bartier).
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
//----------------------------------------- SAGEC --------------------------------
//
//	programme: 			med_carto_generale.php
//	date de création: 	11/12/2005
//	auteur:				jcb
//	description:		Dessine le territoire couvert tous les médecins
//	version:			1.0
//	maj le:				11/12/2005
//
//--------------------------------------------------------------------------------
//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require "../classe_dessin.php";
require "../carto_utilitaires.php";
require("../pma_connect.php");
require("../pma_connexion.php");
require("../utilitaires_dessin.php");
require("../pma_requete.php");
//========================================== Début ==============================================================
?>
<script>
var fenetreContact
function cree_fenetreContact(id)
{
	//args="fenetreContact","width=300, height=20, location=no,toolbar=no,scrollbars=yes,resizable=yes,directories=no,status=no";
	url="intervenant_info.php?personne_id="+id;
	fenetreContact = window.open(url, "fenetreContact","width=300, height=20, location=no,toolbar=no,scrollbars=yes,resizable=yes,directories=no,status=no");
}
</script>
<?php
//
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
//
function is_garde($commune)
{
	global $connexion;
	$requete = "SELECT * FROM mg67_territoire WHERE com_ID='$commune'";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	return $rub['med_ID'];
}
// zone réservée au dessin:
	$image_width = 660;//
	$image_heigth = 800;//
// lectures des données
$requete = "SELECT com_ID,com_INSEE,com_nom,L2x,L2y
			FROM commune
			WHERE commune.com_INSEE BETWEEN '67000' AND '67900'
			";
$resultat = ExecRequete($requete,$connexion);
while($rub = mysql_fetch_array($resultat))
{
	$file = "../carto/contour_communes/".$rub['com_INSEE'].".txt";
	if (file_exists($file))
	{
		$ville[$rub['com_INSEE']]['nom']=$rub['com_nom'];
		$ville[$rub['com_INSEE']]['x']=$rub['L2x'];
		$ville[$rub['com_INSEE']]['y']=$rub['L2y'];
		$ville[$rub['com_INSEE']]['com_ID']=$rub['com_ID'];
		//print("commune ".$rub['com_nom']." ".$file."<br>");
		// lire les fichiers sources correspondants. Au retour le tableau zone contient autant de sous tableaux
		// qu'il y a de départements à dessiner. Le 1er indice correspond au n° du tableau (ex.0 pour le 67), le 2ème indice
		// correspond à la suite des points x,y
		fichierTXT2array(ouvre_fichier($file),$commune[$rub['com_INSEE']]);
	}
}

//correction de proportionalité. $U_haut,$U_bas,$U_droit ,$U_gauche sont des variables globales auto. crés par fichierTXT2array
$univers_h = $U_haut - $U_bas;
$univers_w = $U_droit - $U_gauche;
if($univers_w > $univers_h)
	$image_heigth = $univers_h*$image_width/$univers_w;
else
	$image_width = $image_heigth*$univers_w/$univers_h;
//print($image_heigth."  ".$image_width."<br>");
//
//Initialisation de la zone de dessin
$d = new CDessin($image_heigth,$image_width,$U_haut,$U_gauche,$U_bas,$U_droit);
$peachpuff = imagecolorAllocate($d->pic,0xFF,0xda,0xB9);
$moccasin = imagecolorAllocate($d->pic,0xFF,0xE4,0xB5);
$bleu = imagecolorAllocate($d->pic,0x00,0x00,0xff);
$rouge = imagecolorAllocate($d->pic,0xff,0x00,0x00);
$blanc = imagecolorAllocate($d->pic,0xff,0xff,0xff);
// Dessin des départements et des régions
while($elem = each($commune))
{
	$dp = $d->polygoneU2E($commune[$elem['key']]);// $elem['key'] contient com_INSEE
	if(is_garde($ville[$elem['key']]['com_ID']) != 0)
	{
		$couleur = $rouge;
		$zone[]=$dp;
	}
	else
		$couleur = $moccasin;
	$d->dessine_polygone($dp,$couleur,"");
	$rayon = 5;
	//$d->cercle($ville[$elem['key']]['x'],$ville[$elem['key']]['y']/10,$rayon,$bleu, "",$ville[$elem['key']]['nom'],"1");
	$d->cercle($ville[$elem['key']]['x'],$ville[$elem['key']]['y']/10,$rayon,$bleu, "","","1");
}

//$d->affiche_image("Cartographie SAMU 67 - ".$_GET['titre']);//
$d->enregistre_image($titre="pic.png");
print("<MAP NAME=\"garde\">");
for($i=0;$i<count($zone);$i++)
{
	$zone[$i][]=$zone[$i][0];
	$zone[$i][]=$zone[$i][1];
	//print_r($zone[$i]);print("<br><br>");implode(",", $array)
	$zz = implode(",",$zone[$i]);
	print("<AREA ALT=\"Commune\" SHAPE=\"poly\" COORDS=\"$zz\" Href=\"truc.php\" OnMouseOver=javascript:cree_fenetreContact($id) OnMouseOut=javascript:fenetreContact.close()>");
}
print("</MAP>");
print("<IMG SRC=\"pic.png\" NAME=\"logo-html\" ALT=\"cart des disponibilités\" BORDER=1 USEMAP=\"#garde\">");
?>