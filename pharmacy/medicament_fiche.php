<?php
//----------------------------------------- SAGEC --------------------------------------------------------

// This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// SAGEC67 is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//----------------------------------------- SAGEC --------------------------------------------------------
//
//	programme: 		medicament_fiche.php
//	date de cr�ation: 	01/10/2004
//	auteur:			jcb
//	description:		saisie des caract�ristiques d'un m�dicament
//	version:			1.0
//	maj le:			01/10/2004
//
//--------------------------------------------------------------------------------------------------------

session_start();
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../";
$titre_principal = "Pharmacie - M�dicaments";
$sousmenu = "";
include_once("pharmacy_top.php");
include_once("pharmacy_menu.php");

require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
include("../utilitaires/table.php");
require '../utilitaires/globals_string_lang.php';
include("utilitaires_MED.php");
?>

<html>
<head>
<title> M�dicaments </title>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Gestion des organismes</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href= "<?php echo $backPathToRoot;?>images/sagec67.ico" />
	<script  type="text/javascript" src= "<?php echo $backPathToRoot;?>utilitaires.js"></script>

	<script type="text/javascript">
	<!-- set focus to a field with the name "med_nom" in my form -->
	function setfocus()
	{
		document.forms[0].med_nom.focus();
	}
function open_popup_window(n,v) {
	switch(n){
		case 'dci':url = "DCI_enregistre.php";break;
		case 'med':url = "MED_enregistre.php";break;
		case 'fam':url = "FAM_enregistre.php";break;
		case 'fou':url = "FOU_enregistre.php";break;
		case 'modif_nom':url = "MED_enregistre.php?maj="+v;break;
	}
��������args = 'toolbar=no,location=no,directories=no,status=no,menubar=no,' +
����������������'scrollbars=no,resizable=yes,' +
����������������'width=480,height=200,left=20,top=20';
��������result = window.open(url, "whatever", args);
	   window.opener.location.reload();//rafraichissement de la page
}
function print_fonction()
{
	//on vide la liste
	lg = document.Services.ID_medlocal.length;

	for(i=lg-1; i>=0;i--)
	{
		document.Services.ID_medlocal.options[i]=null;
	}
	item = document.Services.ID_stock.selectedIndex;
	//document.writeln(item);
	<?php
	$requete="SELECT local_ID,local_nom,med_stock_ID FROM med_localisation ORDER BY local_nom";
	//print("document.writeln($requete);");
	$resultat = ExecRequete($requete,$connexion);
	print("document.Services.ID_medlocal.length = ".mysql_num_rows($resultat).";\n");
	$i=0;
	print($x=" item;\n");
	while($rub=mysql_fetch_array($resultat))
	{
		//print("if(item==".$rub[med_stock_ID]."){");
		if($x == $rub[med_stock_ID])
		{
		echo "document.Services.ID_medlocal.options[".$i."].value = ".$rub[local_ID].";\n";
		print("document.Services.ID_medlocal.options[".$i."].text =\"".$rub[local_nom]."\";\n");
		$i++;
		//print("}");
		}
	}
	@mysql_free_result($resultat);
	?>

}
</script>
</head>

<body bgcolor="#ffffff" >
<form name="Services" action="medicament_enregistre.php" onload="" method="post">

<div id="div2">
	<fieldset id="field1">
<?php

if($_REQUEST['medicament'])// c'est une mise � jour
{
	$requete="SELECT medicament.* ,special_nom,special_ID
				FROM medicament, med_specialite
				WHERE medic_ID = '$_REQUEST[medicament]'
				AND medic_nom = special_ID
				";
	$resultat = ExecRequete($requete,$connexion);
	$med=mysql_fetch_array($resultat);
	print("<p>M�dicament enregistr�</p>");
	print("<INPUT TYPE=\"HIDDEN\" NAME=\"maj\" VALUE=\"$_GET[medicament]\">");
}
else
	print("<p>Nouveau m�dicament</p>");

