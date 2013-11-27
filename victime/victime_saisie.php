<?php
//----------------------------------------- SAGEC -------------------------------
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
//----------------------------------------- SAGEC -------------------------------
//
//	programme: 			victime_saisie.php
//	date de création: 	23/10/2005
//	auteur:				jcb
//	description:		refonte du programme victimes_saisie
//	version:			1.0
//	maj le:				23/10/2005
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
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$backPathToRoot = "../";
if(! $_SESSION['auto_sagec'])header("Location:../logout.php");
$langue = $_SESSION['langue'];
$member_id = $_SESSION['member_id'];
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require $backPathToRoot.'utilitaires/dbConnection.php';
require($backPathToRoot."utilitairesHTML.php");
require($backPathToRoot."date.php");
require("interrogeBD.php");
require($backPathToRoot."en_tete.php");

print("<HTML><HEAD>");
print("<TITLE>SAISIE</TITLE>");
?>
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
		document.saisie.submit();
	}
	function bgcolor(n)
	{
		var color = new Array("snow","#ff000f","#ffff00","#fffafa","#40e0d0","#a9a9a9","#7fff00","#ff000f","#ffff00","#7fff00","#7fff00");
		document.all.table2.bgColor = color[n.value];
	}
</SCRIPT>
<LINK REL=stylesheet TYPE ="text/css" HREF="victime.css" >
<script src="test.js" type="text/javascript"></script>
<script src="../ajax/ajax.js" type="text/javascript"></script>
<script src="../ajax/JSON.js" type="text/javascript"></script>
</HEAD>

<?php
print("<BODY>");
print("<FORM NAME=\"saisie\" ACTION=\"enregistre_victime.php\" enctype=\"multipart/form-data\" METHOD=\"POST\">");
// affichage du menu d'entête
entete($member_id,$langue);
// Est-ce que la victime est connue ?
$victime = array();
$date_actuelle = uDateTime2MySql(time());
$identifiant = Security::esc2Db($_REQUEST['identifiant']);

if(! $identifiant)$identifiant = 123;
$victime = chercheID($identifiant,$connexion);
/*
* la victime a déjà un dossier
*/
if($victime)
{
	$requete = "SELECT gravite_couleur FROM gravite WHERE gravite_ID = '$victime->gravite'";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	$c = "#".$rub[gravite_couleur];
}
/*
*	nouvelle victime
*/
else
{
	$requete = "INSERT INTO victime(victime_ID,no_ordre,heure_creation,heure_maj) VALUES('','$identifiant','$date_actuelle','$date_actuelle')";
	ExecRequete($requete,$connexion);
	$victime->victime_ID = mysql_insert_id();
	$requete="INSERT INTO victime_gravite (victime_ID, gravite_ID,heure) VALUES ('$victime->victime_ID','2','$date_actuelle')";
	ExecRequete($requete,$connexion);
}
print("<INPUT TYPE=\"HIDDEN\" NAME=\"victimeID\" VALUE=\"$victime->victime_ID\">");
print("<INPUT TYPE=\"HIDDEN\" NAME=\"no_identification\" VALUE=\"$identifiant\">");
$victime->no_ordre = $identifiant;

//====================================== table 1 ============================================
print("<table class=\"A3\">");
print("<tr>");
	print("<TD>".DateHeure()."</TD>");
	print("<TD>");
	print($string_lang['POSTE_SAISIE'][$langue]);
		SelectStructureTemporaire($connexion,$victime->localisation_ID,$langue);
	print("</TD>");
	print("<TD>");
	print("secteur ");
		SelectLocalisation($connexion,$victime->localisation_ID,$langue);
	print("</TD>");
	print("<TD>");
	print("status ");
		SelectStatus($connexion,$victime->status_ID,$langue); // retourne status_type 
	print("</TD>");
	$valider = strtoupper($string_lang['VALIDER'][$langue]);
	print("<td><INPUT NAME=\"ok\" TYPE=\"submit\" VALUE=\"$valider\"></td>");
print("</tr>");
print("<table>");

print("<table class=\"A3\">");
print("<tr>");
	print("<td>".$string_lang['IDENTIFIANT_NO'][$langue].":".$victime->no_ordre."</td>");
	//-------------------------------  suivant / précédant  ---------------------------------------------
	print("<td>| ");
	if($_GET['suite']!='stop+')
		print("<a href=\"dossier_suivant.php?next=suivant&ordre=$victime->no_ordre\">suivant</a> | ");
	if($_GET['suite']!='stop-')
		print("<a href=\"dossier_suivant.php?next=precedant&ordre=$victime->no_ordre\">précédant</a> | ");
	print("<a href=\"dossier_suivant.php?next=first\">first</a> | ");
	print("<a href=\"dossier_suivant.php?next=last\">last</a> |");
	print("</td>");
	//----------------------------------------------------------------------------------------------------
	print("<td><a href=\"../pma/MenuTemp_structure.php\">CREER/ACTIVER/DESACTIVER UN POSTE DE SAISIE</a></td>");
