<?php

//require_once('../pdf/fpdf.php');

class pdfEAN13 extends FPDF
{
	function  pdfEAN13($orientation)
	{
		parent::FPDF($orientation, 'mm', 'A4');
	}
}
?> 