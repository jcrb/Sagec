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
  * programme: 			admin_check_nouveau.php
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
$titre_principal = "Mise à jour des checklistes";
include_once("cc_top.php");
include_once("admin_check_menu.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
require("cc_utilitaires.php");

$tacheID = $_REQUEST[tacheID];

if($tacheID)
{
	$requete="SELECT * FROM tache_DG WHERE tache_ID='$tacheID'";
	$resultat = ExecRequete($requete,$connexion);
	$rep = mysql_fetch_array($resultat);
}
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
	
	<script src="../tinymce/tiny_mce/tiny_mce.js" type="text/javascript"></script>
		<script type="text/javascript">// <![CDATA[
			tinyMCE.init({
    mode : "textareas",
    language : "fr",
    theme : "advanced",
    plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

        // Theme options
        theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,

        // Skin options
        skin : "o2k7",
        skin_variant : "silver",

        // Example content CSS (should be your site CSS)
        content_css : "css/example.css",

        // Drop lists for link/image/media/template dialogs
        template_external_list_url : "js/template_list.js",
        external_link_list_url : "js/link_list.js",
        external_image_list_url : "js/image_list.js",
        media_external_list_url : "js/media_list.js",

        // Replace values for the template plugin
        template_replace_values : {
                username : "Some User",
                staffid : "991234"}

			});
			// ]]>
			</script>
</head>

<body onload="document.getElementById('nom').focus()">

<form name="npuvelle_tache" action= "admin_check_enregistre.php" method = "post">
<input type="hidden" name="id" value="<?php echo $tacheID;?>">
<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend> Saisir/modifier une tache </legend>
		
		<p>
			<label for="nom" title="">intitulé :</label>
			<input type="text" id="" name="nom" size="70" value="<?php echo Security::db2str($rep[tache_nom]);?>" title=""/>
		</p>
		<p>
			<label for="short" title="">priorité :</label>
			<input type="text" id="" name="priorite" size="10" value="<?php echo Security::db2str($rep[tache_priorite]);?>" title=""/>
			<spam class="exemple">(entre 1 et 99)</spam>
		</p>
		<p>
			<label for="visible" title="">fonction :</label>
			<?php SelectFonction($connexion,$rep['tache_fonction']);?>
		</p>
		<p>
			<label for="visible" title="">commentaire :</label>
			<textarea rows="5" cols="80" name="comment"><?php echo Security::db2str($rep[tache_comment]);?></textarea>
		</p>
		<p>
			<label for="visible" title="">message :</label>
			<textarea rows="5" cols="80" name="message"><?php echo Security::db2str($rep[tache_message]);?></textarea>
		</p>


<br />

		<p>			
			<input type="submit" name="BtnSubmit" id="valid" value="Valider" />
			<input type="reset" name="BtnClear" id="annul" value="Annuler" />
		</p>
	</div>

<?php
?>

</form>
</body>
</html>