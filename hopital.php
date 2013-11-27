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

/**
 * Documents the class following hopital.php
 * description:		Création / mise à jour d'un Hôpital. appelé par Hopital_maj. Le Hop_ID est transmis par la variable $ID_hopital qui vaut 0
 * pour un nouveau service
 * @package Sagec
 * @version $Id: hopital.php 43 2008-03-13 22:41:12Z jcb $
 * @author JCB
 */

session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//if(! $_SESSION['auto_sagec'])header("Location:logout.php");

/**< Langue courante */
$langue = $_SESSION['langue'];
/** Identifiant de l'hôpital */
$id_hop = $_REQUEST['ID_hopital'];
$backPathToRoot = "";
include_once($backPathToRoot."login/init_security.php");

include($backPathToRoot."utilitaires/table.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
include($backPathToRoot."utilitairesHTML.php");
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."menu_gestion_lits.php");
include($backPathToRoot."adresse_ajout.php");
include($backPathToRoot."contact_main.php");

/**
* Dessine une case à cocher et sa légende. En foction de la variable $x, la case sera cochée ou non
* @param $name nom interne de la case à cocher
* @param $x indique si la case doit être cochée ou non
* @param $titre légende de la case à cocher
*/
function check($name,$x,$titre)
{
	//print("<p>");
	if($x)
		print("<td class=\"time\"><INPUT TYPE=\"CHECKBOX\"  NAME=\"$name\" CHECKED value=\"o\" id=\"$name\">");
	else
		print("<td class=\"time_b\"><INPUT TYPE=\"CHECKBOX\"  NAME=\"$name\" id=\"$name\">");
	print("<label for=\"$name\">$titre</label></td>");
	//print("</p>");

}
function confinement($name,$select)
{
	print("<TD><select name=\"$name\" size=\"1\">");
	for($i=1;$i<5;$i++)
	{
		print("<OPTION VALUE=\"$i\" ");
		if($i == $select) print(" SELECTED");
			print("> P".$i." </OPTION> \n");
	}
	print("</SELECT></TD>");
}

