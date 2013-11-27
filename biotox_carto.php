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
//																							   //
//	programme: 			biotox_carto.php													   //
//	date de création: 	31/01/2004															   //
//	auteur:				jcb																	   //
//	description:		Création de cartes
//						ATTENTION: CE PROGRAMME NE DOIT COMPORTER AUCUNE SORTIE D'ECRAN
//						FAIT APPEL A HEADER									 				   //
//	version:			1.0																	   //
//	maj le:				31/01/2004										                       //
//																							   //  
//---------------------------------------------------------------------------------------------//
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require "classe_dessin.php";
require "carto_utilitaires.php";
require("pma_connect.php");
require("pma_connexion.php");
require("utilitaires_dessin.php");
require($backPathtoRoot."login/init_security.php");

// La variable $type_materiel est transmise par le programme appelant;
$image_width = 660;
$image_heigth = 800;

// selectionner tous les départements de la zone est = 1
$zone_defense = 1;
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$requete = "SELECT departement_ID, departement_nom, departement.region_ID
			FROM  region, departement
			WHERE departement.region_ID = region.region_ID
			AND region.zone_ID = '$zone_defense'";
//print($requete);
$resultat = mysql_query($requete,$connexion);
$nb_departement=0;
// On crée un tableau de 18 tableaux appelé zone. 
// Chacun de ses 18 tableaux stockera les coordonnées des points
// servant à dessiner un département.
$zone = array(array());
// le tableau $region associe un département et une région
$region = array();
// associe à un tableau, le n° du département
$departement = array();
// lecture des fichiers de coordonnées. Les fichiers doivent se trouver dans le répertoire carto
while($rub=mysql_fetch_array($resultat))
{
	$file = "carto/d".$rub[0].".txt";
	fichierNUM2array(ouvre_fichier($file),$zone[$nb_departement]);
	$region[$nb_departement]=$rub[region_ID];
	$departement[$nb_departement]=$rub[departement_ID];
	$nb_departement++;
}

//Initialisation de la zone de dessin
$d = new CDessin($image_heigth,$image_width,$U_haut,$U_gauche,$U_bas,$U_droit);
// ajpout d'une palette de couleurs
$vert=ImageColorAllocate($d->pic,0,255,0);
$rouge=ImageColorAllocate($d->pic,255,0,0);
$black = imagecolorAllocate($d->pic,0,0,0);
$palegoldenrod = imagecolorAllocate($d->pic,0xee,0xe8,0xaa); 
$lavande = imagecolorAllocate($d->pic,0xE6,0xE6,0xFA);
$khaki = imagecolorAllocate($d->pic,0xF0,0xE6,0x8C);       
$lavenderblush = imagecolorAllocate($d->pic,0xFF,0xF0,0xF5);         
$mistyrose = imagecolorAllocate($d->pic,0xFF,0xE4,0xE1);       
$moccasin = imagecolorAllocate($d->pic,0xFF,0xE4,0xB5);
$peachpuff = imagecolorAllocate($d->pic,0xFF,0xda,0xB9);  

// Dessin des départements et des régions
$p1=array();
$p2=array();
for($i=0;$i < $nb_departement; $i++)
{
	// Un département en coord réelles est transformé en coord.écran
	$dp = $d->polygoneU2E($zone[$i]);
	switch($region[$i])// les départements appartenant à la même région sont colorés de la même façon
	{
		case 42: $couleur = $peachpuff; break; 
		case 41: $couleur = $lavande; break;
		case 43: $couleur = $lavenderblush; break;
		case 26: $couleur = $palegoldenrod; break;
		case 21: $couleur = $moccasin; break;//$mistyrose
		default:$couleur = $palegoldenrod;
	}
	$d->dessine_polygone($dp,$couleur,"");
	// on mémorise à part ces départements pour tester la fusion de polygones
	if($departement[$i]==67)$p1 = $dp;
	if($departement[$i]==68)$p2 = $dp;
	if($departement[$i]==88)$p3 = $dp;
}
// essai de fusion de polygones
/*
$p4 = array();
$p4 = fusionne2polygones($p1,$p2);
$p5 = fusionne2polygones($p4,$p3);
$d->dessine_polygone($p5,$palegoldenrod,"");
*/


// Affichage des villes siège de SAMU 
$rayon = 12;	//FROM ville WHERE zone_ID='1'
$requete = "SELECT ville_nom,ville_lambertX,ville_lambertY
		FROM ville,adresse,hopital
		WHERE ville.ville_ID = adresse.ville_ID
		AND adresse.ad_ID = hopital.adresse_ID
		AND Hop_Samu = 'o' 
		AND ville.zone_ID = '1'
		";
$resultat = mysql_query($requete,$connexion);
while($rub=mysql_fetch_array($resultat))
{
	$d->cercle($rub[1]/1000,$rub[2]/1000,$rayon,$vert, "",Security::db2str($rub[ville_nom]),"1");
	//print($rub[1].'  '.$rub[2].'  '.$rub[0].'<br>');
}


// Affichage du nombre de paires de gants GNG par ville
$requete = "SELECT SUM(dotation_qte), dotation.ville_ID,ville_nom,ville_lambertX,ville_lambertY
			FROM dotation, ville
			WHERE dotation.ville_ID = ville.ville_ID
			AND ville.zone_ID ='1'
			AND dotation.materiel_ID = '$_GET[type_materiel]'
			GROUP BY dotation.ville_ID
			";//AND dotation.materiel_ID = '$type_materiel'
			//print($requete."<BR>");

$resultat = mysql_query($requete,$connexion);

while($rub=mysql_fetch_array($resultat))
{
	$d->cercle($rub[3]/1000,$rub[4]/1000,$rayon,$rouge, "",Security::db2str($rub[2],"1"));
	$d->cercle($rub[3]/1000,$rub[4]/1000,$rayon,$rouge, "",Security::db2str($rub[2],""));
	$dx=5;
	$dy=-20;
	$d->ecrire($rub[0],$rub[3]/1000,$rub[4]/1000,$dx,$dy,$rouge);
	//print($rub[0]." - ".$rub[2]." - ".$rub[3]."<BR>");
}
/*
*/
// Affichage de l'image
$d->affiche_image();

?>
