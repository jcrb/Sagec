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
//	date de création: 	01/10/2004
//	auteur:			jcb
//	description:		saisie des caractéristiques d'un médicament
//	version:			1.0
//	maj le:			01/10/2004
//
//--------------------------------------------------------------------------------------------------------

session_start();
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$langue = $_SESSION['langue'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
include("../utilitaires/table.php");
require '../utilitaires/globals_string_lang.php';
//include("../utilitairesHTML.php");
include("utilitaires_MED.php");

print("<html>");
print("<head>");
print("<title> Médicaments </title>");
print("<LINK REL=stylesheet HREF=\"../pma.css\" TYPE =\"text/css\">");
print("<LINK REL = stylesheet TYPE = \"text/css\" HREF = \"pharma.css\">");
?>

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
        args = 'toolbar=no,location=no,directories=no,status=no,menubar=no,' +
                'scrollbars=no,resizable=yes,' +
                'width=480,height=200,left=20,top=20';
        result = window.open(url, "whatever", args);
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
	$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
	//print("$item = document.Services.ID_stock.selectedIndex;");
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
<?php
print("</head>");

print("<BODY BGCOLOR=\"#ffffff\" >");
print("<FORM name =\"Services\"  ACTION=\"medicament_enregistre.php\" METHOD=\"GET\">");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
// nouveau ou mise à jour
//print($_GET['medicament']);
if($_GET['medicament'])// c'est une mise à jour
{
	$requete="SELECT * FROM medicament WHERE medic_ID = '$_GET[medicament]'";
	$resultat = ExecRequete($requete,$connexion);
	$med=mysql_fetch_array($resultat);
	print("<p>Médicament enregistré</p>");
	print("<INPUT TYPE=\"HIDDEN\" NAME=\"maj\" VALUE=\"$_GET[medicament]\">");
}
else
	print("<p>Nouveau médicament</p>");

TblDebut(1,"100%","","",time);
	TblDebutLigne();
		TblCellule($string_lang['NOM'][$langue].": ");
		print("<TD>");
		select_specialites($connexion,$med[medic_nom]);
		print("</TD>");
		if($_GET['medicament'])// c'est une mise à jour
		{
			$mot="Modifier le nom";
			$action = "modif_nom";
		}
		else
		{
			$mot="Ajouter un médicament";
			$action = "med";
		}
		TblCellule("<input type=\"button\" name=\"select_med\" value=\"$mot\"
		 			onclick=\"open_popup_window('$action','$med[medic_nom]')\">");
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
		print("<A HREF = \"http://www.ameli.fr/23/get.html?page=deno\"> aide </A>");
		print("</TD>");
	TblFinLigne();
	//============================== Famille ====================================================
		TblDebutLigne();
		TblCellule($string_lang['FAMILLE'][$langue].": ");
		$requete = "SELECT * FROM medicament_med_famille WHERE medic_ID='$med[medic_nom]'";
		$resultat = ExecRequete($requete,$connexion);
		print("<TD>");// un médicament peut appartenir jusqu'à 3 familles
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
	//============================== Présentation ====================================================
	TblDebutLigne();
		TblCellule($string_lang['PRESENTATION'][$langue].": ");
		print("<TD>");
			print("<table>");
			print("<tr>");
				print("<TD>");
					//$ID_presentation $med[medic_presentation]
					select_presentation($connexion,$med['medic_presentation']);
				print("</TD>");
				print("<TD>dosé(e)s à</TD>");
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
		print(" mois avant péremption");
		print("</TD>");
	TblFinLigne();

	*/
TblFin();

//liste_med($connexion);

print("</FORM>");
print("</html>")
?>
