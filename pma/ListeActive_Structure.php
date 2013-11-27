<?php
//ListeActive_Structure.php
$backPathToRoot = "../";
	include_once("header.php");
	include_once("dbConnection.php");
	include_once($backPathToRoot."login/init_security.php");
?>
<?
$initStartLimit = 0;
$limitPerPage = 20;

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


$sql = "SELECT   * FROM temp_structure WHERE ts_active = 'o' ".$orderByQuery.$limitQuery;
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

<a href="<? echo  $_SERVER['PHP_SELF']; ?>?startLimit=<? echo $previousStartLimit; ?>&limitPerPage=<? echo $limitPerPage; ?>&sortBy=<? echo $sortBy; ?>&sortOrder=<? echo $sortOrder; ?>">Précédants <? echo $limitPerPage; ?> Results</a>....
<? } ?>
<?
if ($numberOfRows == $limitPerPage)
{
?>
<a href="<? echo $_SERVER['PHP_SELF']; ?>?startLimit=<? echo $nextStartLimit; ?>&limitPerPage=<? echo $limitPerPage; ?>&sortBy=<? echo $sortBy; ?>&sortOrder=<? echo $sortOrder; ?>">Suivants <? echo $limitPerPage; ?> Results</a>
<? } ?>

<br><br>
<TABLE CELLSPACING="0" CELLPADDING="3" BORDER="0" WIDTH="100%">
    <TR>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=ts_ID&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>Ts_ID</B>
            </a>
</TD>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=ts_nom&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>Ts_nom</B>
            </a>
</TD>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=ts_type&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>Ts_type</B>
            </a>
</TD>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=ts_localisation&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>Ts_localisation</B>
            </a>
</TD>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=ts_contact&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>Ts_contact</B>
            </a>
</TD>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=ts_lat&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>Ts_lat</B>
            </a>
</TD>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=ts_long&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>Ts_long</B>
            </a>
</TD>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=cata_ID&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>Cata_ID</B>
            </a>
</TD>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=ts_parent_ID&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>Ts_parent_ID</B>
            </a>
</TD>
	<TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=ts_active&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>Ts_active</B>
            </a>
</TD>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=ts_heure_activation&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>Ts_heure_activation</B>
            </a>
</TD>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=ts_heure_arret&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>Ts_heure_arret</B>
            </a>
</TD>
        <TD>
            <a href="<? echo $PHP_SELF; ?>?sortBy=ts_reutilisable&sortOrder=<? echo $newSortOrder; ?>&startLimit=<? echo $startLimit; ?>&rows=<? echo $limitPerPage; ?>">
                <B>Ts_reutilisable</B>
            </a>
</TD>
    </TR>
<?php
    while ($i<$numberOfRows)
    {

        if (($i%2)==0) { $bgColor = "#FFFFFF"; } else { $bgColor = "#C0C0C0"; }

    $thisTs_ID = MYSQL_RESULT($result,$i,"ts_ID");
    $thisTs_nom = Security::db2str(MYSQL_RESULT($result,$i,"ts_nom"));
    $thisTs_type = MYSQL_RESULT($result,$i,"ts_type");
    $thisTs_localisation = Security::db2str(MYSQL_RESULT($result,$i,"ts_localisation"));
    $thisTs_contact = Security::db2str(MYSQL_RESULT($result,$i,"ts_contact"));
    $thisTs_lat = MYSQL_RESULT($result,$i,"ts_lat");
    $thisTs_long = MYSQL_RESULT($result,$i,"ts_long");
    $thisCata_ID = MYSQL_RESULT($result,$i,"cata_ID");
    $thisTs_parent_ID = MYSQL_RESULT($result,$i,"ts_parent_ID");
    $thisTs_active = MYSQL_RESULT($result,$i,"ts_active");
    $thisTs_heure_activation = MYSQL_RESULT($result,$i,"ts_heure_activation");
    $thisTs_heure_arret = MYSQL_RESULT($result,$i,"ts_heure_arret");
    $thisTs_reutilisable = MYSQL_RESULT($result,$i,"ts_reutilisable");

?>
    <TR BGCOLOR="<? echo $bgColor; ?>">
        <TD><? echo $thisTs_ID; ?></TD>
        <TD><? echo $thisTs_nom; ?></TD>
        <TD><? echo $thisTs_type; ?></TD>
        <TD><? echo $thisTs_localisation; ?></TD>
        <TD><? echo $thisTs_contact; ?></TD>
        <TD><? echo $thisTs_lat; ?></TD>
        <TD><? echo $thisTs_long; ?></TD>
        <TD><? echo $thisCata_ID; ?></TD>
        <TD><? echo $thisTs_parent_ID; ?></TD>
	<TD><? echo $thisTs_active; ?></TD>
        <TD><? echo $thisTs_heure_activation; ?></TD>
        <TD><? echo $thisTs_heure_arret; ?></TD>
        <TD><? echo $thisTs_reutilisable; ?></TD>
    <TD><a href="structure_temp.php?ts_IDField=<? echo $thisTs_ID; ?>">Edit</a></TD>
    <TD><a href="confirmDeleteTemp_structure.php?ts_IDField=<? echo $thisTs_ID; ?>">Delete</a></TD>
    </TR>
<?
        $i++;

    } // end while loop
?>
</TABLE>


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
    include_once("footer.php");
?> 