print("</tr>");
print("</table>");

//============================================ Table 2 =============================================
print("<table ID=\"table2\" bgcolor=\"$c\" width=\"100%\" font=\"10px\">");
print("<tr>");
	print("<td>".$string_lang['GRAVITE'][$langue]."&nbsp");
		select_gravite($connexion,$victime->gravite,$langue,"bgcolor(gravite)");
		print("</TD>");
	print("<td>".$string_lang['DECONTAMINE'][$langue]);
		$oui = $string_lang['OUI'][$langue];
		$non = $string_lang['NON'][$langue];
		if($victime->deconta=='o')$c1 = "SELECTED"; else $c2 = "SELECTED";
		print(" <SELECT NAME=\"deconta\"><OPTION VALUE=\"o\" $c1>$oui <OPTION VALUE=\"n\" $c2>$non </SELECT></td>");
	print("<TD rowspan=\"2\">");
		if($victime->conta_N == 1) $image = "../photos/radio1.jpeg"; else $image = "../photos/radio.jpeg";
		print("<img src=\"$image\" alt=\"radio\" height=\"23\" width=\"25\"align=\"middle\" border=\"0\">");
		print(" Contamination radiologique");
	print("</TD>");
	print("<TD rowspan=\"2\">");
		if($victime->conta_B == 1) $image = "../photos/biotox.jpeg"; else $image = "../photos/biotox1.jpeg";
		print("<img src=\"$image\" alt=\"radio\" height=\"23\" width=\"25\"align=\"middle\" border=\"0\">");
		print(" Contamination biologique");
	print("</TD>");
	print("<TD rowspan=\"2\">");
		if($victime->conta_C == 1) $image = "../photos/biotox.jpeg"; else $image = "../photos/biotox1.jpeg";
		print("<img src=\"$image\" alt=\"radio\" height=\"23\" width=\"25\"align=\"middle\" border=\"0\"></TD>");
		print("<TD>Contamination chimique</TD>");
print("<tr>");
print("<tr>");
	print("<TD>&nbsp;</TD>");
	print("<TD>&nbsp;</TD>");
	print("<TD>");select_contamination($connexion,$victime->conta_N,$langue,"N");print("</TD>");
	print("<TD>");select_contamination($connexion,$victime->conta_B,$langue,"B");print("</TD>");
	print("<TD>");select_contamination($connexion,$victime->conta_C,$langue,"C");print("</TD>");
print("</tr>");
print("</table>");
//============================================ Table 2b =============================================
print("<table class=\"A3\">");
print("<tr>");
	print("<td>".$string_lang['TRANSPORT'][$langue]." ");
	SelectVecteurEngages($connexion,$victime->vecteur_ID);
	print("</TD>");
	//print("<td><a HREF=\"../lits_synoptique.php?back=Victimes_saisie.php\">SYNOPTIQUE / LITS </a></td>");
print("<tr>");
//============================================ Table 3 =============================================
print("<table class=\"A3\">");
print("<tr>");
	print("<td>".$string_lang['HOPITAL'][$langue]."   ");
			select_hopital_visible($connexion,$victime->Hop_ID,$langue,$onChange="recupService(this.value)");
	print("</TD>");
	print("<td>".$string_lang['SERVICE'][$langue]."   ");
	print("<td>");
			//print("<select name='serviceID' id='serviceID'>");
    		//print("<option selected='selected' >Sélectionner un service</option>");
    		select_service2($connexion,$victime->Hop_ID,$victime->service_ID);
  			print("</select>");
  			
	print("<td><a HREF=\"../lits_synoptique.php?back=Victimes_saisie.php\">SYNOPTIQUE / LITS </a></td>");
print("<tr>");
print("</table>");
//============================================ Table 4 =============================================
print("<table class=\"A3\">");
print("<tr>");
		print("<td>".$string_lang['SEXE'][$langue]."</td>");
		print("<TD>");
			Select("sexe",$item_sexe,$victime->sexe);
		print("</TD>");
		print("<td>".$string_lang['AGE'][$langue]);
		print(" <INPUT NAME=\"age1\" TYPE=\"text\" SIZE=\"10\" VALUE=\"$victime->age1\">");
		print(" ans et/ou ");
		$adulte = $string_lang['ADULTE'][$langue];
		$ado = $string_lang['ADO'][$langue];
		$enfant = $string_lang['ENFANT'][$langue];
		print("<SELECT NAME=\"age2\">");
		print("<OPTION VALUE=\"Adulte\" SELECTED>$adulte");
		print("<OPTION VALUE=\"Adolescent\">$ado");
		print("<OPTION VALUE=\"Enfant\">$enfant");
		print("</SELECT>");
		//print("</TD>");

		//print("<TD>");
		print($string_lang['PAYS'][$langue]);
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

		print("<TD>");
		print("INTUBE <input type=\"checkbox\" name=iot>");
		print("</TD>");
