<?php
/**
*	classe badge: PDF_badge.php
*/
$backtoPath="";
require_once($backtoPath.'fpdf.php');


class PDF_badge extends FPDF {

    // Private properties

    var $_X_Space;                // espace horizontal entre 2 badges
    var $_Y_Space;                // espace vertical entre 2 badges
    var $_X_Number;                // nombre de badges horizontaux
    var $_Y_Number;                // nombre de badges verticaux
    var $_Line_Height;            // hauteur d'une ligne
    var $_Padding;                // Padding
    var $_Metric_Doc;            // métriqye du document
    var $_COUNTX;                // position X courante
    var $_COUNTY;                // position Y courante
    
	var $epaisseur_trait = 2; 		//mm
	var $couleur_trait;
	var $margeG = 10;					// marge de gauche
	var $margeS = 10;
	var $logoHus_Width = 20;
	var $logoHus_Heigth = 25;
	var $hopital_width = 40;
	var $badge_width = 80;			// largeur d'un badge
	var $badge_heigth = 50;			// hauteur d'un badge
    
    /** constructeur */
	function PDF_badge()
	{
   	parent::FPDF('P', 'mm', 'A4');//FPDF($orientation='P', $unit='mm', $format='A4')
	}
	
	function GetCheckDigit($barcode)
	{
    //Compute the check digit
    $sum=0;
    for($i=1;$i<=11;$i+=2)
        $sum+=3*$barcode{$i};
    for($i=0;$i<=10;$i+=2)
        $sum+=$barcode{$i};
    $r=$sum%10;
    if($r>0)
        $r=10-$r;
    return $r;
	}

	function TestCheckDigit($barcode)
	{
    //Test validity of check digit
    $sum=0;
    for($i=1;$i<=11;$i+=2)
        $sum+=3*$barcode{$i};
    for($i=0;$i<=10;$i+=2)
        $sum+=$barcode{$i};
    return ($sum+$barcode{12})%10==0;
	}
	
	function EAN13($x, $y, $barcode, $h=16, $w=0.35)
	{
    $this->Barcode($x, $y, $barcode, $h, $w, 13);
	}

	function Barcode($x, $y, $barcode, $h, $w, $len)
	{
    //Padding
    $barcode=str_pad($barcode, $len-1, '0', STR_PAD_LEFT);
    if($len==12)
        $barcode='0'.$barcode;
    //Add or control the check digit
    if(strlen($barcode)==12)
        $barcode.=$this->GetCheckDigit($barcode);
    elseif(!$this->TestCheckDigit($barcode))
        $this->Error('Incorrect check digit');
    //Convert digits to bars
    $codes=array(
        'A'=>array(
            '0'=>'0001101', '1'=>'0011001', '2'=>'0010011', '3'=>'0111101', '4'=>'0100011',
            '5'=>'0110001', '6'=>'0101111', '7'=>'0111011', '8'=>'0110111', '9'=>'0001011'),
        'B'=>array(
            '0'=>'0100111', '1'=>'0110011', '2'=>'0011011', '3'=>'0100001', '4'=>'0011101',
            '5'=>'0111001', '6'=>'0000101', '7'=>'0010001', '8'=>'0001001', '9'=>'0010111'),
        'C'=>array(
            '0'=>'1110010', '1'=>'1100110', '2'=>'1101100', '3'=>'1000010', '4'=>'1011100',
            '5'=>'1001110', '6'=>'1010000', '7'=>'1000100', '8'=>'1001000', '9'=>'1110100')
        );
    $parities=array(
        '0'=>array('A', 'A', 'A', 'A', 'A', 'A'),
        '1'=>array('A', 'A', 'B', 'A', 'B', 'B'),
        '2'=>array('A', 'A', 'B', 'B', 'A', 'B'),
        '3'=>array('A', 'A', 'B', 'B', 'B', 'A'),
        '4'=>array('A', 'B', 'A', 'A', 'B', 'B'),
        '5'=>array('A', 'B', 'B', 'A', 'A', 'B'),
        '6'=>array('A', 'B', 'B', 'B', 'A', 'A'),
        '7'=>array('A', 'B', 'A', 'B', 'A', 'B'),
        '8'=>array('A', 'B', 'A', 'B', 'B', 'A'),
        '9'=>array('A', 'B', 'B', 'A', 'B', 'A')
        );
    $code='101';
    $p=$parities[$barcode{0}];
    for($i=1;$i<=6;$i++)
        $code.=$codes[$p[$i-1]][$barcode{$i}];
    $code.='01010';
    for($i=7;$i<=12;$i++)
        $code.=$codes['C'][$barcode{$i}];
    $code.='101';
    //Draw bars
    $this->SetFillColor(0,0,0);
    $this->SetDrawColor(0,0,0);
    $allongement= 0;
    for($i=0;$i<strlen($code);$i++)
    {
    	if ($i < 3 || ($i >= 46 && $i < 49) || $i >= 92) $allongement = 2;else $allongement = 0;
        if($code[$i]=='1')
            $this->Rect($x+$i*$w, $y, $w, $h+$allongement, 'F');
    }
    //Print text under barcode
    $this->SetFont('Arial', '', 10);
    //$this->Text($x, $y+$h+11/$this->k, substr($barcode, -$len));
    $this->Text($x-2.0, $y+$h+8/$this->k,$barcode[0]);
    $this->Text($x+2.0, $y+$h+8/$this->k, substr($barcode, 1,6));
    $this->Text($x+18.0, $y+$h+8/$this->k, substr($barcode, 7,13));
	}

   
   /**
   *	fixe la couleur du trait
   */
	function setColor($color)
	{
		switch($color)
		{
			case rouge;$this->SetDrawColor('255','0','0');break;
			case vert;$this->SetDrawColor('51','204','0');break;
			case jaune;$this->SetDrawColor('255','255','0');break;
			case ocre;$this->SetDrawColor('255','204','0');break;
			case orange;$this->SetDrawColor('255','153','0');break;
			case bleu;$this->SetDrawColor('51','51','255');break;
			case mauve;$this->SetDrawColor('204','204','255');break;
			case gris;$this->SetDrawColor('192','192','192');break;
			case noir;$this->SetDrawColor('0','0','0');break;
			case rose;$this->SetDrawColor('255','153','255');break;
			default:$this->SetDrawColor('255','255','255');
		}
	}
	
