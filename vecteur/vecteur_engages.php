<?php
//----------------------------------------- SAGEC --------------------------------------------------------
//
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
//		
//----------------------------------------- SAGEC --------------------------------------------------------
//
//	programme: 			vecteur_engages.php
//	date de création: 	16/11/2005
//	auteur:				jcb
//	description:		Synoptique des moyens engagés et leur localisation. Mise à jour toutes les 30 secondes
//	version:			1.0
//	maj le:				16/11/2005
//
//---------------------------------------------------------------------------------------------------------
// synoptique des moyens disponibles
// connection à la base PMA pour extraire les données nécessaires
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION[langue];
$chemin="../";

require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
include("../vecteurs_menu.php");
include("../utilitairesHTML.php");
require '../utilitaires/globals_string_lang.php';
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

?>
<HTML>
	<HEAD>
	<TITLE>Liste des vecteurs</TITLE>
	<LINK REL=stylesheet HREF="../pma.css" TYPE ="text/css">
	<meta http-equiv="refresh" content="30">
	<script src="../ajax/jquery-courant.js"></script>
		<script>
			$("document").ready(function() {
				var val=-1,c;
 				$('#cocheTout').click(function() { 					// clic sur la case cocher/decocher
				var cases = $('#cases').find(':checkbox'); 	// on cherche les checkbox qui dépendent de la liste 'cases'
        		if(this.checked){ 									// si 'cocheTout' est coché
            	cases.attr('checked', true); 					// on coche les cases
            	$('#cocheText').html('Tout decocher'); 	// mise à jour du texte de cocheText
            	val = 0;
            	c = 1;
            	$.ajax({type: "POST",url: "update.php",data:"id="+ val + "&check=" + c,success: function(msg){alert( "Data Saved: " + msg)}});
        		}else{ 													// si on décoche 'cocheTout'
            	cases.attr('checked', false);					// on coche les cases
            	$('#cocheText').html('Cocher tout');		// mise à jour du texte de cocheText
            	val = 0;c = 0;  
            	$.ajax({type: "POST",url: "update.php",data:"id="+ val + "&check=" + c,success: function(msg){alert( "Data Saved: " + msg)}});     		}               
    			})
		});
		
		
		function ischeck(val){
			var c;
			if($('#'+ val).attr('checked'))	// le # permet de désigner un élément par son ID
					c = 'o';							// c = 1 si la case est cochée
			else
					c = '';			
			$.ajax({
   			type: "POST",
   			url: "update.php",
   			data:"id="+val + "&check="+c
   			//success: function(msg){alert( "Data Saved: " + msg );	// msg reprend tous les éléments "imprimés" par print et echo dans le fichier update
   		})
		}
		</script>
</head>

<body>
<form name="Sélection_des_vecteurs" method="get" action="vecteur_engages.php">
<?php

MenuVecteurs($langue,$chemin);

$type_moyen = $_REQUEST['v_type'];
/*
if($_REQUEST[ok])
{
	$type_moyen = $_REQUEST['v_type'];
}*/

TblDebut(0,"100%");
	TblDebutLigne();
		$mot = $string_lang['TYPE_DE_MOYEN'][$langue];
		TblCellule("$mot");
			print("<TD>");
				SelectTypeVecteur($connexion,$_REQUEST['v_type'],$_SESSION[langue],"onChange=submit();");
			print("</TD>");	
		$mot = $string_lang['VALIDER'][$langue];	
		//TblCellule("<INPUT TYPE=\"SUBMIT\" VALUE=\"$mot\" NAME=\"ok\" SIZE = \"30\" ");
	TblFinLigne();
TblFin();

$requete="SELECT Vec_Nom,Vec_Type,Vec_Engage,Vec_ID
	  FROM vecteur ";
		if($type_moyen != 0)
	  $requete .= "WHERE Vec_Type = '$type_moyen'
	 ";

	$resultat = ExecRequete($requete,$connexion);
	
	$ts_courant='';
	while($rub=mysql_fetch_array($resultat))
	{
		$e = $rub[Vec_ID];
		?>
		<p>
			
			<input type="checkbox" id="<?echo $e;?>" onClick="ischeck(<?echo $e;?>)") name="vec[]" value="<? echo $e?>"
			<?php if($rub['Vec_Engage'] =='o') echo(' CHECKED')?> />
			<label for="<?echo $e;?>"><? echo $rub['Vec_Nom']?></label>
		</p>
		<?
	}

	/*
	{
		if($_style=="A3")$_style="A4";else $_style="A3";
		print("<tr class=\"$_style\">");
			if($ts_courant == $rub['ts_nom'])
				$local = "&nbsp;";
			else
			{
				$local = $rub['ts_nom'];
				$ts_courant = $local;
			}
			print("<td>$local</td>");
			print("<td>$rub[Vec_Nom]</td>");
			print("<td>$rub[vecteur_type_nom]</td>");
			print("<td>".$string_lang[$rub['VEtat_nom']][$langue]."</td>");
			// si en charge ou en cours écacuation, indiquer le n° de victime
			if($rub['Vec_Etat']==5)
			{
				$requete = "SELECT victime_ID,no_ordre FROM victime WHERE victime.vecteur_ID = '$rub[Vec_ID]'";
				$resultat2 = ExecRequete($requete,$connexion);
				while($rub2=mysql_fetch_array($resultat2))
				{
					print("<td><a href=\"../victimes_saisie.php?identifiant=$rub2[no_ordre]\">$rub2[no_ordre] </a></TD>");
				}
			}
			else
				print("<td>&nbsp;</td>");
			print("<td><a href=\"../vecteur_saisie.php?ttvecteur=$rub[Vec_ID]&back=vecteur/vecteur_engages.php\">modifier</a></td>");
		print("</tr>");
		*/
?>
</form>
</body>
</html>
