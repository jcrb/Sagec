<?php
//----------------------------------------- SAGEC ------------------------------

// This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// SAGEC67 is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//------------------------------------------------------------------------------
/** 
*	uf_create.php
* 	création ou modification d'une UF
*	date de création: 	10/05/2008	 
*	@author:			jcb		  
*	@version:	$Id$	 
*	maj le:				
*	@package			sagec
*/
//------------------------------------------------------------------------------
session_start();
$backPathToRoot = "../";
if(! $_SESSION['auto_sagec'])header("Location:".$backPathToRoot."logout.php");
$member_id = $_SESSION['member_id'];
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include_once($backPathToRoot."dbConnection.php");
require("uf_utilitaires.php");
include_once($backPathToRoot."contact_main.php");
$langue = $_SESSION['langue'];

print("<html>");
print("<head>");
	print("<title>page_test</title>");
	print("<meta http-equiv=\"content-type\" content=\"text/html; charset=iso-8859-1\" />");
	print("<link href=\"uf.css\" rel=\"stylesheet\" type=\"text/css\" />");
	print("<link href=\"formstyle.css\" rel=\"stylesheet\" type=\"text/css\" />");
print("</head>");

//print("<body>");
//echo '<form action=\"\" method="get">';

$uf_courante = $_REQUEST['ufID'];
// si c'est une mise à jour
if(isset($uf_courante))
{
	?>
	<body>
	<form id="uf" action="uf_enregistre.php" method="post">
	<div id="formtitle">Saisie-Mise a jour d'une UF</div>
	
	<?php
	$requete = "SELECT * FROM uf WHERE uf_ID = '$uf_courante'";
	$resultat = ExecRequete($requete,$connexion);
	$rub=mysql_fetch_array($resultat);
	?>
	<input type="hidden" name="id" value="<?php echo $uf_courante;?>"
	<div id="content">
	<fieldset id="coordonnees">
		<legend>UF Identifiant</legend>
		<p>
			<label for="nom" title="uf_nom">UF Nom :</label>
			<input type="text" id="nom" name="nom" title="uf_nom" size="40" value="<?php echo $rub[uf_nom];?>"/>
		</p>
		<p>
			<label for="code">UF Code :</label>
			<input type="text" id="code" name="code" value="<?php echo $rub[uf_code];?>"/>
		</p>
		<p>
			<label for="code">UF Site :</label>
			<?php fSite(85,$rub['site_ID']);?>
		</p>
		<p>
			<label for="code">UF etage :</label>
			<input type="text" id="etage" name="etage" value="<?php echo $rub['uf_etage'];?>"/>
		</p>
		<p>
			<label for="code">UF batiment :</label> 
			<?php fBatiment(85,$rub['batiment_ID']);?>
		</p>
		<p>
			<label for="code">URGENCES 615 :</label> 
			<input type="text" id="urg" name="urg" value="<?php echo $rub['uf_urgence'];?>"/>
		</p>
	</fieldset>
	<br />
	
	<fieldset id="coordonnees">
		<legend>UF Rattachement </legend>
		<p>
			<label for="service" title="service">UF Service :</label>
			<?php fService($rub['Hop_ID'],$rub['service_ID']);?>
		</p>
		<p>
			<label for="code">UF Pole :</label>
			<?php fPole($rub['org_ID'],$rub['pole_ID']);?>
		</p>
		<p>
			<label for="code">UF Hôpital :</label>
			<?php fHopital($rub['Hop_ID']);?>
		</p>
		<p>
			<label for="code">UF Organisme :</label>
			<?php fOrganisme($rub['org_ID']);?>
		</p>
	</fieldset>
	<br />
	
	<fieldset id="coordonnees">
		<legend>UF Caractéristiques </legend>
		<p>
			<label for="service" title="service">UF Division :</label>
			<?php fUfDivision($rub['uf_division_ID']);?>
		</p>
		<p>
			<label for="code">Discipline :</label>
			<?php fDiscipline($rub['uf_discipline_ID'],$rub['pole_ID']);?>
		</p>
		<p>
			<label for="code">UF Activité :</label>
			<?php fUfActivite($rub['uf_activite_ID']);?>
		</p>
		<p>
			<label for="code">UF INVS :</label>
			<?php fInvs($rub['uf_invs_ID']);?>
		</p>
		<p>
			<label for="code">UF Age :</label>
			<?php fAge($rub['uf_age_ID']);?>
			<p><label for="agemin" title="agemin">Age minimal :</label>
			<input type="text" id="agemin" name="agemin" title="agemin" size="10" value="<?php echo $rub[uf_age_min];?>"/></p>
			<p><label for="agemin" title="agemin">Age maximal :</label>
			<input type="text" id="agemax" name="agemax" title="agemax" size="10" value="<?php echo $rub[uf_age_max];?>"/></p>
		</p>
	</fieldset>
	<br />
	
	<fieldset id="typecat">
		<legend>UF en activité</legend>		
			<input type="radio" name="ufOuverte" id="o" value="o" <?php if($rub['uf_ouverte']=='o')echo 'checked';?> /> oui<br />
			<input type="radio" name="ufOuverte" id="n" value="n" <?php if($rub['uf_ouverte']=='n')echo 'checked';?>/> non<br />		
		</p>
	</fieldset>
	
	<fieldset id="typecat">
		<legend>Contacts</legend>		
		<p><span class="exemple">Gestion des contacts</span><br />
		<?php
			$service_caracid = $rub[uf_ID]; //$_GET['org_type'];
			$type=0;//nouveau
			$nature=7;//nature_contact = uf
			$back="../uf_create.php";//adresse de retour
			$variable="$_GET[org_type]";// variable de retour
			if($service_caracid)
				contact($service_caracid,$type,$nature,$contact_id,$back,$variable,$_GET['tri']);
			?>	
		</p>
	</fieldset>
	
	</div>
	
	<div id="formfooter">
		<p>			
			<input type="submit" name="BtnSubmit" id="valid" value="Valider" />
			<input type="reset" name="BtnClear" id="annul" value="Annuler" />
		</p>
	</div>
	
	</form>
	</body>
	<?php
}
//header("Location:test_page.php");

?>
