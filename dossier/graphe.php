<?php
/**
*	graphe.php
*	 
*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../";
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."date.php");
require $backPathToRoot."classe_dessin.php";
$victime = $_REQUEST['value'];

// zone r�serv�e au dessin:
$image_width = 900;//660 * 2;//$_GET[zoom];//660 440
$image_heigth = 400;//800 * 2;//$_GET[zoom];//800 553
$_15mn = 900;
$_60mn = 3600;
$tmax = 0;	// valeur volontairement invers�es 
$tmin = strtotime("now");

// r�cup�ration des donn�es patients
$requete = "SELECT date,exam_ID,resultat FROM dm_constantes2 WHERE victime_ID = '$victime' ORDER BY date";
$resultat = ExecRequete($requete,$connexion);
/*
	Les donn�es sont charg�es sous la forme de 2 tablaux � double indices:
	$t[n�examen][n�d'ordre] = heure de r�alisation avec
		- n�examen = 1 pour la fc, 2=PAS, etc...
		- n�d'ordre = 0,1,2....,n
	$r[n�examen][n�d'ordre] = valeur du r�sultat de l'examen
	ex:
	$t[fc][0] = 10:30	$r[fc][0] = 100
	$t[fc][1] = 10:40	$r[fc][1] = 80
	$t[fc][2] = 10:50	$r[fc][2] = 85
*/
while($rub = mysql_fetch_array($resultat))
{
	if($tmin > $rub['date'])$tmin = $rub['date'];
	if($tmax < $rub['date'])$tmax = $rub['date'];
	$t[$rub['exam_ID']][]=$rub['date'];//date
	$r[$rub['exam_ID']][]=$rub['resultat'];//resultat
	//$h = date("Y-m-d H:i:s",$rub['date']);
	//print($rub['exam_ID']." ".$h." ".$rub['resultat']."<br>");
}

// ajustement des valeurs
$tx = $tmin;// $tx = heure de la 1�re graduation pleine
while($tx%$_15mn!=0)$tx++;
if($tmax-$tx < $_60mn)
	$tmax = $tx+$_60mn+60;

//Initialisation de la zone de dessin pour la fc et PA
$U_haut = 250;
$U_bas = 0;
$U_gauche = $tmin;
$U_droit = $tmax;
$graduation_principale = 50; // trait �pais tous les 50 mmhg 
$graduation_secondaire = 10;
//
$dfc = new CDessin($image_heigth,$image_width,$U_haut,$U_gauche,$U_bas,$U_droit);
$rouge = imagecolorAllocate($dfc->pic,0xff,0x00,0x00);
$bleu = imagecolorAllocate($dfc->pic,0x00,0x00,0xff);
$vert = imagecolorAllocate($dfc->pic,0x00,0xff,0x00);
$vert_clair = imagecolorAllocate($dfc->pic,0x99,0xff,0x66);
$jaune = imagecolorAllocate($dfc->pic,0xff,0xff,0x00);
$orange = imagecolorAllocate($dfc->pic,0xff,0x66,0x00);
$bleuclair = imagecolorAllocate($dfc->pic,0xcc,0xcc,0xff);
//imagecolortransparent($dfc->pic, $orange);
$bleu_transparent = imagecolorallocatealpha($dfc->pic,0xcc,0xcc,0xff,60);
$dfc->setMarges(20,20,40,10);

//=============================================  grille  ==================================
$dfc->couleur_courante = $vert_clair;
// lignes horizontales trac�es toutes les 10 points
for($i = 0;$i<$U_haut;$i+=$graduation_secondaire)
{
	if($i % $graduation_principale ==0)
	{
		$dfc->couleur_courante = $vert;
		$dfc->ecrire($i,$tmin,$i,-30,5,$vert,10);
	}
	else
	{
		$dfc->couleur_courante = $vert_clair;
	}
	$dfc->line($tmin,$i,$tmax,$i);
}
// lignes verticales trac�es toutes les heures
$t0 = date("H",$tmin)+1;
$tdepart = strtotime($t0);
//$dfc->$couleur_courante = $vert;

