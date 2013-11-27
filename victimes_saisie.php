<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
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
//		
//----------------------------------------- SAGEC ---------------------------------------------
//
//	programme: 		victimes_saisie.php
//	date de création: 	18/08/2003
//	auteur:			jcb
//	description:
//	version:			1.3
//	maj le:			10/04/2004
//
//---------------------------------------------------------------------------------------------
/**
* Formulaire de saisie d'un patient
* 
* Cette page est normalement appelée par la page 'nouveau.php'qui transmet la variable $identifiant
* $identifiant correspond à l'identifiant (code barre) de la victime.
* La méthode 'chercheID'utilise cette variable pour déterminer si la victime a déjà été enregistrée.
* Si oui, la vriable $victime contient toutes les données connues de la victime eton se met en mode
* mise à jour(UPDATE). Dans le cas contraire, il s'agit une nouvelle victime (INSERT).
* La variable $member_id est une variable globale mémorisée dans les variables de session.
*/
session_start();
if(! $_SESSION['auto_sagec'])header("Location:logout.php");
$langue = $_SESSION['langue'];
$member_id = $_SESSION['member_id'];
$backPathToRoot = ""; 
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require($backPathToRoot."en_tete.php");
require($backPathToRoot."utilitairesHTML.php");
require($backPathToRoot."pma_constantes.php");
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");
require($backPathToRoot."interrogeBD.php");
require($backPathToRoot."utilitaires/table.php");
require($backPathToRoot."utilitaires/globals_string_lang.php");
require($backPathToRoot."date.php");
include_once($backPathToRoot."login/init_security.php");

print("<HTML><HEAD>");
print("<TITLE>SAISIE</TITLE>");

