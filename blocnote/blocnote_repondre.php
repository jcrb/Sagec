<?php
/**
*	blocnote_repondre.php
*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../"; 
include_once($backPathToRoot."dbConnection.php");
include_once("blocnote_menu2.php");
require($backPathToRoot."date.php");
$back = $_REQUEST['back'];

entete("Main courante - Répondre à un message",$back);

$question_ID = $_REQUEST[LB_IDField];
//print("label = ".$question_ID);
//print("auteur = ".$_SESSION[member_id]);
// heure de la réponse
$timestamp = date("Y-m-j H:i:s");

?>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
		<link REL=stylesheet HREF="../pma.css" TYPE ="text/css">
		<link rel="shortcut icon" href="../images/sagec67.ico" />
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
	<body>
		<form name="reponse" method ="post" action="blocnote_enregistre.php?back=<?php echo $back;?>">
		<input type="hidden" name="iqr" value="3"> <!--// c'est une réponse -->

<?php
/** récupère la question et son auteur */
print("<input type=\"hidden\" name=\"idQuestion\" value=\"$question_ID\">");
print("<input type=\"hidden\" name=\"auteur\" value=\"$_SESSION[member_id]\">");
print("<INPUT TYPE=\"hidden\" NAME=\"date\" VALUE=\"$timestamp\">");
print("<INPUT TYPE=\"hidden\" NAME=\"irq\" VALUE=\"3\">");
print("<INPUT TYPE=\"HIDDEN\" NAME=\"visible\" VALUE=\"n\">");

$requete = "SELECT *
				FROM livrebord 
				WHERE LB_ID = '$question_ID'
				";
$resultat = ExecRequete($requete,$connexion);
$rep = mysql_fetch_array($resultat);
?>


<DIV STYLE="width: 50%; ">
	<fieldset id="field1" STYLE="8px ridge #ff00ff ;background-color: yellow ; color: black; ">
		<legend style="color: #ff0000; font-family: verdana; font-size: 14pt;"> Question</legend>
		<p>
			<?php echo stripslashes($rep[LB_Message])?>
		</p>
	</fieldset>
</div>


<?php
	$requete = "SELECT LB_Message,LB_Expediteur,LB_Date,nom
					FROM livrebord, livrebordQR,utilisateurs
					WHERE livrebord.LB_ID = livrebordQR.reponse_ID
					AND livrebordQR.question_ID = '$question_ID'
					AND LB_Expediteur = ID_utilisateur
					";
	$resultat = ExecRequete($requete,$connexion);

	while($rep = mysql_fetch_array($resultat))
	{	
		?>
			<div id="div2" style="width: 50%;">
				<fieldset id="field1" style="background-color: #FFFFCC ;">
				<legend><?php echo $rep[nom].' le '.$rep[LB_Date];?></legend>
				<p>
					<?php echo $rep[LB_Message]; ?>
				</p>
				</fieldset>
			</div>
		<?php
	}
	?>

<div id="div2" style="width: 50%;">
	<fieldset id="field1">
		<legend> Ajouter un commentaire </legend>
		<TEXTAREA style="width: 100%;" NAME="montexte"></TEXTAREA>
		<input type="submit" name="valider" value="Repondre">
	</fieldset>
</div>

</form>
</body>
</html>