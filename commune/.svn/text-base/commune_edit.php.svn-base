 <?php
 // commune_edit.php
    include_once("../dbConnection.php");
    include_once("header.php");
?>
<?php
$thisCom_ID = $_REQUEST['com_IDField']
?>
<?php
$sql = "SELECT   * FROM commune WHERE com_ID = '$thisCom_ID'";
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUMROWS($result);
if ($numberOfRows==0) {
?>

Désolé. aucun enregistrement ne correspond !!

<?php
}
else if ($numberOfRows>0) {

    $i=0;
    $thisCom_ID = MYSQL_RESULT($result,$i,"com_ID");
    $thisCom_INSEE = MYSQL_RESULT($result,$i,"com_INSEE");
    $thisCommune_zip = MYSQL_RESULT($result,$i,"commune_zip");
    $thisCanton_ID = MYSQL_RESULT($result,$i,"canton_ID");
    $thisAdm_ID = MYSQL_RESULT($result,$i,"adm_ID");
    $thisPop90 = MYSQL_RESULT($result,$i,"pop90");
    $thisCom_nom = MYSQL_RESULT($result,$i,"com_nom");
    $thisVsav = MYSQL_RESULT($result,$i,"vsav");
    $thisSmur = MYSQL_RESULT($result,$i,"smur");
    $thisPop99 = MYSQL_RESULT($result,$i,"pop99");
    $thisL2y = MYSQL_RESULT($result,$i,"L2y");
    $thisL2x = MYSQL_RESULT($result,$i,"L2x");
    $thisLx = MYSQL_RESULT($result,$i,"Lx");
    $thisLy = MYSQL_RESULT($result,$i,"Ly");
    $thisX = MYSQL_RESULT($result,$i,"X");
    $thisY = MYSQL_RESULT($result,$i,"Y");
    $thisSex_X = MYSQL_RESULT($result,$i,"sex_X");
    $thisSex_Y = MYSQL_RESULT($result,$i,"sex_Y");
    $thisTop25 = MYSQL_RESULT($result,$i,"top25");
    $thisSecteur_apa_ID = MYSQL_RESULT($result,$i,"secteur_apa_ID");
    $thisSecteur_smur_ID = MYSQL_RESULT($result,$i,"secteur_smur_ID");
    $thisSecteur_adps_ID = MYSQL_RESULT($result,$i,"secteur_adps_ID");
    $thisCarroyage = MYSQL_RESULT($result,$i,"carroyage");
	$thisTerritoire_sante = MYSQL_RESULT($result,$i,"territoire_sante");
}
?>

<h2>Update Commune</h2>
<form name="communeUpdateForm" method="POST" action="commune_update.php">

<table cellspacing="2" cellpadding="2" border="0" width="100%">
    <tr valign="top" height="20">
        <td align="right"> <b> Com_ID : </b> </td>
        <td> <input type="text" name="thisCom_IDField" size="20" value="<? echo $thisCom_ID; ?>">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Com_INSEE : </b> </td>
        <td> <input type="text" name="thisCom_INSEEField" size="20" value="<? echo $thisCom_INSEE; ?>">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Commune_zip : </b> </td>
        <td> <input type="text" name="thisCommune_zipField" size="20" value="<? echo $thisCommune_zip; ?>">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Canton_ID : </b> </td>
        <td> <input type="text" name="thisCanton_IDField" size="20" value="<? echo $thisCanton_ID; ?>">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Adm_ID : </b> </td>
        <td> <input type="text" name="thisAdm_IDField" size="20" value="<? echo $thisAdm_ID; ?>">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Pop90 : </b> </td>
        <td> <input type="text" name="thisPop90Field" size="20" value="<? echo $thisPop90; ?>">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Com_nom : </b> </td>
        <td> <input type="text" name="thisCom_nomField" size="20" value="<? echo $thisCom_nom; ?>">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Vsav : </b> </td>
        <td> <input type="text" name="thisVsavField" size="20" value="<? echo $thisVsav; ?>">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Smur : </b> </td>
        <td> <input type="text" name="thisSmurField" size="20" value="<? echo $thisSmur; ?>">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Pop99 : </b> </td>
        <td> <input type="text" name="thisPop99Field" size="20" value="<? echo $thisPop99; ?>">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> L2y : </b> </td>
        <td> <input type="text" name="thisL2yField" size="20" value="<? echo $thisL2y; ?>">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> L2x : </b> </td>
        <td> <input type="text" name="thisL2xField" size="20" value="<? echo $thisL2x; ?>">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Lx : </b> </td>
        <td> <input type="text" name="thisLxField" size="20" value="<? echo $thisLx; ?>">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Ly : </b> </td>
        <td> <input type="text" name="thisLyField" size="20" value="<? echo $thisLy; ?>">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> X : </b> </td>
        <td> <input type="text" name="thisXField" size="20" value="<? echo $thisX; ?>">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Y : </b> </td>
        <td> <input type="text" name="thisYField" size="20" value="<? echo $thisY; ?>">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Sex_X : </b> </td>
        <td> <input type="text" name="thisSex_XField" size="20" value="<? echo $thisSex_X; ?>">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Sex_Y : </b> </td>
        <td> <input type="text" name="thisSex_YField" size="20" value="<? echo $thisSex_Y; ?>">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Top25 : </b> </td>
        <td> <input type="text" name="thisTop25Field" size="20" value="<? echo $thisTop25; ?>">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Secteur_apa_ID : </b> </td>
        <td> <input type="text" name="thisSecteur_apa_IDField" size="20" value="<? echo $thisSecteur_apa_ID; ?>">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Secteur_smur_ID : </b> </td>
        <td> <input type="text" name="thisSecteur_smur_IDField" size="20" value="<? echo $thisSecteur_smur_ID; ?>">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Secteur_adps_ID : </b> </td>
        <td> <input type="text" name="thisSecteur_adps_IDField" size="20" value="<? echo $thisSecteur_adps_ID; ?>">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Carroyage : </b> </td>
        <td> <input type="text" name="thisCarroyageField" size="20" value="<? echo $thisCarroyage; ?>">  </td>
    </tr>
	<tr valign="top" height="20">
        <td align="right"> <b> Territoire de santé : </b> </td>
        <td> <input type="text" name="thisTerritoire_santeField" size="20" value="<? echo $thisTerritoire_sante; ?>">  </td>
    </tr>
</table>

<input type="submit" name="submitUpdateCommuneForm" value="Update Commune">
<input type="reset" name="resetForm" value="Clear Form">

</form>

<?php
    include_once("../footer.php");
?>