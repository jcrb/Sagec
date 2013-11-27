<?php
// code_barre_fabrique.php
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("code_barre.php");
/**
  *	calcule la clé
  *	$code = 12 digits
  */
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

/**
  *	Vérifie que la clé est cohérente avec le code
  *	$code = code complet a 13 digits
  */
function valide_code($code)
{
	$taille = strlen($code);
	if($taille < 13){
		echo 'le code est trop court';
		exit(0);
	}
	$cle = substr($code,12,1);
	$corps=substr($code,0,12);
	
	return $cle == get_cle($corps);
}

$code = $_REQUEST['ean'];
if(strlen($code)<12)
	Header( "Content-type: error.jpeg");
else
{

	$codeEAN = new debora($code,$_REQUEST['hauteur'],$_REQUEST['largeur']);
	$codeEAN->makeImage();
}
?>
