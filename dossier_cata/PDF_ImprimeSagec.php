<?php
/**
  *	classe PDF_ImprimeSagec.php
  *	classe de base pour les documents PDF
  */
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backtoPath="../pdf/";
$backPathToRoot = "../";

require_once($backtoPath.'fpdf.php'); 
require_once($backPathToRoot."dbConnection.php");
require_once($backPathToRoot."date.php");
require_once($backPathToRoot."login/init_security.php");
require_once("code_barre.php");

/**
  *	class fiche
  *	classe de base des imprimés Sagec
  */
class PDF_fiche extends FPDF{

	var $_Line_Height;            // hauteur d'une ligne
	var $_Padding;                // Padding
	var $_Metric_Doc;            // métriqye du document
	var $_COUNTX;                // position X courante
	var $_COUNTY;                // position Y courante
	var $_titre;						// titre de la page    
   var $epaisseur_trait = 2; 		//mm
	var $couleur_trait;
	var $margeG = 10;					// marge de gauche
	var $margeS = 40;
	
	function PDF_fiche($orientation='P')
	{
		parent::FPDF($orientation, 'mm', 'A4');//FPDF($orientation='P', $unit='mm', $format='A4')
   	$this->titre = 'Titre';
   	$this->AliasNbPages();
		$this->SetCreator('SAGEC67');
		$this->SetAuthor('jcb');
	}
	/**
	  *	imprime un titre en haut de page
	  *	utilisé par header
	  */
	function setTitre($titre)
	{
		$this->titre = $titre;
	}
	/**
	  * Header
	  */
	function Header()
	{
    //Logo
    $this->Image('../images/Logo_SAGEC3.png',10,8,33);
    //Police Arial gras 15
    $this->SetFont('Arial','B',15);
    //Décalage à droite
    $this->Cell(80);
    //Titre
    $this->Cell(60,10,$this->titre,1,0,'C');
    $this->Cell(60);
    $this->Cell(60,10,$this->now(),1,0,'R');
    //Saut de ligne
    $this->Ln(20);
    
    	$this->x = $this->margeG;
		$this->y = $this->margeS;
		$this->lf = 8; // saut de ligne
		$this->SetXY($this->x,$this->y);
		
	}
	/**
	  *	Pied de page
	  */
	function Footer()
	{
    //Positionnement à 1,5 cm du bas
    $this->SetY(-15);
    //Police Arial italique 8
    $this->SetFont('Arial','I',8);
    //Numéro de page
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	/**
	  *	now()
	  *	date heure courante au format jj/mm/aa hh:mm:ss
	  */
	function now()
	{
		return uDatetime2French(time());
	}
	
	/** méthodes pour CodeBarre */
	
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
	
}
/** end classe fiche */


?>