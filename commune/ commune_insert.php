 <?php
 // commune_insert.php
    include_once("dbConnection.php");
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
$sqlQuery = "INSERT INTO commune (com_ID , com_INSEE , commune_zip , canton_ID , adm_ID , pop90 , com_nom , vsav , smur , pop99 , L2y , L2x , Lx , Ly , X , Y , sex_X , sex_Y , top25 , secteur_apa_ID , secteur_smur_ID , secteur_adps_ID , carroyage ) VALUES ('$thisCom_ID' , '$thisCom_INSEE' , '$thisCommune_zip' , '$thisCanton_ID' , '$thisAdm_ID' , '$thisPop90' , '$thisCom_nom' , '$thisVsav' , '$thisSmur' , '$thisPop99' , '$thisL2y' , '$thisL2x' , '$thisLx' , '$thisLy' , '$thisX' , '$thisY' , '$thisSex_X' , '$thisSex_Y' , '$thisTop25' , '$thisSecteur_apa_ID' , '$thisSecteur_smur_ID' , '$thisSecteur_adps_ID' , '$thisCarroyage' )";
$result = MYSQL_QUERY($sqlQuery);

?>
A new record has been inserted in the database. Here is the information that has been inserted :- <br><br>

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

<?php
    include_once("footer.php");
?>