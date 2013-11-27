 <?php
 // commune_update.php
    include_once("../dbConnection.php");
    include_once("header.php");
?>
<?php
    // Retreiving Form Elements from Form
    $thisCom_ID = addslashes($_REQUEST['thisCom_IDField']);
    $thisCom_INSEE = addslashes($_REQUEST['thisCom_INSEEField']);
    $thisCommune_zip = addslashes($_REQUEST['thisCommune_zipField']);
    $thisCanton_ID = addslashes($_REQUEST['thisCanton_IDField']);
    $thisAdm_ID = addslashes($_REQUEST['thisAdm_IDField']);
    $thisPop90 = addslashes($_REQUEST['thisPop90Field']);
    $thisCom_nom = addslashes($_REQUEST['thisCom_nomField']);
    $thisVsav = addslashes($_REQUEST['thisVsavField']);
    $thisSmur = addslashes($_REQUEST['thisSmurField']);
    $thisPop99 = addslashes($_REQUEST['thisPop99Field']);
    $thisL2y = addslashes($_REQUEST['thisL2yField']);
    $thisL2x = addslashes($_REQUEST['thisL2xField']);
    $thisLx = addslashes($_REQUEST['thisLxField']);
    $thisLy = addslashes($_REQUEST['thisLyField']);
    $thisX = addslashes($_REQUEST['thisXField']);
    $thisY = addslashes($_REQUEST['thisYField']);
    $thisSex_X = addslashes($_REQUEST['thisSex_XField']);
    $thisSex_Y = addslashes($_REQUEST['thisSex_YField']);
    $thisTop25 = addslashes($_REQUEST['thisTop25Field']);
    $thisSecteur_apa_ID = addslashes($_REQUEST['thisSecteur_apa_IDField']);
    $thisSecteur_smur_ID = addslashes($_REQUEST['thisSecteur_smur_IDField']);
    $thisSecteur_adps_ID = addslashes($_REQUEST['thisSecteur_adps_IDField']);
    $thisCarroyage = addslashes($_REQUEST['thisCarroyageField']);

?>
<?
$sql = "UPDATE commune SET com_ID = '$thisCom_ID' , com_INSEE = '$thisCom_INSEE' , commune_zip = '$thisCommune_zip' , canton_ID = '$thisCanton_ID' , adm_ID = '$thisAdm_ID' , pop90 = '$thisPop90' , com_nom = '$thisCom_nom' , vsav = '$thisVsav' , smur = '$thisSmur' , pop99 = '$thisPop99' , L2y = '$thisL2y' , L2x = '$thisL2x' , Lx = '$thisLx' , Ly = '$thisLy' , X = '$thisX' , Y = '$thisY' , sex_X = '$thisSex_X' , sex_Y = '$thisSex_Y' , top25 = '$thisTop25' , secteur_apa_ID = '$thisSecteur_apa_ID' , secteur_smur_ID = '$thisSecteur_smur_ID' , secteur_adps_ID = '$thisSecteur_adps_ID' , carroyage = '$thisCarroyage'  WHERE com_ID = '$thisCom_ID'";
$result = MYSQL_QUERY($sql);

?>
Record  has been updated in the database. Here is the updated information :- <br><br>

<table>
<tr height="30">
    <td align="right"><b>Com_ID : </b></td>
    <td><? echo $thisCom_ID; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Com_INSEE : </b></td>
    <td><? echo $thisCom_INSEE; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Commune_zip : </b></td>
    <td><? echo $thisCommune_zip; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Canton_ID : </b></td>
    <td><? echo $thisCanton_ID; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Adm_ID : </b></td>
    <td><? echo $thisAdm_ID; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Pop90 : </b></td>
    <td><? echo $thisPop90; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Com_nom : </b></td>
    <td><? echo $thisCom_nom; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Vsav : </b></td>
    <td><? echo $thisVsav; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Smur : </b></td>
    <td><? echo $thisSmur; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Pop99 : </b></td>
    <td><? echo $thisPop99; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>L2y : </b></td>
    <td><? echo $thisL2y; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>L2x : </b></td>
    <td><? echo $thisL2x; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Lx : </b></td>
    <td><? echo $thisLx; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Ly : </b></td>
    <td><? echo $thisLy; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>X : </b></td>
    <td><? echo $thisX; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Y : </b></td>
    <td><? echo $thisY; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Sex_X : </b></td>
    <td><? echo $thisSex_X; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Sex_Y : </b></td>
    <td><? echo $thisSex_Y; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Top25 : </b></td>
    <td><? echo $thisTop25; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Secteur_apa_ID : </b></td>
    <td><? echo $thisSecteur_apa_ID; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Secteur_smur_ID : </b></td>
    <td><? echo $thisSecteur_smur_ID; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Secteur_adps_ID : </b></td>
    <td><? echo $thisSecteur_adps_ID; ?></td>
</tr>
<tr height="30">
    <td align="right"><b>Carroyage : </b></td>
    <td><? echo $thisCarroyage; ?></td>
</tr>
</table>
<br><br><a href="commune_listing.php">Retour à la liste de tous les enregistrements</a>

<?php
    include_once("../footer.php");
?>