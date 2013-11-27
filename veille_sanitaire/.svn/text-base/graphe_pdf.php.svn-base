<?php
//graphe_pdf.php
require('../pdf/fpdf.php');

class PDF extends FPDF
{
//En-tête
function Header()
{
    //Logo
    $this->Image('../images/Logo_SAGEC3.png',10,8,33);
    //Police Arial gras 15
    $this->SetFont('Arial','B',15);
    //Décalage à droite
    $this->Cell(80);
    //Titre
    $this->Cell(60,10,'Activité du SAMU 67',1,0,'C');
    	$this->RotatedImage('circle.png',85,60,40,16,45);
	$this->RotatedText(100,60,'Demo !',45);
	//Affiche le filigrane
    $this->SetFont('Arial','B',50);
    $this->SetTextColor(255,192,203);
    $this->RotatedText(35,190,'S A G E C  6 7  d é m o',45);
    //Saut de ligne
    $this->Ln(20);
}

//Pied de page
function Footer()
{
    //Positionnement à 1,5 cm du bas
    $this->SetY(-15);
    //Police Arial italique 8
    $this->SetFont('Arial','I',8);
    //Numéro de page
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

//Instanciation de la classe dérivée
$pdf=new PDF();
$pdf->SetAuthor('JCB');
$pdf->SetTitle('Activité SAMU67');
$pdf->AliasNbPages();
$pdf->AddPage('L');
$pdf->SetFont('Times','',12);
$pdf->Image('pic.png',10,30,200);
$pdf->Ln(120);
$pdf->AddPage('P');
for($i=1;$i<=40;$i++)
    $pdf->Cell(50,10,'Impression de la ligne numéro '.$i,0,2);
$pdf->Output();
?>
