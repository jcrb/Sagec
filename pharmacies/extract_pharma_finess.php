<?php 
/**
	utilitaire pharmacie
	extract_pharma_finess.php
	Récupère des données à partir du fichier FINESS
*/
require("../pma_connect.php");
require("../pma_connexion.php");
require("../pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
require_once("../gis/gis_utilitaires.php");

$source = "finess_67.csv";
$no_error = 200;
$elements = array();
$titre = array();




/** fonction de découpage */
function decoupe()
{
	global $elements;
	global $titre;
	
	$titre['finess'] = str_replace ('"', '',$elements[0]);
	$titre['siren'] = str_replace ('"', '',$elements[1]);
	$titre['nom'] = str_replace ('"', '',$elements[2]);
	$titre['compl_nom'] = str_replace ('"', '',$elements[3]);
	$titre['adresse1'] = str_replace ('"', '',$elements[4]);
	$titre['adresse2'] = str_replace ('"', '',$elements[5]);
	$titre['zip'] = str_replace ('"', '',$elements[6]);
	$titre['routage'] = str_replace ('"', '',$elements[7]);
	$titre['tel'] = str_replace ('"', '',$elements[8]);
	$titre['fax'] = str_replace ('"', '',$elements[9]);
	$titre['K'] = str_replace ('"', '',$elements[10]);
	$titre['L'] = str_replace ('"', '',$elements[11]);
	$titre['M'] = str_replace ('"', '',$elements[12]);
	$titre['N'] = str_replace ('"', '',$elements[13]);
	$titre['O'] = str_replace ('"', '',$elements[14]);
	$titre['P'] = str_replace ('"', '',$elements[15]);
	$titre['Q'] = str_replace ('"', '',$elements[16]);
	$titre['R'] = str_replace ('"', '',$elements[17]);
	$titre['code_cat'] = str_replace ('"', '',$elements[18]);
	$titre['nom_cat'] = str_replace ('"', '',$elements[19]);
	$titre['code_statut'] = str_replace ('"', '',$elements[20]);
	$titre['nom_statut'] = str_replace ('"', '',$elements[21]);
	$titre['code_tarif'] = str_replace ('"', '',$elements[22]);
	$titre['nom_tarif'] = str_replace ('"', '',$elements[23]);
	$titre['code_psph'] = str_replace ('"', '',$elements[24]);
	$titre['nom_psph'] = str_replace ('"', '',$elements[25]);
	$titre['finess_juridique'] = str_replace ('"', '',$elements[26]);
}

/** traitement d'une pharmacie 
*	récupère les données à partir du fichier finess
*	crée un fichier pharma.txt pouvant être importé dans la table pharmacie
*/	
function	ttt_pharmacie()
{
	global $elements;
	global $titre;
	global $connexion;
	global $n;
	global $fph;
	
	$requete = "SELECT ville_ID from ville WHERE ville_nom LIKE( '%$titre[routage]%')";
	$rep = ExecRequete($requete,$connexion);
	$resultat = MySql_Fetch_Array($rep);
	$ville_id = $resultat[0];
	
	$tab = "\t";
	$pharma = $tab;
	$pharma .= $ville_id.$tab;
	$pharma .= $titre['nom'].$tab;
	$pharma .= $titre['adresse1'].$tab;
	$pharma .= $titre['routage'].$tab;
	$pharma .= $titre['zip'].$tab;
	$pharma .= $titre['tel'].$tab;
	$pharma .= $titre['fax'].$tab;
	$pharma .= $tab;
	$pharma .= $tab;
	$pharma .= $titre['finess']."\r\n";
	
	print($pharma."<br>");
	fwrite($fph,$pharma);
}

/*
*	coordonnées
*	rajoute la geolocalisation aux fichier des pharmacies
*/
function pharma_geoloc()
{
	$fp = fopen("pharma.txt","r"); 
	$fp2 = fopen("pharma2.txt","w");
	$n = 0;
	$t = "\t";
	while(!feof($fp))
	{
		$ligne = fgets($fp);
		$elements = explode("\t",$ligne);
		$ad = formatte_adresse("",$elements[3],$elements[5],$elements[4],"FRANCE");//formatte_adresse($no,$rue,$cp,$ville,$pays)
		$coord = geolocalise($ad);
		$n++;
		if($coord['0'] != $no_error)
			print("Pas de coordoonées ligne: ".$n."<br>");
		//print($nom." ".$adresse.", ".$zip." ".$commune_id." ".$tel."  lat = ".$coord['2']." long = ".$coord['3']."<br>");
		$ligne2 = $elements[0].$t.$elements[1].$t.$elements[2].$t.$elements[3].$t.$elements[4].$t.$elements[5].$t.$elements[6].$t.$elements[7].$t.$coord['3'].$t.$coord['2'].$t.$elements[10]."\r\n";
		fwrite($fp2,$ligne2);
		print($ligne2."<br>");
	}
	fclose($fp);
	fclose($fp2);
}

/**
*	enregistre le fichier dans la table pharmacie
*/
function pharma_dans_table()
{
	$fp = fopen("pharma.txt","r");
	global $connexion;
	while(!feof($fp))
	{
		$ligne = fgets($fp);
		$elements = str_replace("\r\n","",$ligne);
		$elements = str_replace("\t","','",$ligne);
		$requete = "INSERT INTO pharmacie VALUES '$elements'";
		print($requete.'<br>');
		ExecRequete($requete,$connexion);
	}
	fclose($fp);
}

function main()
{
	$fp = fopen($source,"r");
	$fph = fopen("pharma.txt","w");
	global $n;
	global $fph;
	/** élimine la première ligne */
	$ligne = fgets($fp);
	$n = 1;

	//for($i = 0; $i < 30; $i++)
	while(!feof($fp))
	{
	$ligne = fgets($fp);
	$n++;
	$elements = explode(",",$ligne);
	decoupe();
	switch( $titre['code_cat'])
	{
		//case '101':ttt_chu();break;
		//case '106':ttt_hopital_local();break;
		//case '108':ttt_repos();break;
		//case '125':ttt_dent();break;
		//case '126':ttt_thermal();break;
		//case '127':ttt_had();break;
		//case '128':ttt_chir();break;
		//case '129':ttt_med();break;
		//case '130':ttt_med();break;
		//case '131':ttt_cancer();break;
		//case '132':ttt_efs();break;
		//case '135':ttt_readapt();break;
		//case '141':ttt_dialyse();break;
		//case '146':ttt_dialyse2();break;
		//case '289':ttt_ide();break;
		//case '292':ttt_chs();break;
		//case '347':ttt_sante();break;
		//case '355':ttt_ch();break;
		//case '362':ttt_sld();break;
		//case '365':ttt_pluri();break;
		//case '422':ttt_domicile();break;
		//case '426':ttt_sih();break;
		//case '431':ttt_alcool();break;
		//case '433':ttt_prison();break;
		case '610':ttt_labos();break;
		//case '620':ttt_pharmacie();break;
		//case '698':ttt_autre();break;
	}
}

fclose($fp);
fclose($fph);
}

// main();
//pharma_geoloc();
pharma_dans_table();

chmod("pharma.txt", 0777);
chmod("pharma2.txt", 0777);

/*	
	$ville = str_replace (' ', '-', $elements[0]);
	$requete = "SELECT ville_ID FROM ville WHERE ville_nom LIKE( '%$ville%') ";
	$rep = ExecRequete($requete,$connexion);
	$resultat = MySql_Fetch_Array($rep);
	$commune_id = $resultat[0];
	
	if(!$resultat[0])
		print("Pas de résultats pour ".$elements['0']."<br>");
	else 
	{
		$zip = $elements['1'];
		$adresse = $elements['2']." ".$elements['3']." ".$elements['4']." ".$elements['5'];
		$nom = $elements[6];
		$tel = $elements[7];

		$ad = formatte_adresse($elements[2],$elements[5],$zip,$ville,"FRANCE");
		$coord = geolocalise($ad);

		if($coord['0'] != $no_error)
			print("Pas de coordoonées pour: ");
		print($nom." ".$adresse.", ".$zip." ".$commune_id." ".$tel."  lat = ".$coord['2']." long = ".$coord['3']."<br>");

		// remplissage de la table pharmacie de la base
		$requete = "INSERT INTO pharmacie ( `ID_pharmacie` , `ID_commune` , `nom` , `adresse` , `zip` , `tel` , `fax` , `long` , `lat` , `secteur` )
					VALUES('','$commune_id','$nom','$adresse','$zip','$tel','','$coord[3]',$coord[2],'')";
		print($requete.'<br>');
		ExecRequete($requete,$connexion);
	}
}
*/

?>