for($i=$tx;$i<$tmax;$i += $_15mn)
{
	if($i % $_60mn ==0)
	{
		$dfc->couleur_courante = $vert;
		$dfc->ecrire($t0."h",$i,$U_bas,-6,12,$vert,10);
		$t0++;
		if($t0>23)$t0=0;
	}
	else
	{
		$dfc->couleur_courante = $vert_clair;
	}
	$dfc->line($i,$U_bas,$i,$U_haut);
}
//====================================  affichage des examens  ========================================
// Pression art�rielle
$p1 = 2; //PAS
$p2 = 3; //PAD
$rayon = 8;
$dfc->couleur_courante = $bleu;
for($i=0;$i<count($t[$p1]);$i++)
{
	$dfc->va_en($t[$p1][$i],$r[$p1][$i]);
	$dfc->trace_vers($t[$p1][$i],$r[$p2][$i]);
	$dfc->cercle($t[$p1][$i],$r[$p1][$i],$rayon,$bleu, "","","1");
	$dfc->cercle($t[$p1][$i],$r[$p2][$i],$rayon,$bleu, "","","1");
		//$dfc->cercle($t[$i],$pad[$i],$rayon,$bleu, "","","1");
		//$dfc->cercle($t[$i],$pas[$i],$rayon,$bleu, "","","1");
		/* dessin du polygone tensionnel */
		if($i>0)
		{
			$dfc->line($t[$p1][$i-1],$r[$p1][$i-1],$t[$p1][$i],$r[$p1][$i]);
			$dfc->line($t[$p2][$i-1],$r[$p2][$i-1],$t[$p2][$i],$r[$p2][$i]);
			//
			$poly=array($t[$p1][$i-1],$r[$p1][$i-1],
			$t[$p1][$i],$r[$p1][$i],
			$t[$p2][$i],$r[$p2][$i],
			$t[$p2][$i-1],$r[$p2][$i-1]
			);
			//print_r($poly);
			$pl2 = $dfc->polygoneU2E($poly);
			$dfc->dessine_polygone($pl2, $bleu_transparent, $bleu);
		}
}
// fr�quence cardiaque
$p1 = 1;
$rayon = 8;
for($i=0;$i<count($t[$p1]);$i++)
{
	$dfc->cercle($t[$p1][$i],$r[$p1][$i],$rayon,$rouge, "","","1");
	if($i>0)
	{
		$dfc->couleur_courante = $rouge;
		$dfc->line($t[$p1][$i-1],$r[$p1][$i-1],$t[$p1][$i],$r[$p1][$i]);
	}
}
//
// EtCO2
$dfc->couleur_courante = $bleu;
$p1 = 6; //etco2
for($i=0;$i<count($t[$p1]);$i++)
{
	$dfc->cercle($t[$p1][$i],$r[$p1][$i],$rayon,$orange, "","","1");
	if($i>0)
	{
		$dfc->couleur_courante = $orange;
		$dfc->line($t[$p1][$i-1],$r[$p1][$i-1],$t[$p1][$i],$r[$p1][$i]);
	}
}
// SaO2
$p1 = 5; //SaO2
for($i=0;$i<count($t[$p1]);$i++)
{
	$dfc->cercle($t[$p1][$i],$r[$p1][$i],$rayon,$jaune, "","","1");
	if($i>0)
	{
		$dfc->couleur_courante = $jaune;
		$dfc->line($t[$p1][$i-1],$r[$p1][$i-1],$t[$p1][$i],$r[$p1][$i]);
	}
}
//=============================================================================================================
// affichage du dessin
$dfc->affiche_image("Patient - ".$victime."  (".$tx.")  ".uDatetime2French($tmin)."/".uDatetime2French($tmax));
?>