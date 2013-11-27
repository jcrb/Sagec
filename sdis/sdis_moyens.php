<?php
/**----------------------------------------- SAGEC ---------------------------------
  * This file is part of SAGEC67 Copyright (C) 2003-2010 (Jean-Claude Bartier).
  * SAGEC67 is free software; you can redistribute it and/or modify
  * it under the terms of the GNU General Public License as published by
  * the Free Software Foundation; either version 2 of the License, or
  * (at your option) any later version.
  * SAGEC67 is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  * GNU General Public License for more details.
  * You should have received a copy of the GNU General Public License
  * along with SAGEC67; if not, write to the Free Software
  * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
  */	
/** ---------------------------------------------------------------------------------
  * programme: 			sdis_moyens.php
  * date de création: 	12/02/2010
  * auteur:					jcb
  * description:			
  *								 
  * version:				1.0
  * maj le:			
  * -------------------------------------------------------------------------------*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
$titre_principal="Moyens - SDIS 67";
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
include($backPathToRoot."utilitairesHTML.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Gestion des organismes</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
	<script src="../ajax/jquery-courant.js"></script>
		<script>
			$("document").ready(function() {
				$('field1').style.backgroundColor="red";
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

<body onload="">

<form name="Sélection_des_vecteurs" method="get" action="sdis_moyens.php">
<?php
	/** type de moyens autorisés pour le SDIS */
	$limit="3','10','12','16','19','20','21','22','23','24','27";
	$type_moyen = $_REQUEST['v_type'];
	if($type_moyen == 0)$type_moyen = $limit;
	$mot = $string_lang['TYPE_DE_MOYEN'][$langue];
	$requete="SELECT Vec_Nom,Vec_Type,Vec_Engage,Vec_ID FROM vecteur ";
		if($type_moyen != 0)
			$requete .= "WHERE Vec_Type IN('$type_moyen')";
	$resultat = ExecRequete($requete,$connexion);
	$ts_courant='';
?>

<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend> Cocher les cases correspondants aux moyens SSSM engagés </legend>
		<p>
		
		<table>
			<tr>
				<td><?php echo $mot;?></td>
				<td><?php SelectTypeVecteur($connexion,$_REQUEST['v_type'],$_SESSION[langue],"onChange=submit();",$limit); ?></td>	
			</tr>
		</table>

		<?php
			while($rub=mysql_fetch_array($resultat)){
				$e = $rub[Vec_ID];
		?>
		<p>
			<input type="checkbox" id="<?echo $e;?>" onClick="ischeck(<?echo $e;?>)") name="vec[]" value="<? echo $e?>"
			<?php if($rub['Vec_Engage'] =='o') echo(' CHECKED')?> />
			<label for="<?echo $e;?>"><? echo $rub['Vec_Nom']?></label>
		</p>
		<?php }?>
		</p>
	</fieldset>
</div>

<?php
?>

</form>
</body>
</html>