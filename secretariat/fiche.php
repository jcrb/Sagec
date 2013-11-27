<?php
/**
  *	fiche.php
  */
$path = "../";
include_once($path."pdf/fpdf.php");
//getting new instance
$pdf=new FPDF();
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->Cell(40,10,'Fiche Personnelle');
$pdf->Output()
?>
