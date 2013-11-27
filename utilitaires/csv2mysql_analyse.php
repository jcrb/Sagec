<?php
/**----------------------------------------- SAGEC --------------------------------------------------------

 This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
 SAGEC67 is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.
 SAGEC67 is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.
 You should have received a copy of the GNU General Public License
 along with SAGEC67; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

/** utilitaires/csv2mysql_analyse.php
* 	Récupère un fichier Text et insère les données dans une table
*	date de création: 	24/12/2008		 
*	@author:		jcb		  
*	@version:	$Id$	 
*	maj le:				
*	@package			sagec
*/
/*--------------------------------------------------------------------------------------------------------*/
$backpath = "./../";
require($backpath."dbConnection.php");
require_once($backpath."gis/gis_utilitaires.php");
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
</head>
<body>
<?php
/**
*	caractéristiques
*/
$nbLignesAignorer = 4;
$separateur = "\t";
$paysID = 9;
$pays="ALLEMAGNE";

/**
*	recherche si une ville existe
*	Si oui, retourne son identifiant
*	Si non, la crée et retourne son identifiant
*/
function ville_existe($ville,$zip='',$pays_ID='')
{
	global $connexion;
	$requete = "SELECT ville_ID FROM ville WHERE ville_nom = '$ville' AND pays_ID = '$pays_ID'";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	if($rub['ville_ID'])
		return $rub['ville_ID'];
	else
	{
		$requete = "INSERT INTO ville (ville_nom,ville_zip,pays_ID) VALUES ('$ville','$zip','$pays_ID')";
		$resultat = ExecRequete($requete,$connexion);
		return mysql_insert_id();
	}
}

/**
*
*/
function adresse($ad1,$ad2,$zip,$ville_ID,$ville_nom,$pays)
{
	global $connexion;
	$no_error = 200;
	$ad = formatte_adresse('',$ad1,$zip,$ville_nom,$pays);
	$coord = geolocalise($ad);
	if($coord['0'] == $no_error)
	{
		$lat = $coord['2']; 
		$lng = $coord['3'];
	}
	else
		print("erreur: ".$coord['0']."<br>");
	
	$requete = "INSERT INTO adresse VALUES('','$ad1','$ad2','','$ville_ID','$zip','$lng','$lat')";
	$resultat = ExecRequete($requete,$connexion);
	print($requete."<br>");
	return mysql_insert_id();
}


function contact($type,$nature,$identifiant,$pays,$confidentialite,$reseau,$valeur,$lieu,$nom)
{
	global $connexion;
	$requete = "INSERT INTO contact VALUES('','$type','$nature','$identifiant','$pays','$confidentialite','$reseau','$valeur','$lieu','$nom')";
	$resultat = ExecRequete($requete,$connexion);
	print($requete."<br>");
}

/**
*
*/
function centrale($nom,$type,$adresse)
{
	global $connexion;
	$requete = "INSERT INTO centrale VALUES('','$nom','$type','$adresse')";
	$resultat = ExecRequete($requete,$connexion);
	print($requete."<br>");
	return mysql_insert_id();
}

/**
*	upload du fichier
*/
$uploaddir = $backpath.'administrateur/upload/';
print($uploaddir1."<br>".$uploaddir2."<br>");

$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

echo '<pre>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    echo "Le fichier est valide, et a été téléchargé
           avec succès. Voici plus d'informations :\n";
} else {
    echo "Attaque potentielle par téléchargement de fichiers.
          Voici plus d'informations :\n";
}

echo 'Voici quelques informations de débogage :';
print_r($_FILES);

echo '</pre>';

$fp=fopen($uploadfile,"r");
/**
* élimine entête
*/
for($i=0;$i<$nbLignesAignorer;$i++)
	$mot = fgets($fp,4096);
/**
*	lecture
*/
while(!feof($fp))
{
	$mot = fgets($fp,4096);
	/**
	*	ignore la ligne si commence par
	*/
	 // à faire
	 
	 /**
	 *	explode
	 */
	 $mot = str_replace('"','',$mot);//supprime les guillemets
	 echo '<pre>';
	 	print_r($mot);
	 echo '</pre>';
	 $rep = explode("\t",$mot);
	 $ville = $rep[5];
	 $zip =  $rep[4];
	 $ville_ID = ville_existe($ville,$zip,$paysID);
	 $centrale_nom = "RW ".$rep[1];
	 $centrale_type_ID = 5;
	 $ad1 = $rep[3];
	 $ad2 = '';
	 $centrale_adresse_ID = adresse($ad1,$ad2,$zip,$ville_ID,$ville,$pays);
	 $centrale_ID = centrale($centrale_nom,$centrale_type_ID,$centrale_adresse_ID);
	 $tel = $rep[7];
	 $fax = $rep[8];
	 // contact tel
	 if($tel)
	 	contact(1,6,$centrale_ID,$paysID,1,0,$tel,2,'Emergency');
	 // contact fax 
	 if($fax)
	 	contact(7,6,$centrale_ID,$paysID,1,0,$fax,2,'Emergency');
} // end while


print($mot);
fclose($fp);
?>

</body>
</html>