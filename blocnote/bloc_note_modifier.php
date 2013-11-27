<?php
/**
*	bloc_note_modifier.php
*	permet de modifier un message
*	seul l'administrateur ou l'auteur du message peut le modifier
*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$langue = $_SESSION['langue'];
$backPathToRoot = "../"; 
include_once($backPathToRoot."dbConnection.php");
include_once("blocnote_menu2.php");

$back = $_REQUEST['back'];
entete("Main courante - Modifier un message",$back);

?>
<HTML>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
		<link rel="shortcut icon" href="../images/sagec67.ico" />
		<TITLE>Modifier un messages</TITLE>
		<LINK REL=stylesheet HREF="../pma.css" TYPE ="text/css">
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
	</HEAD>
	
	<body>
	<form name="blocnote" method="post" action="">
<?php

$thisLB_ID = $_REQUEST['LB_IDField'];
$thisLB_IDFromForm = $_REQUEST['thisLB_IDField'];
$thisAction = $_REQUEST['submitUpdateLivrebordForm'];

print("<input type=\"hidden\" name=\"back\" value=\"$back\">");

if ($thisAction=="Enregistrer la modification")
{
    // Retreiving Form Elements from Form
    $thisLB_ID = addslashes($_REQUEST['LB_IDField']);
    $thisOrg_ID = addslashes($_REQUEST['org_ID']);
    $thisLB_Expediteur = addslashes($_REQUEST['thisLB_ExpediteurField']);
    $thisLB_Date = addslashes($_REQUEST['thisLB_DateField']);
    $thisLB_Message = addslashes($_REQUEST['thisLB_MessageField']);
    $thisLB_Message .= " [modifié par ".$thisLB_Expediteur."]";

    $sqlUpdate = "UPDATE livrebord 
    					SET LB_ID = '$thisLB_ID' , org_ID = '$thisOrg_ID' , LB_Expediteur = '$thisLB_Expediteur' , LB_Date = '$thisLB_Date' , LB_Message = '$thisLB_Message'  
    					WHERE LB_ID = '$thisLB_ID'";
    $resultUpdate = MYSQL_QUERY($sqlUpdate);
    echo "<b>L'enregistrement n° ".$thisLB_ID." a été mis à jour<br></b>";
    $thisLB_IDFromForm = "";
    //print($sqlUpdate."<br>");
}
elseif ($thisAction=="Retour au livre de bord")
{
	header("Location: blocnote_lire.php");
}
elseif ($thisAction=="Supprimer")
{
    // Retreiving Form Elements from Form
    $thisLB_ID = addslashes($_REQUEST['thisLB_IDField']);
    $thisOrg_ID = addslashes($_REQUEST['thisOrg_IDField']);
    $thisLB_Expediteur = addslashes($_REQUEST['thisLB_ExpediteurField']);
    $thisLB_Date = addslashes($_REQUEST['thisLB_DateField']);
    $thisLB_Message = addslashes($_REQUEST['thisLB_MessageField']);

    $sqlDelete = "DELETE FROM livrebord WHERE LB_ID = '$thisLB_ID'";
    $resultDelete = MYSQL_QUERY($sqlDelete);
    // détruit les réponses associées 
    $requete = "SELECT qr_ID,reponse_ID FROM livrebordQR WHERE question_ID = '$thisLB_ID'";
    $resultat = MYSQL_QUERY($requete);
    while($rep=mysql_fetch_array($resultat))
    {
    	$sqlDelete = "DELETE FROM livrebord WHERE LB_ID = '$rep[reponse_ID]'";
    	$resultDelete = MYSQL_QUERY($sqlDelete);
    	$sqlDelete = "DELETE FROM livrebordQR WHERE qr_ID = '$rep[qr_ID]'";
    	$resultDelete = MYSQL_QUERY($sqlDelete);
    }

    echo "<b><color=\"red\">Le message n° ".$thisLB_IDFromForm." a été détruit<br></color></b>";
    $thisLB_IDFromForm = "";
	//header("Location: blocnote_lire.php");
}

?>
<?php
$sql = "SELECT   * FROM livrebord WHERE LB_ID = '$thisLB_ID'";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);
if ($numberOfRows==0)
{
	?>
	Désolé, aucun enregistrement n'a été trouvé !!
	<?php
}
else if ($numberOfRows > 0) 
{

    $i=0;
    $thisLB_ID = MYSQL_RESULT($result,$i,"LB_ID");
    $thisOrg_ID = MYSQL_RESULT($result,$i,"org_ID");
    print("<input type=\"hidden\" name=\"org_ID\" value=\"$thisOrg_ID\" >");
    $thisLB_Expediteur = MYSQL_RESULT($result,$i,"LB_Expediteur");
    $thisLB_Date = MYSQL_RESULT($result,$i,"LB_Date");
    $thisLB_Message = MYSQL_RESULT($result,$i,"LB_Message");

}
?>

<h2>Modification d'un enregistrement du Livre de bord</h2>
<form name="livrebordUpdateForm" method="POST" action="bloc_note_modifier.php">

<table cellspacing="2" cellpadding="2" border="0" width="100%">
    
    <tr valign="top" height="20">
        <td align="right"> <b> Expediteur : </b> </td>
        <td> <input type="text" Readonly  name="thisLB_ExpediteurField" size="20" value="<? echo $thisLB_Expediteur; ?>">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Date : </b> </td>
        <td> <input type="text" nReadonly  name="thisLB_DateField" size="20" value="<? echo $thisLB_Date; ?>">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Message : </b> </td>
        
       <td><textarea style="width: 50%;" name="thisLB_MessageField"><? echo stripslashes($thisLB_Message); ?> </textarea></td>
		<!--
		<td> <TEXTAREA COLS="60" ROWS="5" NAME="thisLB_MessageField"><? echo stripslashes($thisLB_Message); ?> </TEXTAREA> </td>
		-->
    </tr>
</table>

<input type="submit" name="submitUpdateLivrebordForm" value="Enregistrer la modification">
<input type = "submit" name = "submitUpdateLivrebordForm" value="Supprimer" onCLick="return confirm('Etes-vous s de vouloir supprimer cet enregistrement?')">

</form>

<?php
    include_once($backPathToRoot."footer.php");
?>