<?php
/**
*	apa_fiche_victime.php
*/
session_start();
$backPathToRoot = "../"; 
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");
include_once($backPathToRoot."date.php");
require($backPathToRoot."interrogeBD.php");

/**
*	récupère le contenu du dossier s'il existe
*/
$no_identification = strtoupper($_REQUEST['no_victime']);
$victime = chercheID($no_identification,$_SESSION['evenement'],$connexion);

// valeurs par défaut
$gravite = 11;

if($victime)
{
	$database = "UPDATE";
	print("<INPUT TYPE=\"HIDDEN\" NAME=\"image2\" VALUE=\"$victime->photo\">");
	print("<INPUT TYPE=\"HIDDEN\" NAME=\"victime\" VALUE=\"$victime->no_ordre\">");
	print("<INPUT TYPE=\"HIDDEN\" NAME=\"victimeID\" VALUE=\"$victime->victime_ID\">");
	$hopital = $victime->Hop_ID;
	$victimeID = $victime->victime_ID;
}
/**
* création automatique d'un nouveau dossier avec des info par défaut
*/
if(!$victime->victime_ID && $no_identification)
{
	$date = uDateTime2MySql(time());
	$victime->no_ordre = $no_identification;
	$victime->gravite = $gravite;
	$victime->conta_N = '1';
	$victime->conta_R = '1';
	$victime->conta_C = '1';
	$database = "UPDATE";
	$requete = "INSERT INTO victime (victime_ID,no_ordre,conta_N,conta_B,conta_C,pays_ID,gravite,evenement_ID,org_createur_ID,heure_creation) 
					VALUES ('','$victime->no_ordre',1,1,1,999,'$victime->gravite','$_SESSION[evenement]','$_SESSION[organisation]','$date')";
	$resultat = ExecRequete($requete,$connexion);
	$victime->victime_ID = mysql_insert_id();
	$victimeID = mysql_insert_id();
	print("<INPUT TYPE=\"HIDDEN\" NAME=\"victimeID\" VALUE=\"$victimeID\" >");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
  <head>
  <meta http-equiv="content-type" content="ent="text; charset=ISO-8859-1" f>
  <meta http-equiv="Content-Language" content="fr" />
  <title>Bilan Secouriste</title>
  <LINK REL="stylesheet" HREF="apa.css" TYPE ="text/css">
  <style type="text/css" media="screen">@import url(../sig/css/normal.css);</style>
   <!--[if IE]><style type="text/css" media="screen">@import url(../sig/css/ie.css);</style><![endif]-->
   <!--[if lte IE 6]><style type="text/css" media="screen">@import url(../sig/css/ie6.css);</style><![endif]-->
</head>

<body>
	<form name="saisie" action="apa_enregistre_victime.php" method="get">
	
	<INPUT TYPE="HIDDEN" NAME="victimeID" VALUE="<?php echo $victimeID ?>" >"
		
	<div id="en-tete">
 		<ul>
  			<li><a href="apa_nouvelle_victime.php"><span>Nouveau</span></a></li>
  			<li><a href="apa_liste_victimes.php"><span>Liste</span></a></li>
  			<li id="actif"><a href=""><span> Dossier Med </span></a></li>
  			<li><a href="apa_resume.php?victime=<?php echo $victimeID ?>"><span> Résumé </span></a></li>
 		</ul>
 	</div>
 
 	
 	<div id="etatcivil">
 		<fieldset>
 			<legend> Etat-Civil </legend>
 			
 			<p><label for="no_identification" tittle="">Identifiant:</label>
 			<input type="text" name="no_identification" value="<?php echo $no_identification ?>"
 			<input type="submit" value="Valider" name="okBtn"/>
 			</p>
 			
 			<p><label for="nom" tittle="">Nom:</label>
 			<input type="text" id = "nom" name="nom" value="<?php echo $victime->nom ?>"
 			</p>
 			
 			<p><label for="prenom" tittle="">Prénom:</label>
 			<input type="text" name="prenom" id="prenom" value="<?php echo $victime->prenom ?>"
 			</p>
 			
 			<p><label for="sexe" tittle="">Sexe:</label>
 			<select id="sexe" name="sexe">
				<option value="0" selected="">indéterminé</option>
				<option value="1">Homme</option>
				<option value="2">Femme</option>
			</select>
 			</p>
 			
			<p><label for="age1" tittle="">Age:</label>
 			<input type="text" name="age1" id="age1" value="<?php echo $victime->age1 ?>"
 			<span>(en année)</span>
 			</p>
 			
 			<p><label for="naissance" tittle="">Date de naissance:</label>
 			<input type="text" name="naissance" id="naissance" value="<?php echo $victime->naissance ?>"
 			<span>(jj/mm/aaaa)</span>
 			</p>
 			
 			<p><label for="adresse1" tittle="">Adresse 1:</label>
 			<input type="text" name="adresse1" id="adresse1" value="<?php echo $victime->adresse1 ?>"
 			</p>
 			
 			<p><label for="adresse2" tittle="">Adresse 2:</label>
 			<input type="text" name="adresse2" id="adresse2" value="<?php echo $victime->adresse2 ?>"
 			</p>
 			
 			<p><label for="ville" tittle="">Ville:</label>
 			<input type="text" name="ville" id="ville" value="<?php echo $victime->ville ?>"
 			</p>
 		</fieldset>
 	</div>
 	
 	<div id="etatcivil">
 		<fieldset>
 			<legend> CONSTANTES </legend>
 			<p><label for="gravite">Gravité :</label>
			<select id="gravite" name="gravite">
				<option value="1" <?php if($victime->gravite==1)echo 'selected';?> >UR</option>
				<option value="2" <?php if($victime->gravite==2)echo 'selected';?> >UA</option>
				<option value="3" <?php if($victime->gravite==3)echo 'selected';?> >Eclopé</option>
				<option value="4" <?php if($victime->gravite==4)echo 'selected';?> >DCD</option>
				<option value="0" <?php if($victime->gravite==0)echo 'selected';?> >Indéterminé</option>
			</select>
		</p>
		
		<p><label for="fc" tittle="">Fréquence cardiaque:</label>
 			<input type="text" name="fc" id="fc" value="<?php echo $constantes->fc ?>"
 			<input type="submit" value="Valider" name="okBtn"/>
 		</p>
 		<p><label for="fr" tittle="">Fréquence resp.:</label>
 			<input type="text" name="fr" id="fr" value="<?php echo $constantes->fr ?>"
 		</p>
 		<p><label for="pas" tittle="">PA systolique:</label>
 			<input type="text" name="pas" id="pas" value="<?php echo $constantes->pas ?>"
 		</p>
 		<p><label for="pad" tittle="">PA diastolique:</label>
 			<input type="text" name="pad" id="pad" value="<?php echo $constantes->pad ?>"
 		</p>
 		<p><label for="gcs" tittle="">Score Glasgow:</label>
 			<input type="text" name="gcs" id="gcs" value="<?php echo $constantes->gcs ?>"
 		</p>
 		<p><label for="sat" tittle="">Saturation O2:</label>
 			<input type="text" name="sat" id="sat" value="<?php echo $constantes->sat ?>"
 		</p>
 		<p><label for="gly" tittle="">Glycémie:</label>
 			<input type="text" name="gly" id="gly" value="<?php echo $constantes->gly ?>"
 		</p>
 		
 		</fieldset>
 	</div> 	
 	
<div id="etatcivil">
	<fieldset>
		<legend> LESIONS </legend>
		<textarea name="lesions" rows="4" cols="35"><?php echo $victime->lesions ?></textarea>
		<input type="submit" value="Valider" name="okBtn"/>
	</fieldset>
</div>

<div id="etatcivil">
	<fieldset>
		<legend> TRAITEMENTS </legend>
		<textarea name="traitement" rows="4" cols="35"><?php echo $victime->traitement ?></textarea>
		<input type="submit" value="Valider" name="okBtn"/>
	</fieldset>
</div>
 	
 	</form>
</body>
</html>