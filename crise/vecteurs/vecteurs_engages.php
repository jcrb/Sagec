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
  * programme: 			vecteur_engages.php
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
$backPathToRoot = "../../";

$menu_sup = "<a href='../../samu/samu_main.php'>Régulation</a> > ";
$menu_sup .= "<a href='../crise_main.php'>Crise</a> > ";
$menu_sup .= "<a href='vecteurs_index.php'>Vecteurs</a> > ";
$menu_sup .= "Vecteurs engagés";

include_once("vecteurs_top.php");
include_once("vecteurs_menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require $backPathToRoot.'utilitairesHTML.php';
require($backPathToRoot."dbConnection.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Superviseur</title>
	<link rel="stylesheet" href="../div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../../images/sagec67.ico" />
	
	<script> var backPathToRoot = "<?php echo $backPathToRoot;?>"</script>
	<script  type="text/javascript" src="<?php echo $backPathToRoot;?>utilitaires.js"></script>
	<script src= "<?php echo $backPathToRoot;?>ajax/jquery-courant.js"></script>
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
            	$.ajax({
            		type: "POST",
            		url: "update.php",data:"id="+ val + "&check=" + c,
            		//success: function(msg){alert( "Data Saved: " + msg)}
            	});
        		}else{ 													// si on décoche 'cocheTout'
            	cases.attr('checked', false);					// on coche les cases
            	$('#cocheText').html('Cocher tout');		// mise à jour du texte de cocheText
            	val = 0;c = 0;  
            	$.ajax({
            		type: "POST",
            		url: "update.php",
            		data:"id="+ val + "&check=" + c,
            		//success: function(msg){alert( "Data Saved: " + msg)}
            	});     		}               
    			})
		});
		
		
		function ischeck(val){
			var c;
			if($('#'+ val).attr('checked'))	// le # permet de désigner un élément par son ID
			{
					c = 'o';							// c = 1 si la case est cochée
					//alert(val);
			}
			else
					c = '';			
			$.ajax({
   			type: "POST",
   			url: "update.php",
   			data:"id="+val + "&check="+c,
   			//success: function(msg){alert( "Data Saved: " + msg )}	// msg reprend tous les éléments "imprimés" par print et echo dans le fichier update
   		})
		}
		</script>
</head>

<body onload="">

<form name="" action= "vecteurs_engages.php" method = "post">

<div id="div2">
	<fieldset id="field1">
		<legend>Vecteurs Engagés </legend>
		<p>
			<?php
			$type_moyen = $_REQUEST['v_type'];
			TblDebut(0,"50%");
				TblDebutLigne();
					$mot = $string_lang['TYPE_DE_MOYEN'][$langue];
					TblCellule("$mot");
					print("<TD>");
						SelectTypeVecteur($connexion,$_REQUEST['v_type'],$_SESSION[langue],"onChange=submit()");
					print("</TD>");	
					$mot = $string_lang['VALIDER'][$langue];	
				TblFinLigne();
			TblFin();

			$requete="SELECT Vec_Nom,Vec_Type,Vec_Engage,Vec_ID FROM vecteur ";
			if($type_moyen != 0)
	  			$requete .= "WHERE Vec_Type = '$type_moyen'";

			$resultat = ExecRequete($requete,$connexion);
			$ts_courant='';
			?>
			<br><br>
		</p>
		<p>
			<table id="tss" width="25%"><?php
			while($rub=mysql_fetch_array($resultat))
			{
				$e = $rub[Vec_ID];
				?>
				<tr>
					<?php if($rub['Vec_Engage'] =='o') echo('<td id="tdLeft" bgcolor="yellow">');else echo('<td id="tdLeft">');?>
					<label for="<?php echo $e;?>"><?php echo $rub['Vec_Nom']?></label></td>
					<?php if($rub['Vec_Engage'] =='o') echo('<td bgcolor="yellow">');else echo('<td>');?>
					<input type="checkbox" id="<?php echo $e;?>" onClick="ischeck(<?echo $e; ?>)") name="vec[]" value="<?php echo $e?>"
					<?php if($rub['Vec_Engage'] =='o') echo(' CHECKED bgcolor="yellow" ')?> />
				</td></tr>
				<?php }?>
				</table>
		</p>
	</fieldset>
</div>

</form>
</body>
</html>