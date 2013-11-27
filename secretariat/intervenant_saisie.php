<?php
/**
 *	intervenant_saisie.php
 */
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$backPathToRoot = "../";
$langue = $_SESSION['langue'];
$member_id = $_SESSION['member_id'];
include_once("top.php");
include_once("menu.php");
$path="../";
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require($backPathToRoot."dbConnection.php");
$connexion = connexion(NOM,PASSE,BASE,SERVEUR);

include($backPathToRoot."utilitaires/table.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
include($backPathToRoot."utilitairesHTML.php");
include($backPathToRoot."date.php");
include($backPathToRoot."adresse_ajout.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="ent="text; charset=ISO-8859-1" >
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Gestion des intervenants</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<!--
	<LINK REL=stylesheet HREF="/pma.css" TYPE ="text/css">
	<LINK REL=stylesheet HREF="../../css/impression2.css" TYPE ="print/css">
	-->
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
	<script  type="text/javascript" src="../ajax/jquery-courant.js"></script>
	
	 <style type="text/css">
      #coldroite
        {
        background: #F5F4F4;
        float: right;
        right:50px;
        top:150px;
        width:300px;
        heigth:300px;
        }
    </style>
    
    <script>
   	function Choix(form){
			document.Intervenants.submit();
		}
    
function newLangue(id)
{
	adresse = "../langue/langue_saisie.php?personne_id="+id;
	fenLangue=window.open(adresse,"langue","width=260,height=150,scrolling=no,toolbar=no,menubar=no,location=center,directories=no,status=no");
}
function ferme()
{
	if(typeof(fenLangue)=="object" && fenLangue.closed==false)
		fenLangue.close();
}
/*
	alerte_supprimer
	no 		n� de l'enregistrement � supprimer
	id 		param�tres pour le retour
	back 	adresse de retour
	param 	nom de la variable pour le retour. par ex. pour un intervenant on aura param = personne et
			id = personne_ID
*/
function alerte_supprimer(no,id,back,param)
{
	if(confirm("Voulez-vous vraiment supprimer cet enregistrement ?"))
	{
		location.replace("../contact/contact_supprime.php?enregistrement_ID=" + no + "&back="+ back +"&param="+param+"&id="+id);
		//"&back=../intervenant_saisie.php&personne="
	}
}
/**
	newContact()
	id identifiant de l'objet auquel se rattache le contact
	type op�ration � effectuer: cr�ation=0, modifier=1, supprimer=2
	nature caract�ristique de l'objet auquel se rattache le contact: personne, organisme, service, etc.
	enregistrement_id n�de l'enregistrement dans le fichier contact
*/
function newContact(id,type,nature,enregistrement_id)//type= 0 nouveau 1 = modifier 2 = supprimer
{
	adresse = "../contact/contact_saisie.php?personne_id="+id+"&type="+type+"&enregistrement="+enregistrement_id+"&nature="+nature;
	fenVaccin=window.open(adresse,"contacts","width=700,height=250,scrolling=no,toolbar=no,menubar=no,location=center,directories=no,status=no");
}
function newVaccination(id,type,nature,enregistrement_id)//type= 0 nouveau 1 = modifier 2 = supprimer
{
	adresse = "../contact/vaccin_saisie.php?personne_id="+id+"&type="+type+"&enregistrement="+enregistrement_id+"&nature="+nature;
fenContact=window.open(adresse,"contacts","width=700,height=250,scrolling=no,toolbar=no,menubar=no,location=center,directories=no,status=no");
}
	</script>
    
</head>

<body onUnload = "ferme();" onload="ferme();">

<FORM name ="Intervenants" ACTION="intervenant_enregistre.php"enctype="multipart/form-data" METHOD="post">

<?php
if($_REQUEST['personnelID'] != 0)
{
	$intervenant = ChercheIntervenant($_REQUEST['personnelID'],$connexion);
	//print_r($intervenant);
	$adresse_ID = $intervenant->adresse_ID;
}
// m�morisation dans un champ cach� de $ttintervenant pour se rappeler s'il s'agit d'une MAJ
// ou d'une cr�ation (=0)
print("<INPUT TYPE=\"HIDDEN\" NAME=\"maj\" VALUE=\"$_REQUEST[personnelID]\">");
print("<INPUT TYPE=\"HIDDEN\" NAME=\"adresseID\" VALUE=\"$adresse_ID\">");
print("<INPUT TYPE=\"HIDDEN\" NAME=\"back\" VALUE=\"intervenant_saisie.php\">");

// position: absolute;
?>
<div id="div2">

	<div id ="coldroite">
	<fieldset id="field1">
	<legend>Photographie</legend>
	<p>
		<?php ?>
			Photo:
			<input type="file" name="photo_victime" size="10" onchange="Choix(this.form)">
			<?php
			//$intervenant = 124;
			$source_image = $backPathToRoot.$intervenant->photo;
			if($source_image !=''){
				//list($width, $height, $type, $attr) = getimagesize($source_image."jpg");
				$h = 220;
				if($height != 0)
					$w = $h*$width/$height;
				print("<img src=\"$source_image\" alt=\"$source_image\" height=\"$h\" width=\"$w\" align=\"middle\" border=\"0\">");
			}
			?>
		</p>
	</fieldset>
</div>


	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend>Etat Civil</legend>
		<p>
			<label for="actif" title="personnel encore pr�sent ?">Actif:</label>
			<?php setOuiNon($connexion,$intervenant->visible,$langue);?>
		</p>
		<p>
		<label for="civil" title="civilit�: mr, mme,etc.">civilit�:</label>
			<?php SelectCivilite($connexion,$intervenant->civilite_ID,"0",$langue);?>
		</p>
		<p>
			<label for="nom" title="nom">Nom:</label>
			<input type="text" name="nom" id="nom" title="nom" value="<? echo $intervenant->Pers_Nom;?>" size="50" onFocus="_select('nom');" onBlur="deselect('nom');"/>
		</p>
		<p>
			<label for="prenom" title="prenom">Pr�nom:</label>
			<input type="text" name="prenom" id="prenom" title="prenom" value="<? echo $intervenant->Pers_Prenom;?>" size="50" onFocus="_select('prenom');" onBlur="deselect('prenom');"/>
		</p>
		<p>
			<label for="ser" title="service">Profession:</label>
			<?php SelectMetier($connexion,$intervenant->perso_cat_ID,$langue); ?> <!--retour  -->
		</p>
		<p>
			<label for="org" title="org">Organisme:</label>
			<?php SelectOrganisme($connexion,$intervenant->org_ID,$langue,"Choix(this)");?> <!--retour orgID -->
		</p>
		<p>
			<label for="ser" title="service">Service:</label>
			<?php select_service($connexion,$intervenant->org_ID,$intervenant->service_ID); ?> <!--retour $the_service -->
		</p>
		<p>
			<label for="rpps" title="rpps">N� RPPS:</label>
			<input type="text" name="rpps" id="rpps" title="rpps" value="<? echo $intervenant->rpps;?>" size="50" onFocus="_select('rpps');" onBlur="deselect('rpps');"/>
		</p>
		<p>
			<label for="delai_route" title="delai_route">D�lai de route:</label>
			<input type="text" name="delai_route" id="delai_route" title="delai_route" value="<? echo $intervenant->delai_route;?>" size="50" onFocus="_select('delai_route');" onBlur="deselect('delai_route');"/>
			<a href="fiche.php">imprimer la fiche</a>
		</p>
	</fieldset>
	
	<br>
	<?php  get_adresse($intervenant->adresse_ID,$ville_ou_commune='V',$classe='') ?>
	<br>
	
	
	
	<fieldset id="field1">
		<legend> Commentaires </legend>
		<p>
			<label for="rem" title="rem">Remarque:</label>
			<textarea name="rem" id="rem" rows="2" cols="60"><?php echo $rep['remarque'];?></textarea>
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend>Contacts</legend>
		<p>
			<table width="100%" border="0" cellspacing="0" cellpadding="5" class="Style24" bgcolor="#ffffcc">
			<tr>
				<th> Contacts </th>	
				<th><a href="javascript:newContact(<?php echo $_REQUEST[personnelID];?>,0,1);">Ajouter un nouveau contact</a></th>
			</tr>
			</table>
			
			<table  width="50%" border="1" cellspacing="0" cellpadding="0" class="Style22">
			<tr>
				<th><B>Type</B></th>
				<th><B>Localisation</B></th>
				<th><B>Valeur</B></th>
				<th><B>&nbsp;</B></th>
				<th><B>&nbsp;</B></th>
			</tr>
		<?php
		$requete="SELECT type_contact_nom,valeur,confidentialite_ID,contact_lieu,contact_ID
			FROM contact,type_contact
			WHERE identifiant_contact = '$_REQUEST[personnelID]'
			AND nature_contact_ID = '1'
			AND contact.type_contact_ID = type_contact.type_contact_ID
			";
		$resultat = ExecRequete($requete,$connexion);
		while($rub=mysql_fetch_array($resultat))
		{
			print("<TR>");
			TblCellule("<div align=\"left\" class=\"Style23\"> $rub[0]");
			if($rub[contact_lieu]==1)
				TblCellule("<div align=\"left\" class=\"Style23\">domicile");
			else
				TblCellule("<div align=\"left\" class=\"Style23\">travail");
			if($rub['confidentialite_ID'] == 1)
				TblCellule("<div align=\"left\" class=\"Style23\"> $rub[valeur]");
			else if($rub['confidentialite_ID'] == 2)
				TblCellule("<div align=\"center\" class=\"time_r\"> Liste Rouge");
			else
				TblCellule("<div align=\"center\" class=\"time_r\"> Classifi�");//button_drop.png
			//if($rub['confidentialite_ID']==1 && $_SESSION[]!=)
			//{
			TblCellule("<div align=\"center\" class=\"time_r\"><A href=javascript:newContact($_GET[personnelID],1,1,$rub[contact_ID]);><img src=\"../images/button_edit.png\" Title=\"modifier\" border=\"0\"></a>");

			$mot1="'../secretariat/intervenant_saisie.php'";
			$mot2="'personnelID'";
			TblCellule("<div align=\"center\" class=\"time_r\"><A href=\"javascript:alerte_supprimer($rub[contact_ID],$_GET[personnelID],$mot1,$mot2)\"><img src=\"../images/button_drop.png\" Title=\"supprimer\" border=\"0\"></a>");
			//}
			print("</TR>");
		}
		?>
		</table>
		</p>
	</fieldset>
		
	<fieldset id="field1">
		<legend>Passeport</legend>
		<p>
			<label for="passport_no" title="no du passeport">N�:</label>
			<input type="text" name="passport_no" id="passport_no" title="passport_no" value="<? echo $intervenant->passport_no;?>" size="50" onFocus="_select('passport_no');" onBlur="deselect('passport_no');"/>
		</p>
		<p>
			<label for="passport_qui" title="autorit� de d�livrance">D�livr� par:</label>
			<input type="text" name="passport_qui" id="passport_qui" title="passport_qui" value="<? echo $intervenant->passport_qui;?>" size="50" onFocus="_select('passport_qui');" onBlur="deselect('passport_qui');"/>
		</p>
		<p>
			<label for="date_u" title="date de d�livrance">Le:</label>
			<input type="text" name="date_u" id="date_u" title="date_u" value="<? echo uDate2French($intervenant->passport_date);?>" size="50" onFocus="_select('date_u');" onBlur="deselect('date_u');"/>
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend>Langues parl�es/lues</legend>
		<p>
		<?php
		print("<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\" class=\"Style24\" bgcolor=\"#ffffcc\">");
	print("<tr>");
		print("<TD> Langues parl�es </td>");
		TblCellule("<A HREF= javascript:newLangue($_REQUEST[personnelID]);>nouvelle</A>");
		/**
		print("<TD>Passeport</td>");
		print("<TD>n� <input type \"text\" name=\"passport_no\" value=\"$intervenant->passport_no\"></td>");
		$date_fr = uDate2French($intervenant->passport_date); 
		print("<TD>d�livr� le <input type \"text\" name=\"passport_date\" value=\"$date_fr\"></td>");
		print("<TD>par <input type \"text\" name=\"passport_qui\" value=\"$intervenant->passport_qui\"></td>");
		*/
	print("</tr>");
print("</table>");
print("<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\" class=\"Style22\">");
$requete = "SELECT langue_nom,langue.langue_ID
			FROM langue, langue_parlee
			WHERE Pers_ID='$_REQUEST[personnelID]'
			AND langue.langue_ID = langue_parlee.langue_ID";
		$resultat = ExecRequete($requete,$connexion);
		while($rub=mysql_fetch_array($resultat))
		{
			TblDebutLigne();
			print("<td><A HREF=\"langue/langue_supprime.php?langue=$rub[langue_ID]&personne=$_GET[personnelID]\">
			<img src=\"../images/button_drop.png\" Title=\"supprimer\" border=\"0\"></A></td>");
			TblCellule("<div align=\"left\" class=\"Style23\"> $rub[langue_nom]");
			TblFinLigne();
		}
TblFin();
?>
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend>Vaccins</legend>
		<p>
		<?php
		print("<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\" class=\"Style24\" bgcolor=\"#ffffcc\">");
	print("<tr>");
		print("<TD>Vaccinations</td>");
		TblCellule("<A HREF= javascript:newVaccination($_REQUEST[personnelID],0,1);>nouvelle</A>");
	print("</tr>");
print("</table>");

print("<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\" class=\"Style22\">");
	print("<TR>");
	print("<TD><B>Type</B></TD>");
	print("<TD><B>date</B></TD>");
	print("<TD><B>dose</B></TD>");
	print("<TD><B>nom</B></TD>");
	print("<TD><B>&nbsp;</B></TD>");
	print("<TD><B>&nbsp;</B></TD>");
	print("</TR>");

$requete="SELECT vaccin_type_nom, vaccination_ID,date,dose,nom
			FROM vaccination, vaccin_type
			WHERE personne_ID = '$_GET[personnelID]'
			AND vaccination.vaccin_type_ID = vaccin_type.vaccin_type_ID
			";
	$resultat = ExecRequete($requete,$connexion);
	while($rub=mysql_fetch_array($resultat))
	{
		print("<TR>");
		TblCellule("<div align=\"left\" class=\"Style23\"> $rub[vaccin_type_nom]");
		$date_fr = uDate2French($rub[date]);
		TblCellule("<div align=\"left\" class=\"Style23\"> $date_fr");
		TblCellule("<div align=\"left\" class=\"Style23\"> $rub[dose]");
		TblCellule("<div align=\"left\" class=\"Style23\"> $rub[nom]");
		//button_drop.png
		//if($rub['confidentialite_ID']==1 && $_SESSION[]!=)
		//{
			TblCellule("<div align=\"center\" class=\"time_r\"><A href=javascript:newVaccination($_GET[personnelID],1,1,$rub[vaccination_ID]);><img src=\"../images/button_edit.png\" Title=\"modifier\" border=\"0\"></a>");

		$mot1="'../intervenant_saisie.php'";
		$mot2="'personnelID'";
			TblCellule("<div align=\"center\" class=\"time_r\"><A href=\"javascript:alerte_supprimer($rub[contact_ID],$_GET[personnelID],$mot1,$mot2)\"><img src=\"../images/button_drop.png\" Title=\"supprimer\" border=\"0\"></a>");
		//}

		print("</TR>");
	}
print("</table>");
		?>
		</p>
	</fieldset>
	
	
	<!-- champ de type BUTTON -->
	<input type="submit" name="ok" id="valider" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
	
</div>
</html>
