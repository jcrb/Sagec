<?php
/**
* creer_tache.php
* @author JCB
* @date
* @version $Id$
*/
session_start();
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

print("<head>");

print("</head>");

print("<form name=\"creer_tache\" method=\"get\"action=\"enregistrer_tache.php\" >") ;

/**
* Dessine une case à cocher et sa légende. En foction de la variable $x, la case sera cochée ou non
* @param $name nom interne de la case à cocher
* @param $x indique si la case doit être cochée ou non
* @param $titre légende de la case à cocher
*/
function check($name,$x,$titre,$bgcolor)
{
	if($x)
		print("<td bgcolor=\"$bgcolor\"><INPUT TYPE=\"CHECKBOX\"  NAME=\"$name\" CHECKED value=\"o\"> $titre </TD>");
	else
		print("<td bgcolor=\"$bgcolor\"><INPUT TYPE=\"CHECKBOX\"  NAME=\"$name\" > $titre </TD>");
}

function radio($name,$x,$titre,$bgcolor)
{
	if($x)
		print("<td bgcolor=\"$bgcolor\"><INPUT TYPE=\"RADIO\"  NAME=\"$name\" CHECKED value=\"o\"> $titre </TD>");
	else
		print("<td bgcolor=\"$bgcolor\"><INPUT TYPE=\"RADIO\"  NAME=\"$name\" > $titre </TD>");
}

$erreur = $_REQUEST['erreur'];
if($erreur != 0)
{
}

$query = "SELECT nom, prenom FROM utilisateurs WHERE ID_utilisateur = '$_SESSION[member_id]'";
$result = ExecRequete($query,$connexion);
$utilisateur = mySql_fetch_array($result);

$tacheID = $_REQUEST['tacheID'];
print("tache ID = ".$tacheID."<br>");
if($tacheID) // => c'est une mise à jour
{
	print("Mise à jour du dossier <br>");
	print("<input type=\"hidden\" name=\"tacheID\" value=\"$tacheID\">");
	$requete = "SELECT * FROM taches_crra WHERE tache_ID = '$tacheID'";
	$resultat = ExecRequete($requete,$connexion);
	$rep = mySql_fetch_array($resultat);
}

print("<table width=\"100%\">") ;
	print("<tr bgcolor = \"yellow\" >");
		print("<td>N° de dossier</td>");
		print("<td><input type=\"text\" name=\"noDossier\"   value=\"$rep[no_dossier]\" onload=\"setFocus();\" ");
		print("<td>Priorité</td>");
		print("<td colspan = 2>");
		print("<input type=\"radio\" name=\"priorite\" value=\"1\" ");if($rep[priorite]==1)print("CHECKED");print(" > U1");
		print("<input type=\"radio\" name=\"priorite\" value=\"2\" ");if($rep[priorite]==2)print("CHECKED");print(" > U2");
		print("<input type=\"radio\" name=\"priorite\" value=\"3\" ");if($rep[priorite]==3)print("CHECKED");print("> U3</td>");
   print("</tr>");
	print("<tr bgcolor=#66FF00>");
      print("<td ROWSPAN=6>Décision</td>");
      $bgcolor="#99FFFF";
		print("<td ROWSPAN=2 bgcolor=#99FFFF>SMUR</td>");
		check("vl",$rep['vl'],'VL',$bgcolor);
		check("ar",$rep['ar'],'AR',$bgcolor);
		check("d67",$rep['d67'],'D67',$bgcolor);
		//print("<td bgcolor=#99FFFF><input type=\"checkbox\" name=\"ar\" > AR</td>");
		//print("<td bgcolor=#99FFFF><input type=\"checkbox\" name=\"d67\" > D67</td>");
	print("</tr>");
   print("<tr  bgcolor=#99FFFF>");
   	//print("<td><input type=\"checkbox\" name=\"renf\" > Renfort</td>");
   	check("renf",$rep['renfort'],'Renfort',$bgcolor);
		print("<td>&nbsp;</td>");
		print("<td>&nbsp;</td>");
	print("</tr>");
	$bgcolor="#CCFF66";
	print("<tr bgcolor=#CCFF66>");
		print("<td ROWSPAN=2 >SDIS</td>");
		check("vsav",$rep['vsav'],'VSAV',$bgcolor);
		check("vlinf",$rep['vlinf'],'VL INF.',$bgcolor);
		//print("<td><input type=\"checkbox\" name=\"vsav\" > VSAV</td>");
		//print("<td><input type=\"checkbox\" name=\"vlinf\" > VL INF.</td>");
		print("<td >&nbsp;</td>");
	print("</tr>");
	print("<tr bgcolor=#CCFF66>");
	check("galien",$rep['galien'],'Galien',$bgcolor);
	check("fs",$rep['fs'],'FS',$bgcolor);
	
		//print("<td><input type=\"checkbox\" name=\"galien\" > Galien</td>");
		//print("<td><input type=\"checkbox\" name=\"fs\" > FS.</td>");
		print("<td >&nbsp;</td>");
	print("</tr>");
	$bgcolor="#CCFFCC";
	print("<tr bgcolor=#CCFFCC >");
		print("<td ROWSPAN=2 >AUTRES</td>");
		check("assu",$rep['assu'],'ASSU',$bgcolor);
		check("med",$rep['med'],'MED',$bgcolor);
		
		//print("<td ><input type=\"checkbox\" name=\"assu\" > ASSU</td>");
		//print("<td ><input type=\"checkbox\" name=\"med\" > MED</td>");
		print("<td >&nbsp;</td>");
	print("</tr>");
		print("<tr bgcolor=#CCFFCC >");
		check("pol",$rep['pol'],'POLICE',$bgcolor);
		check("vps",$rep['vps'],'VPSec',$bgcolor);
		
		//print("<td><input type=\"checkbox\" name=\"pol\" > POLICE</td>");
		//print("<td ><input type=\"checkbox\" name=\"vps\" > VPSec</td>");
		print("<td >&nbsp;</td>");
	print("</tr>");
	 print("</tr>");
		print("<tr bgcolor=orange>");
        print("<td ROWSPAN=2 COLSPAN=2>Tâches</td>");
		print("<td><input type=\"checkbox\" name=\"reg\" > Reg</td>");
		print("<td><input type=\"checkbox\" name=\"bilan\" > Bilan</td>");
		print("<td><input type=\"checkbox\" name=\"adm\" > Adm</td>");
	print("</tr>");
	print("</tr>");
		$bgcolor="orange";
		print("<tr bgcolor=orange>");
		check("comp",$rep['complet'],'Complet',$bgcolor);
		check("close",$rep['close'],'Fermer',$bgcolor);
		check("transfert",$rep['transfert'],'Transfert',$bgcolor);
		
		//print("<td><input type=\"checkbox\" name=\"comp\" > Complet</td>");
		//print("<td><input type=\"checkbox\" name=\"close\" > Fermer</td>");
		//print("<td><input type=\"checkbox\" name=\"transfert\" > Transfert</td>");
	print("</tr>");

	print("<tr bgcolor=yellow>");
	$bgcolor="yellow";
	print("<td>Rédacteur</td>");
	print("<td>$utilisateur[nom]</td>");
        //print("<td COLSPAN=2 >");
		print("<td COLSPAN=3><input type=\"submit\" name=\"ok\"  value=\"valider\"</td> " );
	print("</tr>");

print("<table>") ;
print("</form>") ;
?>