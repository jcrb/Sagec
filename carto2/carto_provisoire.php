if($_GET["objet"]=='rea_adulte' || $_GET["objet"]=='rea_ped'|| $_GET["objet"]=='morgue')
{
	if($_GET["objet"]=='rea_adulte') $type = 2;
	elseif($_GET["objet"]=='rea_ped') $type = 3;
	elseif($_GET["objet"]=='morgue') $type = 21;
	$requete = "SELECT SUM(lits_dispo),ville_nom,ville_LambertX, ville_LambertY
		FROM service,hopital,lits,ville,adresse
		WHERE service.type_ID = '$type'
		AND service.hop_ID = hopital.Hop_ID
		AND lits.service_ID = service.service_ID
		AND ville.ville_ID = adresse.ville_ID
		AND adresse.ad_ID = hopital.adresse_ID
		AND ville.departement_ID IN ".$inListe." GROUP BY ville_nom";
	$resultat = ExecRequete($requete,$connexion);
	while($rub = mysql_fetch_array($resultat))
	{
		$rayon = '15';
		if($rub[0]==0)$color=$rouge;
		else $color=$bleu;
		$d->cercle($rub['ville_LambertX'],$rub['ville_LambertY'],$rayon,$color, "",$rub['ville_nom'],"1");
		//$d->writetxt('1',0,$rub['ville_LambertX'],$rub['ville_LambertY'],0,0,$blanc,$rub[0]);
		$d->ecrire($rub[0],$rub['ville_LambertX'],$rub['ville_LambertY'],10,-8,0,"12",'L');
	}
}
else

{
	if($_GET["objet"]=='helico')
	{
		$requete = "SELECT ville_nom, ville_lambertX, ville_lambertY,ville.departement_ID,organisme.org_ID
		FROM ville, organisme,vecteur
		WHERE ville.ville_ID = organisme.ville_ID
		AND organisme.org_ID = vecteur.org_ID
		AND Vec_Type = '9'";
	}
	else {
	/*
		$requete = "SELECT ville_nom, ville_lambertX, ville_lambertY,ville.departement_ID,organisme.org_ID,Hop_Samu
		FROM ville, organisme,hopital
		WHERE ville.ville_ID = organisme.ville_ID
		AND organisme.org_ID = hopital.org_ID
		AND ville.departement_ID IN ".$inListe;
		*/
		$requete = "SELECT ville_nom, ville_lambertX, ville_lambertY,Hop_Samu
		FROM ville,hopital,adresse
		WHERE hopital.adresse_ID = adresse.ad_ID
		AND adresse.ville_ID = ville.ville_ID
		AND ville.departement_ID IN ".$inListe;
		
		switch($_GET["objet"])
		{
		case "samu_smur":$requete .= "AND Hop_Smur = 'o'";break;
		case "samu":$requete .= "AND Hop_Samu = 'o'";break;
		case "psm1":$requete .= "AND Hop_psm1 = 'o'";break;
		case "psm2":$requete .= "AND Hop_psm2 = 'o'";break;
		case "caisson":$requete .= "AND Hop_caisson = 'o'";break;
		case "polyT":$requete .= "AND Hop_polytrauma = 'o'";break;
		}
		//if($_GET["objet"]=="samu_smur")$requete .= "AND Hop_Smur = 'o'";
		//else $requete .= "AND Hop_Samu = 'o'";
	}

	$resultat = $resultat = ExecRequete($requete,$connexion);
	while($rub = mysql_fetch_array($resultat))
	{
		//print("- ".$rub[ville_nom]." ".$rub[ville_lambertX]." ".$rub[ville_lambertY]." // ".$rub[org_ID]."<BR>");
		$rayon = '10';
		if($rub['Hop_Samu']=="o") $rayon = '16';
		$d->cercle($rub[1],$rub[2],$rayon,$bleu, "",$rub[0],"1");
	}
}
// isocercles
if($_GET['ville'])
{
	$requete = "SELECT ville_nom,ville_lambertX, ville_lambertY FROM ville WHERE ville_ID = '$_GET[ville]'";
	$resultat = $resultat = ExecRequete($requete,$connexion);
	$rub = mysql_fetch_array($resultat);
	for($i=1;$i<500/$_GET['rayon'];$i++)
		$d->isocercle($rub['ville_lambertX'],$rub['ville_lambertY'],$_GET['rayon']*$i,"");
	$d->cercle($rub[1],$rub[2],10,$rouge, "",$rub[0],"1");
}