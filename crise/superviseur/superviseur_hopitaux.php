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
  * programme: 			ars_deces.php
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
include_once($backPathToRoot."login/init_security.php");
$titre_principal = "Crise et Supervision - Gestion des hôpitaux";
include_once("top.php");
include_once("menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");

// on récupère la liste des hôpitaux actifs
$visible = array();
$listeID = 4;//NE PAS MODIFIER
$requete = "SELECT Hop_ID FROM hopital_visible WHERE org_ID = '$_SESSION[organisation]' AND liste_ID = '$listeID'"; 
$resultat = ExecRequete($requete,$connexion);
while($rep=mysql_fetch_array($resultat))
{
	$visible[] = $rep[Hop_ID]; // remplace hopVisible par visible
}
$requete = "SELECT Hop_nom, Hop_ID from hopital ORDER BY Hop_nom";
$resultat = ExecRequete($requete,$connexion);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
	<title>Superviseur</title>
	<link rel="stylesheet" href="../div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../../images/sagec67.ico" />
	<script  type="text/javascript" src="../../utilitaires.js"></script>
	
	<link rel="stylesheet" href="../../js/css/jquery.dataTables.css" />
	<script src="../../js/jquery.js"></script>
	<script src="../../js/jquery.dataTables.min.js"></script>
	<script src="startDataTables.js"></script>
	
	<script src="../../ajax/ajax.js" type="text/javascript"></script>
	<script src="../../ajax/JSON.js" type="text/javascript"></script>
	<script>
	function vide()
	{
		if(objet_hxr.readyState == 4)
		{
			if(objet_hxr.status == 200)
			{
		}
		else
		{
				alert("Erreur serveur: "+objet_hxr.status+" - "+objet_hxr.statusText);
				objet_hxr.abort();
				objet_hxr = null;
			}
		}
	}
	function check(n){
		objet_hxr = createXHR();
		//alert(n);
		var cases =  document.getElementById(n);
		//alert(cases.type);
		if(cases.type=='checkbox'){
			if(cases.checked){
				//alert('true');
				objet_hxr.open("get","hop_visible_enregistre.php?action=insert&value="+n,true);
			}
			else
			{
				//alert('false');
				objet_hxr.open("get","hop_visible_enregistre.php?action=del&value="+n,true);
			}
			objet_hxr.onreadystatechange = vide;
			objet_hxr.send(null);
		}
	}
	/*
		n: identifiant de la case à cocher
		
	*/
	/*
	$(document).ready(function(){
		$('#hopitaux :checkbox').click(function() {
			var $this = $(this);
			var id = $this.attr('value');
			if($this.is(':checked'))
				c = 'check';
			else
				c = 'nocheck';
			alert($this.is(':checked')); // répobd true ou false
			alert($this.attr('value'));  // retourne l'ID
			$.ajax({
				type:'POST',
				url: 'hop_checked2.php',
				data: 'id='+id+'&c='+c,
				error: function(){alert('fonction introuvable');}
			});
		});
	});
	*/
	</script>
</head>

<body>
	<form id="hopitaux" action="" method="post">
	<p>Cochez les cases correspondants aux hôpitaux que l'on souhaite interroger</p>

<div id="div2">
	
	<fieldset id="field1">
		<legend>Main courante </legend>
		<table id="table_hop">
			<thead>
				<tr>
					<th>ID</th>
					<th>Hôpital</th>
					<th>sélection</th>
				</tr>
			</thead>
			<tbody>
				<?php while($rep = mysql_fetch_array($resultat)){ ?>
				<tr>
					<td><?php echo $rep['Hop_ID'];?></td>
					<td><?php echo Security::db2str($rep['Hop_nom']);?></td>
					<td>
						
						<input type="checkbox" name = "visible[]" value="<?php echo $rep[Hop_ID];?>" id="<?php echo $rep[Hop_ID];?>" onClick="check(<?php echo $rep[Hop_ID];?>)"
						<?php if (in_array($rep['Hop_ID'], $visible)) echo "checked";?>  <?// remplace hopVisible par visible ?>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</fieldset>
	<!--
	<p>
		<div>
			<input type="submit" name="ok" value ="valider">
		</div>
	</p>
	-->
</div>


</form>
</body>
</html>
