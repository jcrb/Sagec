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
/**													
*	programme 			blocnote_perso_modifie.php
*	@date de cr�ation: 	05/11/2006
*	@author:			jcb
*	description:		Nouveau message dans le bloc note perso
*	@version:			1.0 - $ $
*	maj le:				05/11/2006
*	@package			Sagec
*/													
//---------------------------------------------------------------------------------------------------------
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
    include_once("../dbConnection.php");
    include_once("../header.php");

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

    $sqlUpdate = "UPDATE livrebord SET LB_ID = '$thisLB_ID' , org_ID = '$thisOrg_ID' , LB_Expediteur = '$thisLB_Expediteur' , LB_Date = '$thisLB_Date' , LB_Message = '$thisLB_Message'  WHERE LB_ID = '$thisLB_ID'";
    $resultUpdate = MYSQL_QUERY($sqlUpdate);
    echo "<b>L'enregistrement n� ".$thisLB_IDFromForm." a �t� mis � jour<br></b>";
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

    $sqlDelete = "DELETE FROM livrebord WHERE LB_ID = '$thisLB_ID'";
    $resultDelete = MYSQL_QUERY($sqlDelete);

    echo "<b>Record with Id ".$thisLB_IDFromForm." has been Deleted<br></b>";
    $thisLB_IDFromForm = "";
	header("Location: blocnote_lire.php");
}

?>
<?php
$sql = "SELECT   * FROM livrebord WHERE LB_ID = '$thisLB_ID'";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);
if ($numberOfRows==0) {
?>

D�sol�, aucun enregistrement n'a �t� trouv� !!

<?php
}
else if ($numberOfRows>0) {

    $i=0;
    $thisLB_ID = MYSQL_RESULT($result,$i,"LB_ID");
    $thisOrg_ID = MYSQL_RESULT($result,$i,"org_ID");
    $thisLB_Expediteur = MYSQL_RESULT($result,$i,"LB_Expediteur");
    $thisLB_Date = MYSQL_RESULT($result,$i,"LB_Date");
    $thisLB_Message = MYSQL_RESULT($result,$i,"LB_Message");

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
    include_once("footer.php");
?>