print("<tr>");
print("</table>");
//----------------------------------- Dossier médical -------------------------------------------------
print("<hr>");// barre horizontale
print("<table class=\"A3\">");
	TblDebutLigne();
		TblCellule($string_lang['LESIONS'][$langue]);
		TblCellule("<textarea name=\"lesions\" rows=\"4\" cols=\"50\">$victime->lesions</textarea>");
		TblCellule($string_lang['TRAITEMENTS'][$langue]);
		TblCellule("<textarea name=\"traitement\" rows=\"4\" cols=\"50\">$victime->traitement</textarea>");
	TblFinLigne();
print("</table>");

print("<hr>");// barre horizontale
print("<table class=\"A3\">");
	TblDebutLigne();
		TblCellule($string_lang['NOM'][$langue]);	
		TblCellule("<input name=\"nom\" type=\"text\" size=\"27\" VALUE=\"$victime->nom\" ");
		TblCellule($string_lang['PRENOM'][$langue]);
		TblCellule("<input name=\"prenom\" type=\"text\" size=\"27\" VALUE=\"$victime->prenom\" ");
		TblCellule($string_lang['NE_LE'][$langue]);
		TblCellule("<INPUT NAME=\"naissance\" TYPE=\"text\" SIZE=\"15\" value=\"$victime->naissance\"> ");
	TblFinLigne();
	TblDebutLigne();
		$mot = $string_lang['ADRESSE'][$langue];
		TblCellule($mot." 1");
		TblCellule("<input type=\"text\" name=\"adresse1\" size=\"27\" value=\"$victime->adresse1\">");
		TblCellule($mot." 2");
		TblCellule("<input type=\"text\" name=\"adresse2\" size=\"27\" value=\"$victime->adresse2\">");
		TblCellule($string_lang['VILLE'][$langue]);
		TblCellule("<input type=\"text\" name=\"ville\" size=\"27\" value=\"$victime->ville\">");
	TblFinLigne();
//TblFin();

//print("<table class=\"A3\">");
	TblDebutLigne();
		TblCellule($string_lang['SIGNES_PARTICULIERS'][$langue]);
		TblCellule("<textarea name=\"signes\" rows=\"4\" cols=\"35\">$victime->signes</textarea>");
		TblCellule("Photo");
		$source_image = $victime->photo;
		TblCellule("<img src=\"$source_image\" alt=\"Photographie\" height=\"72\" width=\"72\" align=\"middle\" border=\"0\">
		<input type=\"file\" name=\"photo_victime\" size=\"10\" onchange=\"Choix(this.form)\">");
		//$photo = $image;
	TblFinLigne();
	

	TblDebutLigne();
		TblCellule("Heure de création:");
		TblCellule($victime->heure_creation);
		TblCellule("&nbsp;");
		TblCellule("&nbsp;");
		TblCellule("dernière mise à jour:");
		TblCellule($victime->heure_maj);
	TblFinLigne();
TblFin();

print("Evolution.<BR>");
print("<table class=\"A3\">");
	TblDebutLigne();
		TblCellule("Heure de modification");
		TblCellule("Localisation");
		TblCellule("Gravité");
	TblFinLigne();
/*
$requete= "SELECT victime_gravite.localisation_ID,victime_gravite.gravite_ID,heure,local_nom,gravite_nom
	FROM victime_gravite,localisation,gravite
	WHERE victime_ID = '$victime->victime_ID'
	AND victime_gravite.localisation_ID = localisation.localisation_ID
	AND  victime_gravite.gravite_ID = gravite.gravite_ID";*/
$requete= "SELECT victime_gravite.localisation_ID,victime_gravite.gravite_ID,heure,ts_nom,gravite_nom
	FROM victime_gravite,temp_structure,gravite
	WHERE victime_ID = '$victime->victime_ID'
	AND victime_gravite.localisation_ID = temp_structure.ts_ID
	AND  victime_gravite.gravite_ID = gravite.gravite_ID";
$resultat = ExecRequete($requete,$connexion);
$t="";
while($rub=mysql_fetch_array($resultat))
{
	/*
	TblDebutLigne();
		TblCellule($rub[heure]);
		//TblCellule($rub[local_nom]);
		TblCellule($rub[ts_nom]);
		TblCellule($rub[gravite_nom]);
	TblFinLigne();
	*/
	$t .= $rub['heure']."\t".$rub['ts_nom']."\t".$rub['gravite_nom']."\n";
}
TblCellule("<textarea name=\"signes\" rows=\"2\" cols=\"50\">$t</textarea>");
TblFin();


print("</FORM>");
print("</BODY>");
print("</HTML>");
?>