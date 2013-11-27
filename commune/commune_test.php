 <?php
    include_once("../dbConnection.php");
    include_once("header.php");
?>
<?
$thisCom_IDFromForm = $_REQUEST['thisCom_IDField'];
$thisAction = $_REQUEST['action'];
if ($thisAction=="Update")
{
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
	$thisTerritoire_sante = addslashes($_REQUEST['thisTerritoire_sante']);

    $sqlUpdate = "UPDATE commune SET com_ID = '$thisCom_ID' , com_INSEE = '$thisCom_INSEE' , commune_zip = '$thisCommune_zip' , canton_ID = '$thisCanton_ID' , adm_ID = '$thisAdm_ID' , pop90 = '$thisPop90' , com_nom = '$thisCom_nom' , vsav = '$thisVsav' , smur = '$thisSmur' , pop99 = '$thisPop99' , L2y = '$thisL2y' , L2x = '$thisL2x' , Lx = '$thisLx' , Ly = '$thisLy' , X = '$thisX' , Y = '$thisY' , sex_X = '$thisSex_X' , sex_Y = '$thisSex_Y' , top25 = '$thisTop25' , secteur_apa_ID = '$thisSecteur_apa_ID' , secteur_smur_ID = '$thisSecteur_smur_ID' , secteur_adps_ID = '$thisSecteur_adps_ID' , carroyage = '$thisCarroyage', territoire_sante = 'thisTerritoire_sante' WHERE com_ID = '$thisCom_ID'";
    $resultUpdate = MYSQL_QUERY($sqlUpdate);
    echo "<b>Record with Id ".$thisCom_IDFromForm." has been Updated<br></b>";
    $thisCom_IDFromForm = "";
}

if ($thisAction=="Insert")
{
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
	$thisTerritoire_sante = addslashes($_REQUEST['thisTerritoire_sante']);

    $sqlInsert = "INSERT INTO commune (com_ID , com_INSEE , commune_zip , canton_ID , adm_ID , pop90 , com_nom , vsav , smur , pop99 , L2y , L2x , Lx , Ly , X , Y , sex_X , sex_Y , top25 , secteur_apa_ID , secteur_smur_ID , secteur_adps_ID , carroyage ) VALUES ('$thisCom_ID' , '$thisCom_INSEE' , '$thisCommune_zip' , '$thisCanton_ID' , '$thisAdm_ID' , '$thisPop90' , '$thisCom_nom' , '$thisVsav' , '$thisSmur' , '$thisPop99' , '$thisL2y' , '$thisL2x' , '$thisLx' , '$thisLy' , '$thisX' , '$thisY' , '$thisSex_X' , '$thisSex_Y' , '$thisTop25' , '$thisSecteur_apa_ID' , '$thisSecteur_smur_ID' , '$thisSecteur_adps_ID' , '$thisCarroyage', 'thisTerritoire_sante')";
    $resultInsert = MYSQL_QUERY($sqlInsert);
    echo "<b>Record has been inserted in Database<br></b>";
    $thisCom_IDFromForm = "";
}

if ($thisAction=="Delete")
{
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
	$thisTerritoire_sante = addslashes($_REQUEST['thisTerritoire_sante']);

    $sqlDelete = "DELETE FROM commune WHERE com_ID = '$thisCom_ID'";
    $resultDelete = MYSQL_QUERY($sqlDelete);

    echo "<b>L'enregistrement n° ".$thisCom_IDFromForm." a été supprimé<br></b>";
    $thisCom_IDFromForm = "";
}

$initStartLimit = 0;
$limitPerPage = 10;

$startLimit = $_REQUEST['startLimit'];
$numberOfRows = $_REQUEST['rows'];
$sortBy = $_REQUEST['sortBy'];
$sortOrder = $_REQUEST['sortOrder'];

if ($startLimit=="")
{
        $startLimit = $initStartLimit;
}

if ($numberOfRows=="")
{
        $numberOfRows = $limitPerPage;
}

