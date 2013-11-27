<?php
/**
 *	codebarre_utilitaires.php
 */
 
/**
 *	calcule le code EAN 13
 */
function code($persoID,$orgID,$pays=30)
{
	$organisme = substr("000".$orgID,-3);
	$service = "000";
	$individu = substr("0000".$persoID,-4);
	$code = $pays.$organisme.$service.$individu;
	for($i=strlen($code)-1;$i >0; $i-=2)
	{
		(int)$a = 3 * (int)$code[$i];
		(int)$b = (int)$code[$i-1];
		$mot = (int)$mot + (int)$a + (int)$b;
		//print($mot."<BR>");
	}
	$clef = 0;
	while(($mot+$clef) % 10 != 0)
	{
		$clef++;
	}
	return $code = $code.$clef;
}