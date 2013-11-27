<?php
/**
  *	imprime_etiquettes.php
  */
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
require($backPathToRoot."dbConnection.php");
//require_once'Zend/Pdf.php';
//require_once'Zend/Zend_Barcode.php';

$nb = $_REQUEST[nb];

$requete = "SELECT org_nom FROM organisme WHERE org_ID='$_REQUEST[orgByType]'";
$resultat = ExecRequete($requete,$connexion);
$rep = mysql_fetch_array($resultat);
print($requete);

$organisme = substr('0000'.$_REQUEST['orgByType'],-4,4);
/**
  * a remettre en production
	$organisme = substr('0000'.$_SESSION['organisation'],-4,4);
  */
if($_REQUEST['type']==1)
	$pays = '379';	// France exercice
else
	$pays = '300';
$no_depart = 1; // fourchette d'impression 
$no_final = $no_depart + $nb -1;

function get_cle($code)
{
	for($i=strlen($code)-1;$i >0; $i-=2)
	{
		(int)$a = 3 * (int)$code[$i];
		(int)$b = (int)$code[$i-1];
		$mot = (int)$mot + (int)$a + (int)$b;
	}
	$clef = 0;
	while(($mot+$clef) % 10 != 0)
	{
		$clef++;
	}
	return $clef;
}

?>
<H2>Emetteur: <?php echo $rep['org_nom'];?></h2>
<table>
<?php
for($i=$no_depart; $i<$no_final; $i++)
{
	$code = $pays.$organisme.substr('00000'.$i,-5,5);
	$code .= get_cle($code);
	if($_REQUEST[ferme] != "on")
	{
		?>
		<tr>
			<td><?php echo $i;?></td>
			<td><?php echo $code;?></td>
		<?php
	}
	else
	{
		?>
		<tr>
			<td><?php echo $i;?></td>
			<td><IMG SRC="code_barre_fabrique.php?ean=<?php echo $code;?>&largeur=130&hauteur=45"></td>
		</tr>
		<?php
		//print("<IMG SRC=\"code_barre_fabrique.php?ean=$code&largeur=130&hauteur=45\"><br>");
	}
}
?>
</table>

<?php
/*
// Case 1: constructor
$barcode = new Zend_Barcode_Object_Code39($options);

$fileName = 'test.pdf';

	$pdf = new Zend_Pdf();
	$pdf->pages[] = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4);
	$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
	$pdf->pages[0]->setFont($font,36);
	$height = $pdf->pages[0]->getHeight();
	$width  = $pdf->pages[0]->getWidth();
	$pdf->pages[0]->drawText($width,150,150);
	 
	
	// Draw rectangle 
$pdf->pages[0]->setFillColor(new Zend_Pdf_Color_GrayScale(0.9)); 
$pdf->pages[0]->setLineColor(new Zend_Pdf_Color_GrayScale(0.2)); 
$pdf->pages[0]->setLineDashingPattern(array(3, 2, 3, 4), 1.6); 
$pdf->pages[0]->drawRectangle(50,800,150,840);

$pdf->save($fileName);
	
	// Get PDF document as a string 
$pdfData = $pdf->render(); 

header("Content-Disposition: inline; filename=result.pdf"); 
header("Content-type: application/x-pdf"); 
echo $pdfData; 
*/
?>