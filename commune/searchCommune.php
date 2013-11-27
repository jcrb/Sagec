 <?php
 // searchCommune.php
    include_once("../dbConnection.php");
    include_once("header.php");
?>
<?
function highlightSearchTerms($fullText, $searchTerm, $bgcolor="#FFFF99")
{
    if (empty($searchTerm))
    {
        return $fullText;
    }
    else
    {
        $start_tag = "<span style=\"background-color: $bgcolor\">";
        $end_tag = "</span>";
        $highlighted_results = $start_tag . $searchTerm . $end_tag;
        return eregi_replace($searchTerm, $highlighted_results, $fullText);
    }
}

?>
<?php
$thisKeyword = $_REQUEST['keyword'];
?>
<?
$sqlQuery = "SELECT *  FROM commune WHERE com_ID like '%$thisKeyword%'  OR com_INSEE like '%$thisKeyword%'  OR commune_zip like '%$thisKeyword%'  OR canton_ID like '%$thisKeyword%'  OR adm_ID like '%$thisKeyword%'  OR pop90 like '%$thisKeyword%'  OR com_nom like '%$thisKeyword%'  OR vsav like '%$thisKeyword%'  OR smur like '%$thisKeyword%'  OR pop99 like '%$thisKeyword%'  OR L2y like '%$thisKeyword%'  OR L2x like '%$thisKeyword%'  OR Lx like '%$thisKeyword%'  OR Ly like '%$thisKeyword%'  OR X like '%$thisKeyword%'  OR Y like '%$thisKeyword%'  OR sex_X like '%$thisKeyword%'  OR sex_Y like '%$thisKeyword%'  OR top25 like '%$thisKeyword%'  OR secteur_apa_ID like '%$thisKeyword%'  OR secteur_smur_ID like '%$thisKeyword%'  OR secteur_adps_ID like '%$thisKeyword%'  OR carroyage like '%$thisKeyword%' ";
$result = MYSQL_QUERY($sqlQuery);
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
    </TR>
<?
$highlightColor = "#FFFF99";

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
    $thisCom_ID = highlightSearchTerms($thisCom_ID, $thisKeyword, $highlightColor);
    $thisCom_INSEE = highlightSearchTerms($thisCom_INSEE, $thisKeyword, $highlightColor);
    $thisCommune_zip = highlightSearchTerms($thisCommune_zip, $thisKeyword, $highlightColor);
    $thisCanton_ID = highlightSearchTerms($thisCanton_ID, $thisKeyword, $highlightColor);
    $thisAdm_ID = highlightSearchTerms($thisAdm_ID, $thisKeyword, $highlightColor);
    $thisPop90 = highlightSearchTerms($thisPop90, $thisKeyword, $highlightColor);
    $thisCom_nom = highlightSearchTerms($thisCom_nom, $thisKeyword, $highlightColor);
    $thisVsav = highlightSearchTerms($thisVsav, $thisKeyword, $highlightColor);
    $thisSmur = highlightSearchTerms($thisSmur, $thisKeyword, $highlightColor);
    $thisPop99 = highlightSearchTerms($thisPop99, $thisKeyword, $highlightColor);
    $thisL2y = highlightSearchTerms($thisL2y, $thisKeyword, $highlightColor);
    $thisL2x = highlightSearchTerms($thisL2x, $thisKeyword, $highlightColor);
    $thisLx = highlightSearchTerms($thisLx, $thisKeyword, $highlightColor);
    $thisLy = highlightSearchTerms($thisLy, $thisKeyword, $highlightColor);
    $thisX = highlightSearchTerms($thisX, $thisKeyword, $highlightColor);
    $thisY = highlightSearchTerms($thisY, $thisKeyword, $highlightColor);
    $thisSex_X = highlightSearchTerms($thisSex_X, $thisKeyword, $highlightColor);
    $thisSex_Y = highlightSearchTerms($thisSex_Y, $thisKeyword, $highlightColor);
    $thisTop25 = highlightSearchTerms($thisTop25, $thisKeyword, $highlightColor);
    $thisSecteur_apa_ID = highlightSearchTerms($thisSecteur_apa_ID, $thisKeyword, $highlightColor);
    $thisSecteur_smur_ID = highlightSearchTerms($thisSecteur_smur_ID, $thisKeyword, $highlightColor);
    $thisSecteur_adps_ID = highlightSearchTerms($thisSecteur_adps_ID, $thisKeyword, $highlightColor);
    $thisCarroyage = highlightSearchTerms($thisCarroyage, $thisKeyword, $highlightColor);

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
    <TD><a href="commune_edit.php?com_IDField=<? echo $thisCom_ID; ?>">Edit</a></TD>
    <TD><a href="commune_delete.php?com_IDField=<? echo $thisCom_ID; ?>">Delete</a></TD>
    </TR>
<?
        $i++;

    } // end while loop
?>
</TABLE>
<?
} // end of if numberOfRows > 0
 ?>

<?php
    include_once("../footer.php");
?>