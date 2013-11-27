<?php
/**
	hus_googlemap_data.php
*	@version $Id: hus_googlemap_data.php 29 2008-01-13 22:52:31Z jcb $
*/
session_start();
require("./../pma_connect.php");
require("./../pma_connexion.php");
require("./../pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);
?>

var pharma = new Array();
var pma_noel = new Array();

/*
	analyseMenu
*/
function analyseMenu()
{
    	var oPharma = document.getElementById('pharma');
		if(oPharma.checked)
			pharmacies(true);
		else
			pharmacies(false);
			
		var oPma = document.getElementById('pma');
		if(oPma.checked)
			pma_marche_noel(true);
		else
			pma_marche_noel(false);
}

/*
*
*/
function pharmacies(dessine)
{
	if(pharma.length < 1)
	{
			var icon = new GIcon();
			icon.image = "./../images/marker_GREEN.png";
			icon.shadow = "./../images/marker_shadow.png";
			icon.iconSize = new GSize(20,34);
			icon.shadowSize = new GSize(22, 20);
			icon.iconAnchor = new GPoint(6, 20);
			icon.infoWindowAnchor = new GPoint(5, 1);
			<?php
    			$requete = "SELECT * FROM pharmacie WHERE ID_commune = '$_SESSION[commune_ID]'";
    			$resultat = ExecRequete($requete,$connexion);
    			$n = 0;
    			while($rep = mysql_fetch_array($resultat))
    			{ 	
    				echo "pharma[".$n."] = new Array();\n";
    				echo "pharma[".$n."]['nom'] = '".$rep['nom']."';\n";
    				echo "pharma[".$n."]['zip'] = ".$rep['zip'].";\n";
    				echo "pharma[".$n."]['tel'] = '".rtrim($rep['tel'])."';\n";
    				echo "pharma[".$n."]['adresse'] = '".str_replace("'","\'",$rep['adresse'])."';\n";
    				echo "pharma[".$n."]['marker'] = 0;\n";
    				echo "pharma[".$n."]['long'] = ".$rep['long'].";\n";
    				echo "pharma[".$n."]['lat'] = ".$rep['lat'].";\n";
    				$n ++;
    			}
    		?>

    		for (var i=0;i<pharma.length;i++)
    		{
    				unPoint = new GLatLng(pharma[i]["lat"],pharma[i]["long"]);
    				infoText = "<div><b>Pharmacie " + pharma[i]["nom"] + "</b><br>";
    				infoText += pharma[i]['adresse'] + "<br>"+ pharma[i]['zip']+" " + pharma[i]['nom'];
    				infoText += "<br>" + pharma[i]['tel'] + "</div>";
    				pharma[i]["marker"] = createMarker2(unPoint,infoText,icon);
    		}
	}
    		
   if(dessine)
	{
			for (var i=0;i<pharma.length;i++)
				map.addOverlay(pharma[i]["marker"]);
   }
   else
   {
   		for (var i=0;i<pharma.length;i++)
				map.removeOverlay(pharma[i]["marker"]);
	}
}

/*
*
*/
function pma_marche_noel(dessine)
{
	if(pma_noel.length < 1)
	{
		var icon = new GIcon();
		icon.image = "./../images/icon23_002.png";
		icon.iconSize = new GSize(24, 20);
		icon.shadowSize = new GSize(22, 20);
		icon.iconAnchor = new GPoint(6, 20);
		icon.infoWindowAnchor = new GPoint(5, 1);
		
		// PMA Fustel
			pma_noel[0] = new Array();
			pma_noel[0]['nom'] = 'PMA Fustel';
			pma_noel[0]['longitude'] = 7.753295;
			pma_noel[0]['latitude'] = 48.581822;
			pma_noel[0]['marker'] = 0;
		// PMA Gymnase Sturm
			pma_noel[1] = new Array();
			pma_noel[1]['nom'] = 'PMA Gymnase Sturm';
			pma_noel[1]['longitude'] = 7.775804;
			pma_noel[1]['latitude'] = 48.578381;
			pma_noel[1]['marker'] = 0;
		// PMA Ecole Branly
			pma_noel[2] = new Array();
			pma_noel[2]['nom'] = 'PMA Ecole Branly';
			pma_noel[2]['longitude'] = 7.763451;
			pma_noel[2]['latitude'] = 48.594595;
			pma_noel[2]['adresse'] = "9, Rue Abbé Wetterlé 67000 Strasbourg";
			pma_noel[2]['tel'] = "03 88 35 18 28";
			pma_noel[2]['marker'] = 0;
		// PMA Mésange
			pma_noel[3] = new Array();
			pma_noel[3]['nom'] = 'PMA Mésange';
			pma_noel[3]['longitude'] = 7.746400;
			pma_noel[3]['latitude'] = 48.584200;
			pma_noel[3]['marker'] = 0;			
		// PMA République
			pma_noel[4] = new Array();
			pma_noel[4]['nom'] = 'PMA République';
			pma_noel[4]['longitude'] = 7.75340;
			pma_noel[4]['latitude'] = 48.58655;
			pma_noel[4]['marker'] = 0;						
		// PMA Halles
			pma_noel[5] = new Array();
			pma_noel[5]['nom'] = 'PMA Halles';
			pma_noel[5]['longitude'] = 7.746700;
			pma_noel[5]['latitude'] = 48.58655;
			pma_noel[5]['marker'] = 0;
		// PMA Marché aux vins
			pma_noel[6] = new Array();
			pma_noel[6]['nom'] = 'PMA Marché aux vins';
			pma_noel[6]['longitude'] = 7.741600;
			pma_noel[6]['latitude'] = 48.583847;
			pma_noel[6]['marker'] = 0;
		// PMA Marché aux vins
			pma_noel[7] = new Array();
			pma_noel[7]['nom'] = 'Gutemberg';
			pma_noel[7]['longitude'] = 7.748500;
			pma_noel[7]['latitude'] = 48.581550;
			pma_noel[7]['marker'] = 0;
			
			
		for (var i=0;i<pma_noel.length;i++)
    	{
    		unPoint = new GLatLng(pma_noel[i]["latitude"],pma_noel[i]["longitude"]);
    		infoText = "<div ><b>" + pma_noel[i]["nom"] + "</b><br>";
    		infoText += " (Longitude: " + pma_noel[i]['longitude'] + ", latitude: "+ pma_noel[i]['latitude']+")<br>";
    		infoText += pma_noel[i]["adresse"]+"<br>";
    		infoText += pma_noel[i]["tel"]+"<br>";
    		infoText += "Fiche technique <a href=\"http://sagec67.chru-strasbourg.fr\"> Voir</a> </div>";
    		pma_noel[i]["marker"] = createMarker2(unPoint,infoText,icon);
    	}
   }
   if(dessine)
	{
		for (var i=0;i<pma_noel.length;i++)
			map.addOverlay(pma_noel[i]["marker"]);
		map.setCenter(new GLatLng(48.581822, 7.753295), 14);
   }
   else
   {
   	for (var i=0;i<pma_noel.length;i++)
			map.removeOverlay(pma_noel[i]["marker"]);
	}
}