TblDebut(1,"100%","","",time);
	TblDebutLigne();
		TblCellule($string_lang['NOM'][$langue].": ");
		print("<TD>");
		
		//select_specialites($connexion,$med[medic_nom]);
		?>
		<input type="text" name="specialite" value="<?php echo $med[special_nom];?>"/>
		<input type="hidden" name="ID_special" value="<?php echo $med[special_ID];?>"/>
		<?php
		
		print("</TD>");
		/*
		if($_GET['medicament'])// c'est une mise � jour
		{
			$mot="Modifier le nom";
			$action = "modif_nom";
		}
		else
		{
			$mot="Ajouter un m�dicament";
			$action = "med";
		}
		
		TblCellule("<input type=\"button\" name=\"select_med\" value=\"$mot\"
		 			onclick=\"open_popup_window('$action','$med[medic_nom]')\">");
		*/
	TblFinLigne();
	//============================== DCI ====================================================
	TblDebutLigne();
		TblCellule($string_lang['DCI'][$langue].": ");
		print("<TD>");
			select_dci($connexion,$med[medic_dci]);//ID_dci
		print("</TD>");
		print("<TD>");
		print("<input type=\"button\" name=\"select_dci\" value=\"Ajouter une DCI\"
		 			onclick=\"open_popup_window('dci')\">");
		//print("<A HREF = \"http://www.ameli.fr/23/get.html?page=deno\"> aide </A>");
		print("</TD>");
	TblFinLigne();
	//============================== Famille ====================================================
		TblDebutLigne();
		TblCellule($string_lang['FAMILLE'][$langue].": ");
		$requete = "SELECT * FROM medicament_med_famille WHERE medic_ID='$med[medic_nom]'";
		$resultat = ExecRequete($requete,$connexion);
		print("<TD>");// un m�dicament peut appartenir jusqu'� 3 familles
		for($i=0;$i<3;$i++)
		{
			if($fam = mysql_fetch_array($resultat))
				liste_famille($connexion,$fam['famille_ID']); //$ID_famille[0]
			else
				liste_famille($connexion,0); //$ID_famille[1]
		}
		print("</TD>");
		TblCellule("<input type=\"button\" name=\"select_famille\" value=\"Ajouter une famille\"
		 			onclick=\"open_popup_window(fam)\">");
	TblFinLigne();
	//============================== Fournisseur ====================================================
	TblDebutLigne();
		TblCellule($string_lang['FOURNISSEUR'][$langue].": ");
		print("<TD>");
		//	select_fournisseur($connexion,0);
		print("</TD>");
		TblCellule("<input type=\"button\" name=\"select_fournisseur\" value=\"Ajouter un fournisseur\"
		 			onclick=\"open_popup_window('fou')\">");
	TblFinLigne();
	//============================== Pr�sentation ====================================================
	TblDebutLigne();
		TblCellule($string_lang['PRESENTATION'][$langue].": ");
		print("<TD>");
			print("<table>");
			print("<tr>");
				print("<TD>");
					//$ID_presentation $med[medic_presentation]
					select_presentation($connexion,$med['medic_presentation']);
				print("</TD>");
				print("<TD>dos�(e)s �</TD>");
				print("<TD>");
					print("<input type=\"text\" name=\"poso\" value=\"$med[medic_dosage]\" size=\"3\"> ");
				print("</TD>");
				print("<TD>");
					select_unite($connexion,$med[medic_dosage_unite],"mg");//$ID_unite
				print("</TD>");
			print("</tr>");
			print("<tr>");
				print("<TD>&nbsp;</TD>");
				print("<TD>si applicable volume:</TD>");
				print("<TD>");
					print("<input type=\"text\" name=\"volume\" value=\"$med[medic_volume]\" size=\"3\"> ");
				print("</TD>");
				print("<TD>");
					select_unite($connexion,$med[medic_volume_unite],"ml");//$ID_unite
				print("</TD>");
			print("</tr>");
		print("</table>");
		print("</TD>");
		print("<TD><input type=\"submit\" name=\"ok\" value=\"Valider\"></TD>");
	TblFinLigne();
	/*

	//============================== Sortir du stock ====================================================
		TblDebutLigne();
		//TblCellule($string_lang['DOSAGE'][$langue].": ");
		TblCellule("sortir du stock");
		print("<TD>");
		print("<input type=\"text\" name=\"lot\" value=\"\" size=\"2\" div align=\"center\"> ");
		print(" mois avant p�remption");
		print("</TD>");
	TblFinLigne();

	*/
TblFin();

?>
	</fieldset>

</body>
</form>
</html>

