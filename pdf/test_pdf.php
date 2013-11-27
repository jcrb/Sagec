<?php
/**
*	test_pdf.php
*/
include_once("fpdf.php");
include_once("PDF_badge.php");

$backPathToRoot = "../";
require($backPathToRoot."date.php");
include_once($backPathToRoot."dbConnection.php");

function setColor($pdf,$color)
{
	switch($color)
	{
		case rouge;$pdf->SetDrawColor('255','0','0');break;
		case vert;$pdf->SetDrawColor('51','204','0');break;
		case jaune;$pdf->SetDrawColor('255','255','0');break;
		case ocre;$pdf->SetDrawColor('255','204','0');break;
		case orange;$pdf->SetDrawColor('255','153','0');break;
		case bleu;$pdf->SetDrawColor('51','51','255');break;
		case navy;$pdf->SetDrawColor('204','204','255');break;
		case gris;$pdf->SetDrawColor('192','192','192');break;
		case blanc;$pdf->SetDrawColor('0','0','0');break;
		default:$pdf->SetDrawColor('255','255','255');
	}
}

function imprime_badge($nom,$prenom,$fonction,$code,$hopital,$service,$couleur)
{

}

$nom = "BARTIER";
$prenom = "Jean-Claude";
$fonction = "AMBULANCIER";
$code = 3008500000015;
$hopital = "Hôpitaux Universitaires de Strasbourg";
$service = "SAMU 67";
$color = "ocre";

$epaisseur_trait = 2; //mm
$couleur_trait = $rouge;
$margeG = 10;
$margeS = 10;
$logoHus_Width = 20;
$logoHus_Heigth = 25;
$hopital_width = 40;
$badge_width = 80;
$badge_heigth = 50;
 /*
$pdf = new fpdf();
$pdf->AddPage();
//$pdf->SetFont("Arial","B",16);
//$pdf->Text(40,10,"SAGEC 67 - Compte-rendu de l'évènement courant");
$pdf->SetFont("Arial","",12);
//$pdf->Cell(190,10,"SAGEC 67 - Compte-rendu de l'évènement courant",1,1,"C");
//$pdf->Cell(190,10,"Date: ".$date = uDateTime2MySql(time()),0,1,"L");

setColor($pdf,$color);
$pdf->SetLineWidth($epaisseur_trait);
$pdf->Rect($margeG,$margeS,$badge_width,$badge_heigth,"",1);
$pdf->SetXY($margeG,$margeS+1);
$pdf->Image("../images/logohus.png",$margeG+1,$margeS+1,$logoHus_Width,$logoHus_Heigth);
$pdf->Cell($logoHus_Width,3,'',0,0);
$pdf->SetFillColor(255,255,255);
$pdf->MultiCell($hopital_width,5,$hopital,0,"C",true);
$pdf->Image("../photos/jcb.jpeg",$margeG+$logoHus_Width+$hopital_width-$epaisseur_trait/2,$margeS+1,20,25);
$pdf->Cell(20);
$pdf->SetTextColor(51,51,255);
$pdf->Cell(40,10,$service,0,0,"C");
$pdf->SetXY($margeG + 5,$margeS + $logoHus_Heigth);
$pdf->Cell($margeS + 30,10,$nom." ".$prenom,0,0,"L");
$pdf->SetXY($margeG + 5,$margeS + $logoHus_Heigth +10);
$pdf->Cell($margeG + 30,10,$code,0,0,"L");
$pdf->Image("../cb.png",49,$margeS + $logoHus_Heigth +7.5,40,16);

$pdf->Output();
*/
$badge = new PDF_badge();
$badge->AddPage();
$badge->SetFont("Arial","",12);
$badge->margeS = 10;
$color = "rouge";
$distance_interbadge = 5;
$nbBadges = 12;
$nbPages = ceil($nbBadges/10);
$nbBadgesFaits = 0;
$stop = false;
/*
for($k = 0; $k< $nbPages; $k++)
{
	$badge->margeS = 10;
	$badge->margeG = 10;
	
	for($i=0;$i<2;$i++)
	{
		$badge->margeS = 10;
		for($j = 0; $j<5;$j++)
		{
			$badge->imprime_badge($nom,$prenom,$fonction,$code,$hopital,$service,$color);
			$nbBadgesFaits++;
			if($nbBadgesFaits == $nbBadges)
			{
				$stop = true;
				break;
			}
			$badge->margeS += $badge_heigth + $distance_interbadge;
		}
		if($stop) break;
		$badge->margeG += $badge_width +10;
	}
	if($stop) break;
	$badge->AddPage();
}
*/
$badge->Output();
?>