/**
* 	Le bouton VALIDER n'apparait que si
*	$_SESSION["modif_hopital"] = 2
*	ou si $_SESSION["modif_hopital"] = 1 ET l'utilisateur appartient à l'hopital
*/
function valider($langue)
{
	global $id_hop;
	if($_SESSION["modif_hopital"]==2 || ($_SESSION["modif_hopital"]==1 && $_SESSION["Hop_ID"] == $id_hop))
	{
		global $string_lang;
		$mot = $string_lang['VALIDER'][$langue];
		TblCellule("<INPUT TYPE=\"SUBMIT\" VALUE=\"$mot\" NAME=\"ok\" SIZE = \"30\"> ");
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Hopital</title>
	<link rel="stylesheet" href="aa GABARIT/div.css" type="text/css" media="all" />
	<LINK REL=stylesheet HREF="pma.css" TYPE ="text/css">
	<link rel="shortcut icon" href="images/sagec67.ico" />
	<script  type="text/javascript" src="utilitaires.js"></script>
</head>


<BODY onload="document.Hopital.nom_hop.focus()">
<FORM name ="Hopital"  ACTION="hopital_enregistre.php" METHOD="GET">

<?php
menu_lits_maj($langue, $titre="Hôpitaux - Création & Mise à jour");
print("<br>");

if($_GET['ID_hopital'])
{
	// mémorisation dans un champ caché de $maj_hop pour se rappeler s'il s'agit d'une MAJ
	// ou d'une création
	print("<INPUT TYPE=\"HIDDEN\" NAME=\"maj\" VALUE=\"$_GET[ID_hopital]\">");
	$requete = "SELECT * FROM hopital WHERE Hop_ID='$_REQUEST[ID_hopital]'";
	$resultat = ExecRequete($requete,$connexion);
	$rub = LigneSuivante($resultat);
	$adresse_ID = $rub->adresse_ID;
	print("<INPUT TYPE=\"HIDDEN\" NAME=\"adresse_ID\" VALUE=\"$adresse_ID\">");
}

$requete = "SELECT org_nom FROM organisme WHERE org_ID='$rub->org_ID'";
$resultat = ExecRequete($requete,$connexion);
$org = LigneSuivante($resultat);

// début du tableau
//========================================= IDENTIFICATION ===============================================
?>
<div id="div2">
<fieldset  id="field1">
		<legend>Identification </legend>
		<p>
			<label for="z1" title="z1"><?php echo $string_lang['HOPITAL'][$langue]?>:</label>
			<input type="text" name="nom_hop" id="z1" title="z1" value="<? echo Security::db2str($rub->Hop_nom);?>" size="30" onFocus="_select('z1');" onBlur="deselect('z1');"/>
		</p>
		<p>
			<label for="z2" title="z1"><?php echo $string_lang['ORGANISME'][$langue]?>:</label>
			<?php SelectOrganisme($connexion,$rub->org_ID,$langue,'');?><!--//$orgID contient l'ID de l'organisme -->
		</p>
		<p>
			<label for="z2" title="z1"><?php echo $string_lang['TYPE'][$langue]?>:</label>
			<?php select_type_etablissement($connexion,$rub->type_etablissement_ID,$langue);?><!--retourne id_type_etablissement -->
		</p>
		<p>
			<label for="z3" title="z3"><?php echo('FINESS:') ?>:</label>
			<input type="text" name="finess" id="z3" title="z3" value="<? echo stripslashes($rub->Hop_finess);?>" size="9" onFocus="_select('z3');" onBlur="deselect('z3');"/>
			<? $finess = "http://finess.sante.gouv.fr/finess/actionRechercheSimple.do?nofiness=".$rub->Hop_finess;?>
			<a href="<? echo($finess);?></a>"  target="_blank" > FINESS </a>
		</p>
	</fieldset>
	<fieldset  id="field1">
		<legend>Lits - Beds - Betten </legend>
		<p>
			<label for="z4" title="z4"><?php echo ('nombre total de lits');?>:</label>
			<input type="text" name="tot_lits" id="z4" title="z4" value="<? echo $rub->total_lits;?>" size="10" onFocus="_select('z1');" onBlur="deselect('z1');"/>
		</p>
	</fieldset>
	<!-- ===============================  affichage du champ adresse  ================================================= -->
	<?php get_adresse($adresse_ID,'V');?>


<?php
/**
print("<FIELDSET>");
print("<LEGEND class=\"time\"> Identification</LEGEND>");
TblDebut(0,"100%","1","0",time_v);
	TblDebutLigne();
		TblCellule($string_lang['HOPITAL'][$langue].":");
		$nom_hop = stripslashes($rub->Hop_nom);
		$nom_org = stripslashes($rub->Hop_org);
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$nom_hop\" NAME=\"nom_hop\" SIZE = \"30\"> ");
		TblCellule($string_lang['ORGANISME'][$langue].":");

		print("<TD>");
			SelectOrganisme($connexion,$nom_org,$langue,'');//$org_type contient le type_ID
		print("</TD>");
		TblCellule("Type");
		print("<TD>");
		select_type_etablissement($connexion,$rub->type_etablissement_ID,$langue);//retourne id_type_etablissement
		print("</TD>");
		$mot = $string_lang['VALIDER'][$langue];
		valider($langue);
		//TblCellule("<INPUT TYPE=\"SUBMIT\" VALUE=\"$mot\" NAME=\"ok\" SIZE = \"30\"> ");
	TblFinLigne();

	TblDebutLigne();
		TblCellule("FINESS:");
		TblCellule("<INPUT TYPE=\"TEXT\" VALUE=\"$rub->Hop_finess\" NAME=\"finess\" SIZE = \"9\">");
		TblCellule("<A HREF=\"http://finess.sante.gouv.fr/finess\"  target=\"_blank\" > FINESS </A> ");
		$finess = "http://finess.sante.gouv.fr/finess/details.do?nofiness=".$rub->Hop_finess;
		TblCellule("<A HREF=\"$finess\"  target=\"_blank\" > FINESS de l'établissement </A> ");
	TblFinLigne();
TblFin();
print("</FIELDSET>");
*/

//===============================  affichage des contacts  =====================================================
$hopid=$_GET['ID_hopital'];
$type=0;//nouveau
$nature=5;//hopital
$back="'../hopital.php'";
$variable="'ID_hopital'";
?>
<fieldset id="field1">
	<legend>Contacts</legend>
	<?php
		if($hopid)//pour empêcher la création d'un contact tant que l'hôpital n'est pas créé
		{
			contact($hopid,$type,$nature,$contact_id,$back,$variable,$_GET['tri']);
		}
		//contact($contact,$type,$nature,$contact_id,$back,$variable_retour)
	?>
</fieldset>

<INPUT TYPE="SUBMIT" VALUE="Valider" NAME="ok">

</div>
<?php
/** ========================================= LITS              ===============================================
print("<FIELDSET>");
print("<LEGEND class=\"time\">Lits - Beds - Betten</LEGEND>");
print("nombre total de lits: <input type=\"text\" name=\"tot_lits\" value=\"$rub->total_lits\">");
print("</FIELDSET>");
========================================= PLATEAU TECHNIQUE =============================================== */

print("<FIELDSET>");
print("<LEGEND class=\"time_r\"> Plateau technique</LEGEND>");
TblDebut(0,"100%","","","time");//
	TblDebutLigne();
		//-------------------------- DZ ----------------------------------
		$mot="DZ";
		//check("dz",$rub->Hop_DZ,$mot);

		print("<td class=\"time\">");
		print("DZ <select name=\"dz\" size=\"1\">");
		$dz=array("NULL","SOL","TOIT","DISTANTE","NON");
		for($i=0;$i<4;$i++)
		{
			print("<OPTION VALUE=\"$i\" ");
			if($rub->Hop_DZ == $i) print(" SELECTED");
			print("> $dz[$i] </OPTION>");
		}
		print("</SELECT></TD>");
		//-------------------------- Dialyse -----------------------------
		$mot = $string_lang["DIALYSEUR"][$langue];
		check("dialyse",$rub->Hop_Dialyse,$mot);
		//-------------------------- Crâne grave -----------------------------
		$mot = $string_lang["TRAUMA_CRANE"][$langue];
		check("crane",$rub->Hop_Crane,$mot);
		//-------------------------- Polytraumatisé -----------------------------
		$mot = $string_lang["POLYTRAU"][$langue];
		check("polytrauma",$rub->Hop_polytrauma,$mot);
		//-------------------------- Brûlés -----------------------------
		$mot="Brûlés";
		$mot = $string_lang["BRÛLES"][$langue];
		check("brule",$rub->Hop_brule,$mot);
		//-------------------------- AVC -----------------------------
		$mot = $string_lang["STROKE"][$langue];
		check("stroke",$rub->Hop_stroke,$mot);
	TblFinLigne();

	TblDebutLigne();
		//-------------------------- SAMU -----------------------------
		$mot = $string_lang["SAMU"][$langue];
		check("samu",$rub->Hop_Samu,$mot);
		//-------------------------- SMUR -----------------------------
		$mot = $string_lang["SMUR"][$langue];
		check("smur",$rub->Hop_Smur,$mot);
		//-------------------------- PSM2 -----------------------------
		$mot="PSM2";
		check("psm2",$rub->Hop_psm2,$mot);
		//-------------------------- PSM1 -----------------------------
		$mot="PSM1";
		check("psm1",$rub->Hop_psm1,$mot);
		//-------------------------- SAU -----------------------------
		$mot = $string_lang["SAU"][$langue];
		check("sau",$rub->Hop_SAU,$mot);
		//-------------------------- UPATOU -----------------------------
		$mot = $string_lang["UPATOU"][$langue];
		check("upatou",$rub->Hop_upatou,$mot);
		//-------------------------- Caisson hyperbare ----------------------------------
		$mot = $string_lang["CAISSON"][$langue];
		check("caisson",$rub->Hop_caisson,$mot);
		valider($langue);
	TblFinLigne();
TblFin();
print("</FIELDSET>");
//========================================= MEDICO-TECHNIQUE ===============================================
print("<FIELDSET>");
print("<LEGEND class=\"time_r\"> Radiologie </LEGEND>");
//TblDebut(0,"75%","","",time);
print("<Table cellspacing=\"2\" width=\"75%\">");//class=\"time\"
	TblDebutLigne();
	//-------------------------- IRM -----------------------------
		$mot = $string_lang["IRM"][$langue];
		check("irm",$rub->Hop_IRM,$mot);

	//-------------------------- artério -----------------------------
		$mot = $string_lang["ARTERIO"][$langue];
		check("angio",$rub->Hop_Angio,$mot);

	//-------------------------- Echo -----------------------------
		$mot = $string_lang["ECHO"][$langue];
		check("echo",$rub->Hop_Echo,$mot);

	//-------------------------- Scanner -----------------------------
		$mot = $string_lang["SCANNER"][$langue];
		check("scanner",$rub->Hop_Scanner,$mot);

	//-------------------------- Pet Scan -----------------------------
		$mot = $string_lang["PET_SCAN"][$langue];
		check("petscan",$rub->Hop_Petscan,$mot);
		valider($langue);
	TblFinLigne();
TblFin();
print("</FIELDSET>");
//========================================= SERVICES ========================================================
print("<FIELDSET>");
print("<LEGEND class=\"time_r\"> Services MCO <a href=\"lits_service.php?ID_hopital=$_GET[ID_hopital]&type_s=0&ok=Envoyer\">  [voir]  </a></LEGEND>");
print("<Table cellspacing=\"2\" class=\"time\" width=\"100%\">");
	TblDebutLigne();
	//-------------------------- Orthopédie -----------------------------
		$mot = $string_lang["ORTHOPEDIE"][$langue];
		check("orthopedie",$rub->Hop_Orthopedie,$mot);

	//-------------------------- Neuro-Chirurgie -----------------------------
		$mot = $string_lang["NEUROCHIR"][$langue];
		check("neurochir",$rub->Hop_Neurochir,$mot);

	//-------------------------- Vasculaire -----------------------------
		$mot = $string_lang["CHIR_VASC"][$langue];
		check("chirvasc",$rub->Hop_ChirVasc,$mot);

	//-------------------------- Cardiaque -----------------------------
		$mot = $string_lang["CHIR_CARD"][$langue];
		check("cardiovasc",$rub->Hop_Cardiovasc,$mot);

	//-------------------------- Maxillo-faciale -----------------------------
		$mot = $string_lang["MAXILLO"][$langue];
		check("maxillo",$rub->Hop_Maxillo,$mot);
TblFinLigne();
TblDebutLigne();
	//-------------------------- Thoracique -----------------------------
		$mot = $string_lang["CHIR_THO"][$langue];
		check("chirtho",$rub->Hop_ChirTho,$mot);
	//-------------------------- Infantile -----------------------------
		$mot = $string_lang["CHIR_INF"][$langue];
		check("chirinf",$rub->Hop_ChirInf,$mot);

	//-------------------------- ORL -----------------------------
		$mot = $string_lang["ORL"][$langue];
		check("orl",$rub->Hop_Orl,$mot);

	//-------------------------- Ophtalmo -----------------------------
		$mot = $string_lang["OPHTALMO"][$langue];
		check("ophtalmo",$rub->Hop_Ophtalmo,$mot);
	//-------------------------- Ophtalmo -----------------------------
		$mot = $string_lang["MAIN"][$langue];
		check("mains",$rub->Hop_main,$mot);
TblFinLigne();
TblDebutLigne();
	//-------------------------- Réanimation adulte -----------------------------
		$mot = $string_lang["REA"][$langue];
		check("rea",$rub->Hop_Rea,$mot);

	//-------------------------- Réanimation pédiatrique -----------------------------
		$mot = $string_lang["REA_PED"][$langue];
		check("reaped",$rub->Hop_ReaPed,$mot);

	//-------------------------- Chirurgie Viscérale -----------------------------
		$mot = $string_lang["CHIR_VISC"][$langue];
		check("visceral",$rub->Hop_visceral,$mot);

	//-------------------------- Chirurgie Urologique -----------------------------
		$mot = $string_lang["CHIR_URO"][$langue];
		check("urologie",$rub->Hop_visceral,$mot);
		valider($langue);

	TblFinLigne();
TblFin();
print("</FIELDSET>");

print("<a href=\"plan_blanc.php?hopID=$_GET[ID_hopital]\">Plan Blanc</a>");
?>
	<select name="pblanc" size="1">
		<option value="0" <?php if($rub->niveau_planBlanc==0)echo 'selected';?> >indéterminé</option>
		<option value="1" <?php if($rub->niveau_planBlanc==1)echo 'selected';?> >établissement de première ligne</option>
		<option value="2" <?php if($rub->niveau_planBlanc==2)echo 'selected';?> >établissement de recours</option>
		<option value="3" <?php if($rub->niveau_planBlanc==3)echo 'selected';?> >établissement de repli</option>
	</select>

<?php
//===========================================================================================================
print("<HR>");
print("</FORM>");
print("</BODY>");
print("</html>");
?>
