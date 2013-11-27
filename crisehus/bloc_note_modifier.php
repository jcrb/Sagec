<?php
/**
*
*	@version:		$Id: bloc_note_modifier.php 36 2008-02-22 16:05:49Z jcb $
*/
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$langue = $_SESSION['langue'];
$backPathToRoot = "../";
$titre_principal = "Direction Générale - Modifier un message";
include_once("cc_top.php");
include_once("cc_menu.php");
require $backPathToRoot."utilitaires/globals_string_lang.php";
require($backPathToRoot."dbConnection.php");
require($backPathToRoot."login/init_security.php");
require($backPathToRoot."html.php");
include_once("../header.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-15">
	<title>Liste des messages</title>
	<link rel="stylesheet" href="div.css" type="text/css" media="all" />
	<link rel="shortcut icon" href="../images/sagec67.ico" />
	<script  type="text/javascript" src="../utilitaires.js"></script>
		<script src="../tinymce/tiny_mce/tiny_mce.js" type="text/javascript"></script>
		<script src="../tinymce/textarea.js" type="text/javascript"></script>
	</HEAD>
<?php
$thisLB_ID = $_REQUEST['LB_IDField'];
$thisLB_IDFromForm = $_REQUEST['thisLB_IDField'];
$thisAction = $_REQUEST['submitUpdateLivrebordForm'];
if ($thisAction=="Enregistrer la modification")
{
    // Retreiving Form Elements from Form
    $thisLB_ID = addslashes($_REQUEST['thisLB_IDField']);
    $thisOrg_ID = addslashes($_REQUEST['thisOrg_IDField']);
    $thisLB_Expediteur = addslashes($_REQUEST['thisLB_ExpediteurField']);
    $thisLB_Date = addslashes($_REQUEST['thisLB_DateField']);
    $thisLB_Message = addslashes($_REQUEST['thisLB_MessageField']);

    $sqlUpdate = "UPDATE livrebord_service SET LBS_ID = '$thisLB_ID' , org_ID = '$thisOrg_ID' , LBS_Expediteur = '$thisLB_Expediteur' , LBS_Date = '$thisLB_Date' , LBS_Message = '$thisLB_Message'  WHERE LBS_ID = '$thisLB_ID'";
    $resultUpdate = MYSQL_QUERY($sqlUpdate);
    echo "<b>L'enregistrement n° ".$thisLB_IDFromForm." a été mis à jour<br></b>";
    $thisLB_IDFromForm = "";
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

    $sqlDelete = "DELETE FROM livrebord_service WHERE LBS_ID = '$thisLB_ID'";
    $resultDelete = MYSQL_QUERY($sqlDelete);

    echo "<b>Record with Id ".$thisLB_IDFromForm." has been Deleted<br></b>";
    $thisLB_IDFromForm = "";
	header("Location: blocnote_lire.php");
}

?>
<?php
$sql = "SELECT   * FROM livrebord_service WHERE LBS_ID = '$thisLB_ID'";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);
if ($numberOfRows==0) {
?>

Désolé, aucun enregistrement n'a été trouvé !!

<?php
}
else if ($numberOfRows>0) {

    $i=0;
    $thisLB_ID = MYSQL_RESULT($result,$i,"LBS_ID");
    $thisOrg_ID = MYSQL_RESULT($result,$i,"org_ID");
    $thisLB_Expediteur = MYSQL_RESULT($result,$i,"LBS_Expediteur");
    $thisLB_Date = MYSQL_RESULT($result,$i,"LBS_Date");
    $thisLB_Message = Security::db2str(MYSQL_RESULT($result,$i,"LBS_Message"));

}
?>

<h2>Modification d'un enregistrement du Livre de bord</h2>
<form name="livrebordUpdateForm" method="POST" action="bloc_note_modifier.php">

<table cellspacing="2" cellpadding="2" border="0" width="100%">
    <tr valign="top" height="20">
        <td align="right"> <b> LB_ID : </b> </td>
        <td> <input type="text" Readonly  name="thisLB_IDField" size="20" value="<? echo $thisLB_ID; ?>">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Org_ID : </b> </td>
        <td> <input type="text" Readonly  name="thisOrg_IDField" size="20" value="<? echo $thisOrg_ID; ?>">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> LB_Expediteur : </b> </td>
        <td> <input type="text" Readonly  name="thisLB_ExpediteurField" size="20" value="<? echo $thisLB_Expediteur; ?>">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> LB_Date : </b> </td>
        <td> <input type="text" nReadonly  name="thisLB_DateField" size="20" value="<? echo $thisLB_Date; ?>">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> LB_Message : </b> </td>

		<td> <TEXTAREA COLS="60" ROWS="5" NAME="thisLB_MessageField"><? echo $thisLB_Message; ?> </TEXTAREA> </td>

    </tr>
</table>

<input type="submit" name="submitUpdateLivrebordForm" value="Enregistrer la modification">
<input type="reset" name="resetForm" value="Clear Form">
<input type = "submit" name = "submitUpdateLivrebordForm" value="Supprimer" onCLick="return confirm('Etes-vous s de vouloir supprimer cet enregistrement?')">
<a href="blocnote_lire.php"> Retour au livre de bord"</a>

</form>

<?php
  include_once("./../footer.php");
?>