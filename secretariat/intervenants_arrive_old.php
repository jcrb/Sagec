if(strlen($code)>5)
	{
		print(" 1 ");
		/**
		 * le code personnel HUS commence par 30085. Il contient normalement 13 caractères
		 * avec le caractère de contrôle et 12 sans.
		 * Le code RPPS est aussi accepté mais il comporte 12 caractères (11 + 1)
		 */
		if(strlen($code)==11)	// code RPPS 
		{
			$requete = "UPDATE personnel
						SET arrive = 'o',heure_arrive = '$h',heure_depart=0
		 				WHERE rpps = '$code'
		 				AND arrive <> 'o'
		 				";
		}
		else if(strlen($code)==13)	// Code SAMU 
		{
			print(strlen($code));
			$id =  substr($code,-4,3);
			// déja enregistré ?
			$requete = "SELECT * FROM perso_affectation WHERE personnel_ID = '$id'";
			$result = ExecRequete($requete,$connexion);
			// creation enregistrement 
			if(mysql_num_rows($result)==0)
			{
				$requete="INSERT INTO perso_affectation VALUES('$id','','$h','','','','','')";
				ExecRequete($requete,$connexion);
			}
			/*
			$requete = "UPDATE perso_affectation
						SET arrive = 'o',heure_arrive = '$h',heure_depart=0
		 				WHERE personnel_ID = '$id'
		 				AND arrive <> 'o'
		 				";
		 				*/
		 }
	}
	else if($_REQUEST['nom'])
	{
		print(" 2 ");
		$requete = "UPDATE personnel
						SET arrive = 'o',heure_arrive = '$h',heure_depart=0
		 				WHERE Pers_Nom = '$_REQUEST[nom]'
		 				AND arrive <> 'o'
		 				";
	}
	if(isset($requete))
		ExecRequete($requete,$connexion);
	else $requete = "Code Erroné";
	print("Requete arrive: ".$requete."<br>");
}
else if($_REQUEST['mouvement'] == "depart")
{
	$code = $_REQUEST['code'];print($code);
	$h = uDateTime2MySql(time());
	//if(isLuhnNum($code))
	if(strlen($code)>5)
	{
		/**
		 * le code personnel HUS commence par 30085. Il contient normalement 13 caractères
		 * avec le caractère de contrôle et 12 sans.
		 * Le code RPPS est aussi accepté mais il comporte 12 caractères (11 + 1)
		 */
		if(strlen($code)==11)
		{
			//$id =  substr($code,-3,3);
			$requete = "UPDATE personnel
						SET arrive = '',heure_depart = '$h'
		 				WHERE rpps = '$code'
		 				";
		}
		else if(strlen($code)==13)
		{
			$id =  substr($code,-4,3);
			$requete = "UPDATE personnel
						SET arrive = '',heure_depart = '$h'
		 				WHERE Pers_ID = '$id'
		 				";
		 }
	}
	else if($_REQUEST['nom'])
	{
		$requete = "UPDATE personnel
						SET arrive = '',heure_depart = '$h'
		 				WHERE Pers_Nom = '$_REQUEST[nom]'
		 				";
	}
	if(isset($requete))
		$resultat = @ExecRequete($requete,$connexion);
	print("Requete depart: ".$requete."<br>");