	/**
	*	impression du contenu du badge
	*	
	*/
	function imprime_badge($nom,$prenom,$fonction,$code,$hopital,$service,$couleur,$photo='')
	{
		//$this->SetFont("Arial","",12);
		/** impression de la bordure */
		$this->setColor($couleur);
		$this->SetLineWidth($this->epaisseur_trait);
		$this->Rect($this->margeG,$this->margeS,$this->badge_width,$this->badge_heigth,"",1);
		$this->SetXY($this->margeG,$this->margeS+1);
		$this->Image("../images/logohus.png",$this->margeG+1,$this->margeS+1,$this->logoHus_Width,$this->logoHus_Heigth);
		$this->Cell($this->logoHus_Width,3,'',0,0);
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0,0,0);
		$this->MultiCell($this->hopital_width,5,$hopital,0,"C",true);
		/** photo */
		if($photo)
		{
			$this->Image("../".$photo,$this->margeG+$this->logoHus_Width+$this->hopital_width-$this->epaisseur_trait/2,$this->margeS+1,20,25);
		}
		else
		{
			$photo = "../images/profil.jpeg";
			$this->Image($photo,$this->margeG+$this->logoHus_Width+$this->hopital_width-$this->epaisseur_trait/2,$this->margeS+1,20,25);
		}
		
		$this->Cell($this->logoHus_Width);
		$this->SetTextColor(51,51,255);
		/** impression du service */
		$this->SetXY($this->margeG + $this->logoHus_Width,$this->margeS + $this->logoHus_Heigth-8);
		$this->Cell(40,10,$service,0,0,"C");
		$this->SetXY($this->margeG + 0.5,$this->margeS + $this->logoHus_Heigth);
		/** nom et prÃ©nom */
		$this->Cell(58,10,$nom." ".$prenom,0,0,"L");
		/** fonction */
		$this->Cell(10,10,$fonction,0,0,'C');
		$this->SetXY($this->margeG + 5,$this->margeS + $this->logoHus_Heigth +10);
		$this->Cell($this->margeG + 30,10,$code,0,0,"L");
		//$pdf=new pdfEAN13();
		// function EAN13($x, $y, $barcode, $h=16, $w=.35)
		//$ean->EAN13($this->margeG + 39,$this->margeS + $this->logoHus_Heigth +7.5, $code,16,40);
		//$this->Barcode($this->margeG + 39,$this->margeS + $this->logoHus_Heigth +7.5, $code,16,40, 13);
		$this->EAN13($this->margeG + 39,$this->margeS + $this->logoHus_Heigth +7.5, $code,12,0.35);
		//$this->Image("../cb.png",$this->margeG + 39,$this->margeS + $this->logoHus_Heigth +7.5,16,40);
	}
}