?>
<head>
	<title>formulaire zones</title>
	<meta http-equiv="content-type" content="""text/ht; charset=ISO-8859-1" >
	<!--<LINK REL=stylesheet HREF="pma.css" TYPE ="text/css"/>-->
	<link href="css/formstyle.css" rel="stylesheet" type="text/css" />
	<!--<link href="css/div.css" rel="stylesheet" type="text/css" />-->
	<link rel="shortcut icon" href="images/sagec67.ico" />
<SCRIPT>
function addToList(listField, newText, newValue) {
   if ( ( newValue == "" ) || ( newText == "" ) ) {
      alert("You cannot add blank values!");
   } else {
      var len = listField.length++; // Increase the size of list and return the size
      listField.options[len].value = newValue;
      listField.options[len].text = newText;
      listField.selectedIndex = len; // Highlight the one just entered (shows the user that it was entered)
   } // Ends the check to see if the value entered on the form is empty
}

function Choix(form)
{
	/*
	i = form.hopital.selectedIndex;
	if (i == 0) {
  	return;
  	}
	switch (i) {
	case 1 : var txt = new Array ('Matériel','Poissons','Sécurité'); break;
	case 2 : var txt = new Array ('Radioactivité','Information','Mesures'); break;
	case 3 : var txt = new Array ('Philosophie','Psychologie','Humour'); break;
	}
	//form.hopital.selectedIndex = 0;
	for (i=0;i<3;i++) {
  	//form.Page.service[i+1].text=txt[i];
  	addToList(form.service, txt[i], i+1);
  	}*/
	//document.saisie.checked_arrive.value = checked;
	document.saisie.submit();
}
function bgcolor(n)
{
	var color = new Array("snow","#ff000f","#ffff00","#fffafa","#40e0d0","#a9a9a9","#7fff00","#ff000f","#ffff00","#7fff00","#7fff00");
	document.all.table2.bgColor = color[n.value];
	//document.write(n.value);
}

</SCRIPT>
</head>

<?php
$back = $_REQUEST['back'];

print("<BODY>");
print("<FORM id=\"\" NAME=\"saisie\" ACTION=\"enregistre_victime.php\" enctype=\"multipart/form-data\" METHOD=\"POST\">");
print("<input type=\"hidden\" name=\"back\" value=\"$back\">");

// affichage du menu d'entête
entete($member_id,$langue);
// heure courante
$timestamp = date("Y-m-j H:i:s");// format compatible mysql
print("<INPUT TYPE=\"HIDDEN\" NAME=\"heure_courante\" VALUE=\"$timestamp\">");
TblDebut(0,"100%","2","2",A3);
TblDebutLigne();
print("<TD>".DateHeure()."</TD>");

/**
  *	Est-ce que la victime est connue ?
  */
$identifiant = Security::esc2Db(strtoupper($_REQUEST[identifiant]));
$gravite = 11;
// est-ce un bracelet civic ?
if(substr($identifiant,0,4)=="3367")
{
	$g = substr($identifiant,7,1);
	switch($g)
	{
			case 1: $gravite = 1; break;
			case 2: $gravite = 2; break;
			case 3: $gravite = 6; break;
			case 4: $gravite = 5; break;
	}
	$code = "F67 ";
	if(substr($$identifiant,4,3)=="010")
			$code .= "SM ";
	else
			$code .= "SD ";
	$code .= substr($identifiant,7,5);
		
	$identifiant = $code;
}

$victime = chercheID($identifiant,$_SESSION['evenement'],$connexion);

if($victime)
{
	$database = "UPDATE";
	print("<INPUT TYPE=\"HIDDEN\" NAME=\"image2\" VALUE=\"$victime->photo\">");
	print("<INPUT TYPE=\"HIDDEN\" NAME=\"victime\" VALUE=\"$victime->no_ordre\">");
	print("<INPUT TYPE=\"HIDDEN\" NAME=\"victimeID\" VALUE=\"$victime->victime_ID\">");
	$hopital = $victime->Hop_ID;
}
else
{
// Création d'un dossier provisoire à partir de l'identifiant 9/08/2008 
	$date = uDateTime2MySql(time());
	$victime->no_ordre = $identifiant;
	$victime->gravite = $gravite;
	$victime->conta_N = '1';
	$victime->conta_R = '1';
	$victime->conta_C = '1';
	$database = "UPDATE";
	$requete = "INSERT INTO victime (victime_ID,no_ordre,conta_N,conta_B,conta_C,pays_ID,gravite,evenement_ID,org_createur_ID,heure_creation) 
					VALUES ('','$victime->no_ordre',1,1,1,999,'$victime->gravite','$_SESSION[evenement]','$_SESSION[organisation]','$date')";
	$resultat = ExecRequete($requete,$connexion);
	$victime->victime_ID = mysql_insert_id();
	print("<INPUT TYPE=\"HIDDEN\" NAME=\"victimeID\" VALUE=\"$victime->victime_ID\">");
	print("<INPUT TYPE=\"HIDDEN\" NAME=\"victime\" VALUE=\"$victime->no_ordre\">");
	print("<INPUT TYPE=\"HIDDEN\" NAME=\"image2\" VALUE=\"$victime->photo\">");
	TblCellule("<B>SAISIE VICTIME</B>");
}

//=========================== LOCALISATION =======================================================
print("<TD>");
	//print($string_lang['POSTE_SAISIE'][$langue]);
	print("Localisation victime ");
	SelectStructureTemporaire($connexion,$_SESSION['localisation_poste'],$langue);//localisation_type
print("<TD>");

//=========================== POSTE DE SAISIE =====================================================
print("<TD>");
	//print($string_lang['POSTE_SAISIE'][$langue]);
	print($string_lang['POSTE_SAISIE'][$langue]);
	SelectStatus($connexion,$_SESSION['poste_saisie'],$langue);// retourne status_type
print("<TD>");
//=========================== suivant / précédant =================================================
if($_GET['suite']!='stop+')
	print("<td><a href=\"dossier_suivant.php?next=suivant&ordre=$victime->no_ordre\">suivant</a></td>");
if($_GET['suite']!='stop-')
	print("<td><a href=\"dossier_suivant.php?next=precedant&ordre=$victime->no_ordre\">précédant</a></td>");
print("<td><a href=\"dossier_suivant.php?next=first\">first</a></td>");
print("<td><a href=\"dossier_suivant.php?next=last\">last</a></td>");

//TblCellule("<INPUT NAME=\"reinit\" TYPE=\"reset\" VALUE=\"Réinitialiser\">");
$valider = strtoupper($string_lang['VALIDER'][$langue]);
TblCellule("<INPUT NAME=\"ok\" TYPE=\"submit\" VALUE=\"$valider\">");

TblFinLigne();
TblFin();
	
// la variable caché victimes (cf infra)est utilisée par Enregistre_victime.php
print("<INPUT TYPE=\"HIDDEN\" NAME=\"victimes\" VALUE='$victime->victime_ID'> ");
print("<INPUT TYPE=\"HIDDEN\" NAME=\"database\" VALUE='$database'> ");
print("<INPUT TYPE=\"HIDDEN\" NAME=\"hopital\" VALUE='$hopital'> ");
print("<INPUT TYPE=\"HIDDEN\" NAME=\"image\" VALUE='$victime->photo'> ");

print("<hr>");// barre horizontale
$_style = "A0";
//TblDebut(0,"100%","2","2",$_style);
//$color = array("snow","#ff000f","#ffff00","#fffafa","#40e0d0","#a9a9a9","#7fff00","#ff000f","#ffff00","#7fff00","#7fff00");
//$c = $color[$victime->gravite];

$requete = "SELECT gravite_couleur FROM gravite WHERE gravite_ID = '$victime->gravite'";
$resultat = ExecRequete($requete,$connexion);
$rub=mysql_fetch_array($resultat);
$c = "#".$rub[gravite_couleur];

print("<TABLE ID=\"table2\" bgcolor=\"$c\" width=\"100%\">");// BGCOLOR=\"palegreen\"
	TblDebutLigne();
		TblCellule($string_lang['IDENTIFIANT_NO'][$langue]);
		TblCellule("<INPUT NAME=\"no_identification\" TYPE=\"text\" VALUE=\"$victime->no_ordre\" ");
		TblCellule($string_lang['GRAVITE'][$langue]);
		print("<TD>");
			//Select("gravite",$item_gravite,$victime->gravite,"bgcolor(gravite)");//print("onMouseover=\"bgcolor(1)\"");
			select_gravite($connexion,$victime->gravite,$langue,"bgcolor(gravite)");
		print("</TD>");
		//TblCellule(" ");
		TblCellule($string_lang['HOPITAL'][$langue]);
		print("<TD>");
			//select_hopital($connexion,$victime->Hop_ID,$langue,"Choix(this.form)");//
			// n'affiche que les hôpitaux présents dans la table hopital_visible 
			$listeID = 1;//NE PAS MODIFIER 
			select_hopital_visible($connexion,$victime->Hop_ID,$langue,$listeID,"Choix(this.form)");//
		print("</TD>");
		print("<TD>");
			select_service2($connexion,$hopital,$victime->service_ID);
		print("</TD>");
		//TblCellule("<INPUT NAME=\"ok\" TYPE=\"submit\" VALUE=\"Valider\">");
	TblFinLigne();
	TblDebutLigne();
		TblCellule($string_lang['SEXE'][$langue]);
		print("<TD>");
			Select("sexe",$item_sexe,$victime->sexe);
		print("</TD>");
		TblCellule($string_lang['AGE'][$langue]);
		TblCellule("<INPUT NAME=\"age1\" TYPE=\"text\" SIZE=\"10\" VALUE=\"$victime->age1\">");
		TblCellule(" ans et/ou ");
		print("<TD>");
		$adulte = $string_lang['ADULTE'][$langue];
		$ado = $string_lang['ADO'][$langue];
		$enfant = $string_lang['ENFANT'][$langue];
		print("<SELECT NAME=\"age2\">");
		print("<OPTION VALUE=\"Adulte\" SELECTED>$adulte");
		print("<OPTION VALUE=\"Adolescent\">$ado");
		print("<OPTION VALUE=\"Enfant\">$enfant");
		print("</SELECT>");
		print("</TD>");
		TblCellule("<a HREF=\"lits_synoptique.php?back=Victimes_saisie.php\">SYNOPTIQUE / LITS <A> ");
		//TblCellule("<INPUT NAME=\"reinit\" TYPE=\"reset\" VALUE=\"Réinitialiser\">");
	TblFinLigne();
	TblDebutLigne();
		TblCellule($string_lang['DECONTAMINE'][$langue]);
		$oui = $string_lang['OUI'][$langue];
		$non = $string_lang['NON'][$langue];
		TblCellule("<SELECT NAME=\"deconta\"><OPTION VALUE=\"O\" SELECTED>$oui <OPTION VALUE=\"N\">$non </SELECT>");
		TblCellule($string_lang['DEVENIR'][$langue]);
		print("<TD>");
		// le type de médicalisation est contenu dans $devenir
		select_medicalisation($connexion,$victime->medicalisation_ID,$langue,"");
		print("</TD>");

//----------------------------------- VECTEUR de transport -------------------------------------------------
		TblCellule($string_lang['VECTEURS'][$langue]);
		print("<TD>");
		SelectVecteurDisponible($connexion,$victime->vecteur_ID);// vecteur_disponible_ID
		print("</TD>");
		if($victime->vecteur_ID)
		{
			$requete="SELECT Vec_Nom FROM vecteur WHERE Vec_ID = '$victime->vecteur_ID'";
			$resultat2 = ExecRequete($requete,$connexion);
			$rub2=mysql_fetch_array($resultat2);
			print("<td>$rub2[Vec_Nom]</td>");
		}
//------------------------------------ nationalité -----------------------------------------------------
		print("<TD>");
		print("  Pays ");
		$requete = "SELECT pays_ID,pays_nom FROM pays ORDER BY pays_nom";
		$result = ExecRequete($requete,$connexion);
		print("<SELECT NAME =\"nationalite\" size=\"1\">");
		print("<OPTION VALUE=\"0\">inconnu ");
		while($pays=mysql_fetch_array($result))
		{
			print("<OPTION VALUE=\"$pays[pays_ID]\" ");
			if($victime->pays_ID == $pays['pays_ID']) print(" SELECTED");
			print("> $pays[pays_nom] </OPTION> \n");
		}
		@mysql_free_result($result);
		print("</SELECT>\n");
		print("</TD>");
	TblFinLigne();
TblFin();
print("<hr>");// barre horizontale
//----------------------------------- Logos spéciaux -------------------------------------------------
TblDebut(0,"100%","2","2",A2);
TblDebutLigne();
print("<TD rowspan=\"2\">");
if($victime->conta_N == 1) $image = "photos/radio1.jpeg";
	else $image = "photos/radio.jpeg";
//$image = "photos/atomanim.gif";
print("<img src=\"$image\" alt=\"radio\" height=\"45\" width=\"50\"align=\"middle\" border=\"0\">");
print("</TD>");
TblCellule("Contamination radiologique");

if($victime->conta_B == 1) $image = "photos/biotox1.jpeg";
	else $image = "photos/biotox.jpeg";
print("<TD rowspan=\"2\">");
print("<img src=\" $image\" alt=\"bio\" height=\"45\" width=\"50\"align=\"middle\" border=\"0\">");
print("</TD>");
TblCellule("Contamination biologique");

if($victime->conta_C == 1) $image = "photos/biotox1.jpeg";
	else $image = "photos/biotox.jpeg";
print("<TD rowspan=\"2\">");
print("<img src=\"$image\" alt=\"chim\" height=\"45\" width=\"50\"align=\"middle\" border=\"0\">");
print("</TD>");
TblCellule("Contamination chimique");
TblFinLigne();

TblDebutLigne();
	print("<TD>");select_contamination($connexion,$victime->conta_N,$langue,"N");print("</TD>");
	print("<TD>");select_contamination($connexion,$victime->conta_B,$langue,"B");print("</TD>");
	print("<TD>");select_contamination($connexion,$victime->conta_C,$langue,"C");print("</TD>");
TblFinLigne();
TblFin();
//----------------------------------- Dossier médical -------------------------------------------------
print("<hr>");// barre horizontale
TblDebut(0,"100%","2","2",A1);
	TblDebutLigne();
		TblCellule($string_lang['NOM'][$langue]);	
		TblCellule("<input name=\"nom\" type=\"text\" size=\"27\" VALUE=\"$victime->nom\" ");
		TblCellule($string_lang['PRENOM'][$langue]);
		TblCellule("<input name=\"prenom\" type=\"text\" size=\"27\" VALUE=\"$victime->prenom\" ");
		TblCellule($string_lang['NE_LE'][$langue]);
		TblCellule("<INPUT NAME=\"naissance\" TYPE=\"text\" SIZE=\"15\" VALUE=\"$victime->naissance\"> ");
	TblFinLigne();
	TblDebutLigne();
		$mot = $string_lang['ADRESSE'][$langue];
		TblCellule($mot." 1");
		TblCellule("<input type=\"text\" name=\"adresse1\" size=\"27\" VALUE=\"$victime->adresse1\">");
		TblCellule($mot." 2");
		TblCellule("<input type=\"text\" name=\"adresse2\" size=\"27\" VALUE=\"$victime->adresse2\">");
		TblCellule($string_lang['VILLE'][$langue]);
		TblCellule("<input type=\"text\" name=\"ville\" size=\"27\" VALUE=\"$victime->ville\">");
	TblFinLigne();
TblFin();

$signes = $string_lang['SIGNES_PARTICULIERS'][$langue];
$source_image = $victime->photo;
$lesions = $string_lang['LESIONS'][$langue];
$traitements = $string_lang['TRAITEMENTS'][$langue];

/**
  * recherche des examens les plus récents  
  */ 
	$resultat_bio = Array();
  	$requete = "SELECT date,constante_abr,constante_ID,resultat
  					FROM dm_constantes2,dm_constantes_nom
  					WHERE  (exam_ID,date)
  					IN (SELECT exam_ID,MAX(date)FROM dm_constantes2 GROUP BY exam_ID)
  					AND exam_ID = constante_ID
  					";
  					
  $resultat = ExecRequete($requete,$connexion);
  while($bio = mysql_fetch_array($resultat))
  {
  	//echo $bio['date']."  ".$bio['constante_abr']."  ".$bio['constante_ID']."  ".$bio['resultat']."<br>";
  	$resultat_bio[$bio['constante_ID']] = $bio['resultat'];
  }
  					
TblDebut(0,"100%","2","2",A2);
	TblDebutLigne();
		?>
		<td>
			<fieldset id="field1">
			<legend><?php echo $signes;?></legend>
				<!--<label for="rem" title="signes particuliers">Remarque:</label> -->
				<textarea name="signes" id="rem" rows="4" cols="35"><?php echo $victime->signes; ?></textarea>
			</fieldset>
		</td>
		
		<td>
			<fieldset id="field2">
			<legend><?php echo 'Constantes';?></legend>
				<table>
					<tr>
						<td>PAS </td>
						<td><input type="text" name="pas" value="<?php echo $resultat_bio[2];?>">mmHg</td>
						<td>PAD </td>
						<td><input type="text" name="pad" value="<?php echo $resultat_bio[3];?>">mmHg</td>
					</tr>
					<tr>
						<td>FC </td>
						<td><input type="text" name="fc" value="<?php echo $resultat_bio[1];?>"></td>
						<td>FR </td>
						<td><input type="text" name="fr" value="<?php echo $resultat_bio[4];?>"></td>
					</tr>
					<tr>
						<td>CGS </td>
						<td<input type="text" name="gcs" value="<?php echo $resultat_bio[9];?>"></td>
						<td>SAT </td>
						<td><input type="text" name="sat" value="<?php echo $resultat_bio[5];?>">%</td>
						<td>EVA </td>
						<td width="10px"><input type="text" name="eva" value="<?php echo $resultat_bio[11];?>"></td>
					</tr>
				</table>
			</fieldset>
		</td>
		
		<td>
			<fieldset id="field2">
			<legend><?php echo 'Photographie';?></legend>
				<img src="<?php echo $source_image;?>" alt="Photographie" height="72" width="72" align="middle" border="0">
				<input type="file" name="photo_victime" size="10" onchange="Choix(this.form)">
		</td>
	<tr>
		<td>
			<fieldset id="field1">
			<legend><?php echo 'Saisie rapide';?></legend>
				<!--<label for="rem" title="signes particuliers">Remarque:</label> -->
				<textarea name="ardoise" id="rem" rows="4" cols="35"><?php echo""; ?><?php echo $victime->ardoise;?></textarea>
			</fieldset>
		</td>
		<td>
			<fieldset id="field1">
			<legend><?php echo $lesions;?></legend>
				<!--<label for="rem" title="signes particuliers">Remarque:</label> -->
				<textarea name="lesions" id="rem" rows="4" cols="70"><?php echo $victime->lesions;?></textarea>
			</fieldset>
		</td>
		<td>
			<fieldset id="field1">
			<legend><?php echo $traitements;?></legend>
				<!--<label for="rem" title="signes particuliers">Remarque:</label> -->
				<textarea name="traitement" id="rem" rows="4" cols="35"><?php echo $victime->traitement;?></textarea>
			</fieldset>
		</td>
	</tr>
		<?php
/**		
TblCellule("Photo");
		$source_image = $victime->photo;
		TblCellule("<img src=\"$source_image\" alt=\"Photographie\" height=\"72\" width=\"72\" align=\"middle\" border=\"0\">
		<input type=\"file\" name=\"photo_victime\" size=\"10\" onchange=\"Choix(this.form)\">");
		//$photo = $image;
	*/	

		$back = "victimes_saisie.php?identifiant=".$identifiant;
		print("<td><a href=\"dossier/dossier_frameset.php?id=$victime->victime_ID&back=$back\">Dossier médical complet</a></td>");
	TblFinLigne();

	TblDebutLigne();
		TblCellule("Heure de création:");
		TblCellule($victime->heure_creation);
		TblCellule("dernière mise à jour:");
		TblCellule($victime->heure_maj);
	TblFinLigne();
TblFin();

print("Evolution.<BR>");
TblDebut(0,"100%","2","2",A2);
	TblDebutLigne();
		TblCellule("Heure de modification");
		TblCellule("Localisation");
		TblCellule("Status");
		TblCellule("Gravité");
	TblFinLigne();

$requete= "SELECT heure,victime_status_nom,gravite_nom,ts_nom
	FROM victime_gravite,victime_status,gravite,temp_structure
	WHERE victime_ID = '$victime->victime_ID'
	AND  victime_gravite.gravite_ID = gravite.gravite_ID
	AND victime_gravite.localisation_ID = ts_ID
	AND victime_gravite.status_ID = victime_status.victime_status_ID
	ORDER BY heure
	";

$resultat = ExecRequete($requete,$connexion);
while($rub=mysql_fetch_array($resultat))
{
	TblDebutLigne();
		TblCellule($rub[heure]);
		TblCellule($rub[ts_nom]);
		TblCellule($rub[victime_status_nom]);
		TblCellule($rub[gravite_nom]);
	TblFinLigne();
}
TblFin();


print("</FORM>");
print("</BODY>");		
print("</HTML>");
?>

