<?php
/**
*	tache_nouvelle.php
*	crée ou modifie une tache
*/
session_start();
$backPathToRoot = "../../";
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
$tacheID = $_REQUEST[tacheID];

if($tacheID)
{
	$requete="SELECT * FROM tache WHERE tache_ID='$tacheID'";
	$resultat = ExecRequete($requete,$connexion);
	$rep = mysql_fetch_array($resultat);
}
?>
<head>
	<title>Spécialité médicale</title>
	<meta http-equiv="content-type" content="t="text/h; charset=ISO-8859-1" 1>
	<link rel="shortcut icon" href="./../../images/sagec67.ico" />
	<link href="../formstyle.css" rel="stylesheet" type="text/css" />
	<link rel="shortcut icon" href="../../images/sagec67.ico" /> 
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

<body onload="">
	<form id="cat" action="tache_enregistre.php" method="post">
	<input type="hidden" name="tacheID" value ="<?php echo $tacheID; ?>">
	<div id="formtitle">PLAN BLANC - Tâche <?php if($tacheID)echo 'Mise à jour';else echo 'nouvelle' ?></div>
	<div id="content">
	<fieldset id="coordonnees">
		<legend>Caractéristique</legend>
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
			<label for="visible" title="">commentaire :</label>
			<textarea rows="5" cols="80" name="comment"><?php echo Security::db2str($rep[tache_comment]);?></textarea>
		</p>
		<p>
			<label for="visible" title="">message :</label>
			<textarea rows="5" cols="80" name="message"><?php echo Security::db2str($rep[tache_message]);?></textarea>
		</p>
	</fieldset>
	<br />

	
	</div>
	<div id="formfooter">
		<p>			
			<input type="submit" name="BtnSubmit" id="valid" value="Valider" />
			<input type="reset" name="BtnClear" id="annul" value="Annuler" />
		</p>
	</div>
	</form>
</body>

</html>
