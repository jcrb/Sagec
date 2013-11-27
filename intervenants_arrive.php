<?php
//----------------------------------------- SAGEC --------------------------------------------------------

// This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// Foobar is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
/**
* 	intervenants_arrive.php
*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
require("pma_connect.php");
require("pma_connexion.php");
require("pma_requete.php");
require("date.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
require("intervenants_menu.php");
menu_intervenants($_SESSION['langue']);

/**
 *		algorithme de Luhn
 *		vérifie qu'un code barre est exact
 *		source: wikipedia
 *		ne fonctionne pas avec EAN13 ?????
 */
function isLuhnNum($num)
{
	//longueur de la chaine $num
	$length = strlen($num);
	if($length < 2) return false;
	//resultat de l'addition de tous les chiffres
	$tot = 0;
	for($i=$length-1;$i>=0;$i--)
	{
		$digit = substr($num, $i, 1);

		if ((($length - $i) % 2) == 0)
		{
			$digit = $digit*2;
			if ($digit>9)
			{
				$digit = $digit-9;
			}
		}
		$tot += $digit;
	}
	return (($tot % 10) == 0);
}

$mot=$string_lang['GESTION_INTERVENANT'][$langue];

?>
<html>
	<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title><?php echo $mot;?></title>
	<LINK REL=stylesheet HREF="pma.css" TYPE ="text/css">
	<LINK REL=stylesheet HREF="../css/impression2.css" TYPE ="print/css">
	<LINK REL="SHORTCUT ICON" HREF="images/sagec67.ico">
	</head>

	<body onload="document.arrive.code.focus();">

<?php

if($_REQUEST['mouvement'] == "arrive")
{
	$code = $_REQUEST['code']; //print(strlen($code));
	$h = uDateTime2MySql(time());
	//if(isLuhnNum($code))
	if(strlen($code)>5)
	{
		print(" 1 ");
		/**
		 * le code personnel HUS commence par 30085. Il contient normalement 13 caractères
		 * avec le caractère de contrôle et 12 sans.
		 * Le code RPPS est aussi accepté mais il comporte 12 caractères (11 + 1)
		 */
		if(strlen($code)==11)	// code RPPS 
		{
			$requete = "UPDATE personnel
						SET arrive = 'o',heure_arrive = '$h',heure_depart=0
		 				WHERE rpps = '$code'
		 				AND arrive <> 'o'
		 				";
		}
		else if(strlen($code)==13)	// Code SAMU 
		{
			print(strlen($code));
			$id =  substr($code,-4,3);
			$requete = "UPDATE personnel
						SET arrive = 'o',heure_arrive = '$h',heure_depart=0
		 				WHERE Pers_ID = '$id'
		 				AND arrive <> 'o'
		 				";
		 }
	}
	else if($_REQUEST['nom'])
	{
		print(" 2 ");
		$requete = "UPDATE personnel
						SET arrive = 'o',heure_arrive = '$h',heure_depart=0
		 				WHERE Pers_Nom = '$_REQUEST[nom]'
		 				AND arrive <> 'o'
		 				";
	}
	if(isset($requete))
		ExecRequete($requete,$connexion);
	else $requete = "Code Erroné";
	print("Requete arrive: ".$requete."<br>");
}
else if($_REQUEST['mouvement'] == "depart")
{
	$code = $_REQUEST['code'];print($code);
	$h = uDateTime2MySql(time());
	//if(isLuhnNum($code))
	if(strlen($code)>5)
	{
		/**
		 * le code personnel HUS commence par 30085. Il contient normalement 13 caractères
		 * avec le caractère de contrôle et 12 sans.
		 * Le code RPPS est aussi accepté mais il comporte 12 caractères (11 + 1)
		 */
		if(strlen($code)==11)
		{
			//$id =  substr($code,-3,3);
			$requete = "UPDATE personnel
						SET arrive = '',heure_depart = '$h'
		 				WHERE rpps = '$code'
		 				";
		}
		else if(strlen($code)==13)
		{
			$id =  substr($code,-4,3);
			$requete = "UPDATE personnel
						SET arrive = '',heure_depart = '$h'
		 				WHERE Pers_ID = '$id'
		 				";
		 }
	}
	else if($_REQUEST['nom'])
	{
		$requete = "UPDATE personnel
						SET arrive = '',heure_depart = '$h'
		 				WHERE Pers_Nom = '$_REQUEST[nom]'
		 				";
	}
	if(isset($requete))
		$resultat = @ExecRequete($requete,$connexion);
	print("Requete depart: ".$requete."<br>");
}
?>
<form name="arrive" method="get" action="">


<?php

print("<table class=\"noprint\" >");
	print("<tr>");
		print("<td>");
		
print("<fieldset>");
print("<legend>Mouvement</legend>");
print("<table class=\"noprint\" >");
	print("<tr>");
		print("<td>&nbsp;</td>");
		print("<td><input type=\"radio\" name=\"mouvement\" value=\"arrive\" \"checked\" onClick=\"document.arrive.code.focus();\">Arrivée");
		print("&nbsp;&nbsp;<input type=\"radio\" name=\"mouvement\" value=\"depart\" onClick=\"document.arrive.code.focus();\">Départ</td>");
	print("</tr>");
	print("<tr>");
	print("<tr>");
		print("<td>code:</td>");
		print("<td><input type=\"text\" name=\"code\" value=\"\"></td>");
		print("<td><input type=\"submit\" name=\"ok\" value=\"Valider\"></td>");
	print("</tr>");
	print("<tr>");
		print("<td>nom:</td>");
		print("<td><input type=\"text\" name=\"nom\" value=\"\"></td>");
	print("</tr>");
	print("<tr>");
		print("<td>prenom:</td>");
		print("<td><input type=\"text\" name=\"prenom\" value=\"\"></td>");
	print("</tr>");
print("</table>");
print("</fieldset>");
		print("</td>");
print("</tr>");
print("</table>");

$back = "intervenants_arrive.php";

print("<fieldset>");
print("<legend>Personnels enregistrés</legend>");
print("<table border=\"1\" cellspacing=\"0\">");
?>
	<tr>
		<th>Nom</th>
		<th>Prénom</th>
		<th>Heure arrivée</th>
		<th>Heure départ</th>
	</tr>
<?php
$requete = "SELECT Pers_ID,Pers_Nom,Pers_Prenom,heure_arrive, heure_depart FROM personnel WHERE heure_arrive > 0 ORDER BY Pers_Nom";
$resultat = ExecRequete($requete,$connexion);
while($rub=mysql_fetch_array($resultat))
{
	print("<tr>");
		print("<td><a href=\"intervenant_saisie.php?back=$back&personnelID=$rub[Pers_ID]\">$rub[Pers_Nom]</a></td>");
		print("<td>$rub[Pers_Prenom]</td>");
		print("<td>$rub[heure_arrive]</td>");
		if($rub[heure_depart] > 0)
			print("<td>$rub[heure_depart]</td>");
		else
			print("&nbsp;");
	print("</tr>");
}
?>
</table>
</fieldset>
</form>
</body>
</html>
