<?php
//----------------------------------------- SAGEC --------------------------------------------------------

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
//													//
//	programme: 		bloc_note.php								//
//	date de création: 	18/08/2003								//
//	auteur:			jcb									//
//	description:		Enregistre une information rextuelle					//
//													//
//	version:		1.1									//
//	maj le:			09/04/2004								//
//													//
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../../";
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."date.php");
require $backPathToRoot.'utilitaires/globals_string_lang.php';
include($backPathToRoot."login/init_security.php");
include_once("top.php");
include_once("menu.php");

$query = "SELECT nom, prenom FROM utilisateurs WHERE ID_utilisateur = '$_SESSION[member_id]'";
$result = ExecRequete($query,$connexion);
$utilisateur = LigneSuivante($result);
$mot = $string_lang['BLOCNOTE'][$langue];
$timestamp = time();
$date = dateHeureComplete(time(),$langue);

$info = $_REQUEST['info'];
if($info =='')$info='message non enregistre';

//print_r($_REQUEST);
/** si le message existe */
$messageID = $_REQUEST[messageID];
if($messageID > 0)
{
	$requete = "SELECT * FROM livrebord_service WHERE LBS_ID = '$messageID'";
	$result = ExecRequete($requete,$connexion);
	$rep = mysql_fetch_array($result);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Liste des messages</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="stylesheet" href="../top.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../../images/sagec67.ico" />
	<script  type="text/javascript" src="../../utilitaires.js"></script>
	<script src="../../tinymce/tiny_mce/tiny_mce.js" type="text/javascript"></script>
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

<body onload="document.getElementById('message').focus()">
	<form name="blocnote" method="post" action="message_enregistre.php">
	<table class="table50">
		<tr>
			<td><?php echo $string_lang['AUTEUR'][$langue]; ?></td>
			<td><?php echo $utilisateur->prenom." ".$utilisateur->nom; ?></td>
		</tr>
		<tr>
			<td><?php echo $string_lang['DATE'][$langue]; ?></td>
			<td><?php echo $date; ?></td>
		</tr>
		<tr>
			<td><?php echo $string_lang['MESSAGE'][$langue]; ?></td>
			<td><TEXTAREA style="width: 80%;" NAME="message"><?php echo Security::db2str($rep['LBS_message']);?></TEXTAREA></td>
		</tr>

		<tr>
			<td>Valeur</td>
		<td><input type="radio" name="irq" value="1" <? if($rep['LBS_irq']==1)echo checked;?> > message
			<input type="radio" name="irq" value="2" <? if($rep['LBS_irq']==2)echo checked;?> > important
			<input type="radio" name="irq" value="3" <? if($rep['LBS_irq']==3)echo checked;?> > question</td>
		</tr>
		<tr>
			<td><INPUT TYPE="SUBMIT" VALUE="<?php echo $string_lang['VALIDER'][$langue]; ?>" NAME="VALIDER" id="soumettre"></td>
			<td><?php echo $info; ?></td>
		</tr>
	</table>
	<INPUT TYPE="HIDDEN" NAME="date" VALUE="<?php echo $timestamp; ?>">
	<INPUT TYPE="HIDDEN" NAME="auteur" VALUE="<?php echo $_SESSION[member_id]; ?>">
	<INPUT TYPE="HIDDEN" NAME="visible" VALUE="o">
	<input type="hidden" name="groupe" value='1'>
	<input type="hidden" name="messageID" value="<?php echo $messageID; ?>">
	</form>
</body>
</HTML>