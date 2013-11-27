 <?php
 // commune_saisie.php
    include_once("dbConnection.php");
    include_once("header.php");
?>
<h2>Enter Commune</h2>
<form name="communeEnterForm" method="POST" action="insertNewCommune.php">

<table cellspacing="2" cellpadding="2" border="0" width="100%">
    <tr valign="top" height="20">
        <td align="right"> <b> Com_ID : </b> </td>
        <td> <input type="text" name="thisCom_IDField" size="20" value="">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Com_INSEE : </b> </td>
        <td> <input type="text" name="thisCom_INSEEField" size="20" value="">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Commune_zip : </b> </td>
        <td> <input type="text" name="thisCommune_zipField" size="20" value="">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Canton_ID : </b> </td>
        <td> <input type="text" name="thisCanton_IDField" size="20" value="">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Adm_ID : </b> </td>
        <td> <input type="text" name="thisAdm_IDField" size="20" value="">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Pop90 : </b> </td>
        <td> <input type="text" name="thisPop90Field" size="20" value="">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Com_nom : </b> </td>
        <td> <input type="text" name="thisCom_nomField" size="20" value="">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Vsav : </b> </td>
        <td> <input type="text" name="thisVsavField" size="20" value="">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Smur : </b> </td>
        <td> <input type="text" name="thisSmurField" size="20" value="">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Pop99 : </b> </td>
        <td> <input type="text" name="thisPop99Field" size="20" value="">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> L2y : </b> </td>
        <td> <input type="text" name="thisL2yField" size="20" value="">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> L2x : </b> </td>
        <td> <input type="text" name="thisL2xField" size="20" value="">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Lx : </b> </td>
        <td> <input type="text" name="thisLxField" size="20" value="">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Ly : </b> </td>
        <td> <input type="text" name="thisLyField" size="20" value="">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> X : </b> </td>
        <td> <input type="text" name="thisXField" size="20" value="">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Y : </b> </td>
        <td> <input type="text" name="thisYField" size="20" value="">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Sex_X : </b> </td>
        <td> <input type="text" name="thisSex_XField" size="20" value="">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Sex_Y : </b> </td>
        <td> <input type="text" name="thisSex_YField" size="20" value="">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Top25 : </b> </td>
        <td> <input type="text" name="thisTop25Field" size="20" value="">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Secteur_apa_ID : </b> </td>
        <td> <input type="text" name="thisSecteur_apa_IDField" size="20" value="">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Secteur_smur_ID : </b> </td>
        <td> <input type="text" name="thisSecteur_smur_IDField" size="20" value="">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Secteur_adps_ID : </b> </td>
        <td> <input type="text" name="thisSecteur_adps_IDField" size="20" value="">  </td>
    </tr>
    <tr valign="top" height="20">
        <td align="right"> <b> Carroyage : </b> </td>
        <td> <input type="text" name="thisCarroyageField" size="20" value="">  </td>
    </tr>
</table>

<input type="submit" name="submitEnterCommuneForm" value="Enter Commune">
<input type="reset" name="resetForm" value="Clear Form">

</form>

<?php
    include_once("footer.php");
?>