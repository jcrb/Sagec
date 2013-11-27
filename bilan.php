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
//-------------------------------------------------------------------------------------------
//	programme: 		Bilan.php
//	date de création: 	18/08/2003
//	auteur:			jcb
//	description:		Tableau récapitulatif de l'état des victimes (gravité)	
//	version:		1.2
//	maj le:			20/09/2003  
//--------------------------------------------------------------------------------------------
session_start();
if(!$_SESSION['auto_sagec'] && !$_SESSION["auto_victime"])header("Location:logout.php");
$langue = $_SESSION['langue'];
$member_id = $_SESSION['member_id'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require("utilitaires/table.php");
require("utilitairesHTML.php");
require("pma_connect.php");
require("pma_connexion.php");
require("pma_requete.php");
require("en_tete.php");
require 'utilitaires/globals_string_lang.php';
require 'date.php';
require("login/init_security.php");

print("<HTML>");
print("<HEAD>");
print("<META NAME=\"author JCB\"> ");
print("<TITLE>Bilan</TITLE>");
//<comment> rafraichissement automatique toutes les 30 secondes </comment>
print("<meta http-equiv=\"refresh\" content=\"30\">");
print("<link rel=\"shortcut icon\" href=\"images/sagec67.ico\" />");
print("</HEAD>");

print("<BODY>");
print("<FORM ACTION =\"bilan.php\">");

$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
$victime = array();
entete($member_id,$langue);
$event = evenement_courant($connexion,$_SESSION['evenement']);
//print($event['evenement_nom']);
// connection à la base PMA pour extraire les données nécessaires
$requete="SELECT gravite, status_ID FROM victime";
$requete .= " WHERE evenement_ID = '$_SESSION[evenement]'";// uniuement évènement courant
$resultat = ExecRequete($requete,$connexion);
$UA = 0;
while($g = LigneSuivante($resultat))
{
	//print($g->gravite." - ".$g->localisation_ID."<br>");
	switch($g->gravite)
	{
		case 1:
		case 7:$UA++;break;
		
		case 2:
		case 8:$UR++;$g->gravite = 2;;break;
		
		case 3:
		case 6:
		case 9:$U3++;$g->gravite = 3;break;
		
		case 4:
		case 5:$DCD++;break;
		
		case 0:
		case 11:$U++;$g->gravite = 0;break;
	}
	//if($g->gravite == 11) $g->gravite = 0;
	$victime[$g->status_ID][$g->gravite]++;
	
	//print("DEBUG<br>");
	//print("gravité: ".$g->gravite." - Localisation: ".$g->localisation_ID."<BR>");
}
//print_r($victime);

// Date et heure du bilan
$mot = dateHeureComplete(time(),$langue);

$ev = $event['evenement_nom'];
print("<fieldset>");
print("<legend>$ev <H4>$mot</H4></legend>");
print("<TABLE WIDTH=\"800\" BORDER=\"0\" CELLSPACING=\"2\" CELLPADDING=\"0\">");
print("<TR>");
print("<TD WIDTH=\"168\">&nbsp;</TD>");
$mot=$string_lang['U'][$langue];
print("<TD WIDTH=\"45\" BGCOLOR=\"#000099\"><CENTER><B><FONT COLOR=\"#ffffff\"FONT FACE=\"Arial\">$mot</FONT></B></CENTER></TD>");
$mot=$string_lang['UA'][$langue];
print("<TD WIDTH=\"45\" BGCOLOR=\"#ff0000\"><CENTER><FONT FACE=\"Arial\">&nbsp;</FONT><B><FONT COLOR=\"#ffffff\" FACE=\"Arial Baltic\">$mot</FONT></B></CENTER></TD>");
?>
	<!-- $victime['LOCALISATION','GRAVITE'] -->

    <TD WIDTH="45" BGCOLOR="#ffff00"><CENTER>&nbsp;<FONT FACE="Arial"><?php print($string_lang['UR'][$langue])?></FONT></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#00ff00"><CENTER>&nbsp;<FONT FACE="Arial Baltic"><?php print($string_lang['U3'][$langue])?></FONT></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#000000"><CENTER>&nbsp;<B><FONT COLOR="#ffffff" FACE="Arial"><?php print($string_lang['DCD'][$langue])?></FONT></B></CENTER></TD>
    <TD WIDTH="80" BGCOLOR="#dde6ee"><CENTER>&nbsp;<FONT FACE="Arial"><B><?php print($string_lang['TOTAL'][$langue]); ?></B></FONT></CENTER></TD>
  </TR>
  <TR>
    <TD WIDTH="168" BGCOLOR="#dde6ee">&nbsp;<FONT FACE="Arial">&nbsp;<?php print($string_lang['CHANTIER'][$langue]); ?></FONT></TD>
    <TD WIDTH="45" BGCOLOR="#009999"><CENTER>&nbsp;<? $t=$victime[1][0]+$victime[2][0];$total = $t;print($t) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#f48b80"><CENTER>&nbsp;<? $t=$victime[1][1]+$victime[2][1];$total += $t;print($t) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#ffff80"><CENTER>&nbsp;<? $t=$victime[1][2]+$victime[2][2];$total += $t;print($t) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#8bf878"><CENTER>&nbsp;<? $t=$victime[1][3]+$victime[2][3];$total += $t;print($t) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#999999"><CENTER>&nbsp;<? $t=$victime[1][4]+$victime[2][4];$total += $t;print($t) ?></CENTER></TD>
    <TD WIDTH="80" BGCOLOR="#dde6ee"><CENTER>&nbsp;<? print($total) ?> </CENTER></TD>
  </TR>
  <TR>
    <TD WIDTH="168" BGCOLOR="#dde6ee">&nbsp;<FONT FACE="Arial">&nbsp;<?php print($string_lang['TRI'][$langue]); ?></FONT></TD> 
   <TD WIDTH="45" BGCOLOR="#009999"><CENTER>&nbsp;<? $t=$victime[3][0]+$victime[4][0];$total = $t;print($t) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#f48b80"><CENTER>&nbsp;<? $t=$victime[3][1]+$victime[4][1];$total += $t;print($t) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#ffff80"><CENTER>&nbsp;<? $t=$victime[3][2]+$victime[4][2];$total += $t;print($t) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#8bf878"><CENTER>&nbsp;<? $t=$victime[3][3]+$victime[4][3];$total += $t;print($t) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#999999"><CENTER>&nbsp;<? $t=$victime[3][4]+$victime[4][4];$total += $t;print($t) ?></CENTER></TD>
    <TD WIDTH="80" BGCOLOR="#dde6ee"><CENTER>&nbsp;<? print($total) ?></CENTER> </TD>
  </TR>
  <TR>
    <TD WIDTH="368" BGCOLOR="#dde6ee">&nbsp;<FONT FACE="Arial">&nbsp;<?php print($string_lang['PMA'][$langue]); ?></FONT></TD> 
    <TD WIDTH="45" BGCOLOR="#009999"><CENTER>&nbsp;<? $t=$victime[5][0]+$victime[6][0]+$victime[7][0];$total = $t;print($t) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#f48b80"><CENTER>&nbsp;<? $t=$victime[5][1]+$victime[6][1]+$victime[7][1];$total += $t;print($t) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#ffff80"><CENTER>&nbsp;<? $t=$victime[5][2]+$victime[6][2]+$victime[7][2];$total += $t;print($t) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#8bf878"><CENTER>&nbsp;<? $t=$victime[5][3]+$victime[6][3]+$victime[7][3];$total += $t;print($t) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#999999"><CENTER>&nbsp;<? $t=$victime[5][4]+$victime[6][4]+$victime[7][4];$total += $t;print($t) ?></CENTER></TD>
    <TD WIDTH="80" BGCOLOR="#dde6ee"><CENTER>&nbsp;<? print($total) ?></CENTER> </TD>
  </TR>
  <TR>
    <TD WIDTH="168" BGCOLOR="#dde6ee">&nbsp;<FONT FACE="Arial">&nbsp;<?php print($string_lang['EVAC'][$langue]); ?></FONT></TD> 
    <TD WIDTH="45" BGCOLOR="#009999"><CENTER>&nbsp;<? $t=$victime[8][0]+$victime[9][0];$total = $t;print($t) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#f48b80"><CENTER>&nbsp;<? $t=$victime[8][1]+$victime[9][1];$total += $t;print($t) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#ffff80"><CENTER>&nbsp;<? $t=$victime[8][2]+$victime[9][2];$total += $t;print($t) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#8bf878"><CENTER>&nbsp;<? $t=$victime[8][3]+$victime[9][3];$total += $t;print($t) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#999999"><CENTER>&nbsp;<? $t=$victime[8][4]+$victime[9][4];$total += $t;print($t) ?></CENTER></TD>
    <TD WIDTH="80" BGCOLOR="#dde6ee"><CENTER>&nbsp;<? print($total) ?></CENTER></TD>
  </TR>
  <TR>
    <TD WIDTH="168" BGCOLOR="#dde6ee">&nbsp;<FONT FACE="Arial">&nbsp;<?php print($string_lang['EVAC_EN_COURS'][$langue]); ?></FONT></TD> 
    <TD WIDTH="45" BGCOLOR="#009999"><CENTER>&nbsp;<? $t=$victime[10][0];$total = $t;print($t) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#f48b80"><CENTER>&nbsp;<? $t=$victime[10][1];$total += $t;print($t) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#ffff80"><CENTER>&nbsp;<? $t=$victime[10][2];$total += $t;print($t) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#8bf878"><CENTER>&nbsp;<? $t=$victime[10][3];$total += $t;print($t) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#999999"><CENTER>&nbsp;<? $t=$victime[10][4];$total += $t;print($t) ?></CENTER></TD>
    <TD WIDTH="80" BGCOLOR="#dde6ee"><CENTER>&nbsp;<? print($total) ?></CENTER></TD>
  </TR>
  <TR>
    <TD WIDTH="368" BGCOLOR="#dde6ee">&nbsp;<FONT FACE="Arial">&nbsp;<?php print($string_lang['HOSPITALISE'][$langue]); ?></FONT></TD> 
    <TD WIDTH="45" BGCOLOR="#009999"><CENTER>&nbsp;<? $t=$victime[11][0];$total = $t;print($t) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#f48b80"><CENTER>&nbsp;<? $t=$victime[11][1];$total += $t;print($t) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#ffff80"><CENTER>&nbsp;<? $t=$victime[11][2];$total += $t;print($t) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#8bf878"><CENTER>&nbsp;<? $t=$victime[11][3];$total += $t;print($t) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#999999"><CENTER>&nbsp;<? $t=$victime[11][4];$total += $t;print($t) ?></CENTER></TD>
    <TD WIDTH="80" BGCOLOR="#dde6ee"><CENTER>&nbsp;<? print($total) ?></CENTER></TD>
  </TR>

  <TR>
    <TD WIDTH="568" BGCOLOR="#dde6ee">&nbsp;<FONT FACE="Arial">&nbsp;<?php print($string_lang['LSP'][$langue]); ?></FONT></TD> 
    <TD WIDTH="45" BGCOLOR="#009999"><CENTER>&nbsp;<? $total = $victime[12][0];print($victime[12][0]) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#f48b80"><CENTER>&nbsp;<? $total += $victime[12][1];print($victime[12][1]) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#ffff80"><CENTER>&nbsp;<? $total += $victime[12][2];print($victime[12][2]) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#8bf878"><CENTER>&nbsp;<? $total += $victime[12][3];print($victime[12][3]) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#999999"><CENTER>&nbsp;<? $total += $victime[12][4];print($victime[12][4]) ?></CENTER></TD>
    <TD WIDTH="80" BGCOLOR="#dde6ee"><CENTER>&nbsp;<? print($total) ?></CENTER></TD>
  </TR>
  <TR>
    <TD WIDTH="268" BGCOLOR="#dde6ee">&nbsp;<FONT FACE="Arial">&nbsp;<?php print($string_lang['MORGUE'][$langue]); ?></FONT></TD> 
    <TD WIDTH="45" BGCOLOR="#009999"><CENTER>&nbsp;<? $total = $victime[13][0];print($victime[13][0]) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#f48b80"><CENTER>&nbsp;<? $total += $victime[13][1];print($victime[13][1]) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#ffff80"><CENTER>&nbsp;<? $total += $victime[13][2];print($victime[13][2]) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#8bf878"><CENTER>&nbsp;<? $total += $victime[13][3];print($victime[13][3]) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#999999"><CENTER>&nbsp;<? $total += $victime[13][4];print($victime[13][4]) ?></CENTER></TD>
    <TD WIDTH="80" BGCOLOR="#dde6ee"><CENTER>&nbsp;<? print($total) ?></CENTER></TD>
  </TR>
  <TR>
  <TR>
    <TD WIDTH="268" BGCOLOR="#dde6ee">&nbsp;<FONT FACE="Arial">&nbsp;<?php print($string_lang['AUTRE'][$langue]); ?></FONT></TD> 
    <TD WIDTH="45" BGCOLOR="#009999"><CENTER>&nbsp;<? $total = $victime[99][0];print($victime[99][0]) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#f48b80"><CENTER>&nbsp;<? $total += $victime[99][1];print($victime[99][1]) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#ffff80"><CENTER>&nbsp;<? $total += $victime[99][2];print($victime[99][2]) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#8bf878"><CENTER>&nbsp;<? $total += $victime[99][3];print($victime[99][3]) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#999999"><CENTER>&nbsp;<? $total += $victime[99][4];print($victime[99][4]) ?></CENTER></TD>
    <TD WIDTH="80" BGCOLOR="#dde6ee"><CENTER>&nbsp;<? print($total) ?></CENTER></TD>
  </TR>
  <TR>
    <TD WIDTH="268" BGCOLOR="#dde6ee">&nbsp;<FONT FACE="Arial"><B><?php print($string_lang['TOTAL'][$langue]); ?></B></FONT></TD> 
    <TD WIDTH="45" BGCOLOR="#dde6ee"><CENTER>&nbsp;<? print($U) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#dde6ee"><CENTER>&nbsp;<? print($UA) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#dde6ee"><CENTER>&nbsp;<? print($UR) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#dde6ee"><CENTER>&nbsp;<? print($U3) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#dde6ee"><CENTER>&nbsp;<? print($DCD) ?></CENTER></TD>
    <TD WIDTH="80" BGCOLOR="#dde6ee"><CENTER>&nbsp;<? print($U+$UA+$UR+$U3+$DCD) ?></CENTER></TD>
  </TR>
</TABLE>
<BR>
<input type="submit" name="mise_a_jour" value="Mettre a jour" border="0">
<?php print("</fieldset>"); 

/** PMA actifs */

print("<fieldset>");
print("<legend>Détails par structure non hospitalière</legend>");
print($string_lang['UR'][$langue]);
$requete = "SELECT * FROM temp_structure WHERE ts_type IN('1','5','6','9','13','16','17') AND ts_active = 'o'";
$resultat = ExecRequete($requete,$connexion);
print("<TABLE WIDTH=\"800\" BORDER=\"0\" CELLSPACING=\"2\" CELLPADDING=\"0\">");
	print("<TR>");
		print("<TD WIDTH=\"168\">&nbsp;</TD>");
		$mot=$string_lang['U'][$langue];
		print("<TD WIDTH=\"45\" BGCOLOR=\"#000099\"><CENTER><B><FONT COLOR=\"#ffffff\"FONT FACE=\"Arial\">$mot</FONT></B></CENTER></TD>");
		$mot=$string_lang['UA'][$langue];
		?>
		<TD WIDTH="45" BGCOLOR="#ff0000"><CENTER><FONT FACE="Arial">&nbsp;</FONT><B><FONT COLOR="#ffffff" FACE="Arial Baltic"><?php print($mot)?></FONT></B></CENTER></TD>
		<TD WIDTH="45" BGCOLOR="#ffff00"><CENTER>&nbsp;<FONT FACE="Arial"><?php print($string_lang['UR'][$langue])?></FONT></CENTER></TD>
   	<TD WIDTH="45" BGCOLOR="#00ff00"><CENTER>&nbsp;<FONT FACE="Arial Baltic"><?php print($string_lang['U3'][$langue])?></FONT></CENTER></TD>
   	<TD WIDTH="45" BGCOLOR="#000000"><CENTER>&nbsp;<B><FONT COLOR="#ffffff" FACE="Arial"><?php print($string_lang['DCD'][$langue])?></FONT></B></CENTER></TD>
   	<TD WIDTH="80" BGCOLOR="#dde6ee"><CENTER>&nbsp;<FONT FACE="Arial"><B><?php print($string_lang['TOTAL'][$langue]); ?></B></FONT></CENTER></TD>
  	</TR>
<?php
$total_UA = $total_UR = $total_U3 = $total_DCD = $total_U = $total = 0;
while($pma = mysql_fetch_array($resultat))
{
	/* recherche des patients */
	$requete = "SELECT * FROM victime WHERE localisation_ID = '$pma[ts_ID]'";
	$resultat2 = ExecRequete($requete,$connexion);
	$UA = $UR = $U3 = $DCD = $total_ligne = $U = 0;
	print("<tr>");
	while($victime = mysql_fetch_array($resultat2))
	{
		switch($victime[gravite])
		{
			case 1:
			case 7:$UA++;$total_UA++;break;
			case 2:
			case 8:$UR++;$total_UR++;break;
			case 3:
			case 6:
			case 9:$U3++;$total_U3++;break;
			case 4:
			case 5:$DCD++;$total_DCD++;break;
			default: $U++;$total_U++;break;
		}
		$total_ligne++;
		$total++;
	}
	?>
	<TD WIDTH="168" BGCOLOR="#dde6ee">&nbsp;<FONT FACE="Arial">&nbsp;<?php print(Security::db2str($pma['ts_nom'])); ?></FONT></TD>
    <TD WIDTH="45" BGCOLOR="#009999"><CENTER>&nbsp;<? if($U>0)print($U) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#f48b80"><CENTER>&nbsp;<? if($UA>0)print($UA) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#ffff80"><CENTER>&nbsp;<? if($UR>0)print($UR) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#8bf878"><CENTER>&nbsp;<? if($U3>0)print($U3) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#999999"><CENTER>&nbsp;<? if($DCD>0)print($DCD) ?></CENTER></TD>
    <TD WIDTH="80" BGCOLOR="#dde6ee"><CENTER>&nbsp;<? print($total_ligne) ?> </CENTER></TD>
    <?php
	print("</tr>");
}
?>
	<TD WIDTH="168" BGCOLOR="#dde6ee">&nbsp;<FONT FACE="Arial">&nbsp;<?php print(Security::db2str($pma['ts_nom'])); ?></FONT></TD>
    <TD WIDTH="45" BGCOLOR="#dde6ee"><CENTER>&nbsp;<? print($total_U) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#dde6ee"><CENTER>&nbsp;<? print($total_UA) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#dde6ee"><CENTER>&nbsp;<? print($total_UR) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#dde6ee"><CENTER>&nbsp;<? print($total_U3) ?></CENTER></TD>
    <TD WIDTH="45" BGCOLOR="#dde6ee"><CENTER>&nbsp;<? print($total_DCD) ?></CENTER></TD>
    <TD WIDTH="80" BGCOLOR="#dde6ee"><CENTER>&nbsp;<? print($total) ?> </CENTER></TD>
    <?php
print("</TABLE>");
print("</fieldset>");
?>
</FORM>
</BODY>
</HTML>