if ($sortOrder=="")
{
        $sortOrder  = "DESC";
}
if ($sortOrder == "DESC") { $newSortOrder = "ASC"; } else  { $newSortOrder = "DESC"; }
$limitQuery = " LIMIT ".$startLimit.",".$numberOfRows;
$nextStartLimit = $startLimit + $limitPerPage;
$previousStartLimit = $startLimit - $limitPerPage;

if ($sortBy!="")
{
        $orderByQuery = " ORDER BY ".$sortBy." ".$sortOrder;
}


$sql = "SELECT   * FROM commune".$orderByQuery.$limitQuery;
$result = MYSQL_QUERY($sql);
$numberOfRows = MYSQL_NUM_ROWS($result);


?>
<?
if ($numberOfRows==0) {
?>

Sorry. No records found !!

<?
}
else if ($numberOfRows>0) {

    $i=0;
?>


<br>
<?
if ($_REQUEST['startLimit'] != "")
{
?>

<a href="<? echo  $_SERVER['PHP_SELF']; ?>?startLimit=<? echo $previousStartLimit; ?>&limitPerPage=<? echo $limitPerPage; ?>&sortBy=<? echo $sortBy; ?>&sortOrder=<? echo $sortOrder; ?>">Previous <? echo $limitPerPage; ?> Results</a>....
<? } ?>
<?
if ($numberOfRows == $limitPerPage)
{
?>
<a href="<? echo $_SERVER['PHP_SELF']; ?>?startLimit=<? echo $nextStartLimit; ?>&limitPerPage=<? echo $limitPerPage; ?>&sortBy=<? echo $sortBy; ?>&sortOrder=<? echo $sortOrder; ?>">Next <? echo $limitPerPage; ?> Results</a>
<? } ?>

<br><br>
<TABLE CELLSPACING="0" CELLPADDING="3" BORDER="0" WIDTH="100%">
    <TR>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=com_ID&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>Com_ID</B>
            </a>
</TD>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=com_INSEE&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>Com_INSEE</B>
            </a>
</TD>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=commune_zip&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>Commune_zip</B>
            </a>
</TD>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=canton_ID&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>Canton_ID</B>
            </a>
</TD>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=adm_ID&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>Adm_ID</B>
            </a>
</TD>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=pop90&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>Pop90</B>
            </a>
</TD>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=com_nom&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>Com_nom</B>
            </a>
</TD>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=vsav&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>Vsav</B>
            </a>
</TD>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=smur&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>Smur</B>
            </a>
</TD>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=pop99&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>Pop99</B>
            </a>
</TD>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=L2y&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>L2y</B>
            </a>
</TD>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=L2x&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>L2x</B>
            </a>
</TD>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=Lx&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>Lx</B>
            </a>
</TD>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=Ly&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>Ly</B>
            </a>
</TD>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=X&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>X</B>
            </a>
</TD>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=Y&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>Y</B>
            </a>
</TD>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=sex_X&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>Sex_X</B>
            </a>
</TD>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=sex_Y&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>Sex_Y</B>
            </a>
</TD>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=top25&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>Top25</B>
            </a>
</TD>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=secteur_apa_ID&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>Secteur_apa_ID</B>
            </a>
</TD>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=secteur_smur_ID&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>Secteur_smur_ID</B>
            </a>
</TD>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=secteur_adps_ID&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>Secteur_adps_ID</B>
            </a>
</TD>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=carroyage&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>Carroyage</B>
            </a>
</TD>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=territoire_sante&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>Territoire_Sante</B>
            </a>
</TD>
    </TR>
<?
if ($thisAction=="EnterNew")
{
?>
<FORM NAME="insertForm" METHOD="POST" ACTION="<? echo $_SERVER['PHP_SELF']; ?>">
<input type="hidden" name="action" value="Insert">
<input type="hidden" name="thisCom_IDField" value="<? echo $thisCom_ID; ?>">
    <TR BGCOLOR="#FF6666">
        <TD><input type"text" name="thisCom_IDField" value=""></TD>
        <TD><input type"text" name="thisCom_INSEEField" value=""></TD>
        <TD><input type"text" name="thisCommune_zipField" value=""></TD>
        <TD><input type"text" name="thisCanton_IDField" value=""></TD>
        <TD><input type"text" name="thisAdm_IDField" value=""></TD>
        <TD><input type"text" name="thisPop90Field" value=""></TD>
        <TD><input type"text" name="thisCom_nomField" value=""></TD>
        <TD><input type"text" name="thisVsavField" value=""></TD>
        <TD><input type"text" name="thisSmurField" value=""></TD>
        <TD><input type"text" name="thisPop99Field" value=""></TD>
        <TD><input type"text" name="thisL2yField" value=""></TD>
        <TD><input type"text" name="thisL2xField" value=""></TD>
        <TD><input type"text" name="thisLxField" value=""></TD>
        <TD><input type"text" name="thisLyField" value=""></TD>
        <TD><input type"text" name="thisXField" value=""></TD>
        <TD><input type"text" name="thisYField" value=""></TD>
        <TD><input type"text" name="thisSex_XField" value=""></TD>
        <TD><input type"text" name="thisSex_YField" value=""></TD>
        <TD><input type"text" name="thisTop25Field" value=""></TD>
        <TD><input type"text" name="thisSecteur_apa_IDField" value=""></TD>
        <TD><input type"text" name="thisSecteur_smur_IDField" value=""></TD>
        <TD><input type"text" name="thisSecteur_adps_IDField" value=""></TD>
        <TD><input type"text" name="thisCarroyageField" value=""></TD>
		<TD><input type"text" name="thisTerritoire_santeField" value=""></TD>
    <TD COLSPAN=2><input type="submit" name="Insert" Value="Insert Record"> </TD>
    </TR>
</FORM>

<?
 }
?>
<?
    while ($i<$numberOfRows)
    {

        if (($i%2)==0) { $bgColor = "#FFFFFF"; } else { $bgColor = "#C0C0C0"; }

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
if ($thisCom_IDFromForm == $thisCom_ID)
{

?>
<FORM NAME="editForm" METHOD="POST" ACTION="<? echo $_SERVER['PHP_SELF']; ?>">
<input type="hidden" name="action" value="Update">
<input type="hidden" name="thisCom_IDField" value="<? echo $thisCom_ID; ?>">
    <TR BGCOLOR="<? echo $bgColor; ?>">
        <TD><input type"text" name="thisCom_IDField" value="<? echo $thisCom_ID; ?>"></TD>
        <TD><input type"text" name="thisCom_INSEEField" value="<? echo $thisCom_INSEE; ?>"></TD>
        <TD><input type"text" name="thisCommune_zipField" value="<? echo $thisCommune_zip; ?>"></TD>
        <TD><input type"text" name="thisCanton_IDField" value="<? echo $thisCanton_ID; ?>"></TD>
        <TD><input type"text" name="thisAdm_IDField" value="<? echo $thisAdm_ID; ?>"></TD>
        <TD><input type"text" name="thisPop90Field" value="<? echo $thisPop90; ?>"></TD>
        <TD><input type"text" name="thisCom_nomField" value="<? echo $thisCom_nom; ?>"></TD>
        <TD><input type"text" name="thisVsavField" value="<? echo $thisVsav; ?>"></TD>
        <TD><input type"text" name="thisSmurField" value="<? echo $thisSmur; ?>"></TD>
        <TD><input type"text" name="thisPop99Field" value="<? echo $thisPop99; ?>"></TD>
        <TD><input type"text" name="thisL2yField" value="<? echo $thisL2y; ?>"></TD>
        <TD><input type"text" name="thisL2xField" value="<? echo $thisL2x; ?>"></TD>
        <TD><input type"text" name="thisLxField" value="<? echo $thisLx; ?>"></TD>
        <TD><input type"text" name="thisLyField" value="<? echo $thisLy; ?>"></TD>
        <TD><input type"text" name="thisXField" value="<? echo $thisX; ?>"></TD>
        <TD><input type"text" name="thisYField" value="<? echo $thisY; ?>"></TD>
        <TD><input type"text" name="thisSex_XField" value="<? echo $thisSex_X; ?>"></TD>
        <TD><input type"text" name="thisSex_YField" value="<? echo $thisSex_Y; ?>"></TD>
        <TD><input type"text" name="thisTop25Field" value="<? echo $thisTop25; ?>"></TD>
        <TD><input type"text" name="thisSecteur_apa_IDField" value="<? echo $thisSecteur_apa_ID; ?>"></TD>
        <TD><input type"text" name="thisSecteur_smur_IDField" value="<? echo $thisSecteur_smur_ID; ?>"></TD>
        <TD><input type"text" name="thisSecteur_adps_IDField" value="<? echo $thisSecteur_adps_ID; ?>"></TD>
        <TD><input type"text" name="thisCarroyageField" value="<? echo $thisCarroyage; ?>"></TD>
		<TD><input type"text" name="thisTerritoire_santeField" value="<? echo $thisTerritoire_sante; ?>"></TD>
    <TD COLSPAN=2><input type="button" name="Save" Value="Save" onClick="this.form.submit();"> </TD>
    </TR>
</FORM>

<?
} else {
?>
    <TR BGCOLOR="<? echo $bgColor; ?>">
        <TD><? echo $thisCom_ID; ?></TD>
        <TD><? echo $thisCom_INSEE; ?></TD>
        <TD><? echo $thisCommune_zip; ?></TD>
        <TD><? echo $thisCanton_ID; ?></TD>
        <TD><? echo $thisAdm_ID; ?></TD>
        <TD><? echo $thisPop90; ?></TD>
        <TD><? echo $thisCom_nom; ?></TD>
        <TD><? echo $thisVsav; ?></TD>
        <TD><? echo $thisSmur; ?></TD>
        <TD><? echo $thisPop99; ?></TD>
        <TD><? echo $thisL2y; ?></TD>
        <TD><? echo $thisL2x; ?></TD>
        <TD><? echo $thisLx; ?></TD>
        <TD><? echo $thisLy; ?></TD>
        <TD><? echo $thisX; ?></TD>
        <TD><? echo $thisY; ?></TD>
        <TD><? echo $thisSex_X; ?></TD>
        <TD><? echo $thisSex_Y; ?></TD>
        <TD><? echo $thisTop25; ?></TD>
        <TD><? echo $thisSecteur_apa_ID; ?></TD>
        <TD><? echo $thisSecteur_smur_ID; ?></TD>
        <TD><? echo $thisSecteur_adps_ID; ?></TD>
        <TD><? echo $thisCarroyage; ?></TD>
		<TD><? echo $thisTerritoire_sante; ?></TD>
    <TD><a href="<? echo $_SERVER['PHP_SELF']; ?>?action=Edit&thisCom_IDField=<? echo $thisCom_ID; ?>">Edit</a></TD>
    <TD><a href="<? echo $_SERVER['PHP_SELF']; ?>?action=Delete&thisCom_IDField=<? echo $thisCom_ID; ?>">Delete</a></TD>
    </TR>

<?
}
?>
<?
        $i++;

    } // end while loop
?>
</TABLE>
<FORM NAME="insertForm" METHOD="POST" ACTION="<? echo $_SERVER['PHP_SELF']; ?>">
<input type="hidden" name="action" value="EnterNew">
<input type="Submit" name="submit" value="Insert New Record">
</FORM>


<br>
<?
if ($_REQUEST['startLimit'] != "")
{
?>

<a href="<? echo  $_SERVER['PHP_SELF']; ?>?startLimit=<? echo $previousStartLimit; ?>&limitPerPage=<? echo $limitPerPage; ?>&sortBy=<? echo $sortBy; ?>&sortOrder=<? echo $sortOrder; ?>">Previous <? echo $limitPerPage; ?> Results</a>....
<? } ?>
<?
if ($numberOfRows == $limitPerPage)
{
?>
<a href="<? echo $_SERVER['PHP_SELF']; ?>?startLimit=<? echo $nextStartLimit; ?>&limitPerPage=<? echo $limitPerPage; ?>&sortBy=<? echo $sortBy; ?>&sortOrder=<? echo $sortOrder; ?>">Next <? echo $limitPerPage; ?> Results</a>
<? } ?>

<br><br>
<?
} // end of if numberOfRows > 0
 ?>

<?php
    include_once("../footer.php");
?>