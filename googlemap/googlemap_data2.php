<?php
/**
*	googlemap_data.php
 * @package Sagec
 * @author JCB
*	@version $Id: googlemap_data.php 43 2008-03-13 22:41:12Z jcb $
*/
session_start();
require("./../pma_connect.php");
require("./../pma_connexion.php");
require("./../pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

?>

var pharma = new Array();
var med = new Array();
var ide = new Array();
var pma_noel = new Array();

function medecins(dessine)
{
	if(med.length < 1)
	{
			var icon = new GIcon();
			icon.image = "./../images/iconb.png";
			icon.shadow = "./../images/marker_shadow.png";
			icon.iconSize = new GSize(20,34);
			icon.shadowSize = new GSize(22, 20);
			icon.iconAnchor = new GPoint(6, 20);
			icon.infoWindowAnchor = new GPoint(5, 1);
			<?php
    			$requete = "SELECT * FROM mg67, ville 
    							WHERE ville.ville_ID = '$_SESSION[ville_ID]'
    							AND ville.ville_insee = mg67.code_insee
    			";
    			$resultat = ExecRequete($requete,$connexion);
    			$n = 0;
    			while($rep = mysql_fetch_array($resultat))
    			{ 	
    				echo "med[".$n."] = new Array();\n";
    				echo "med[".$n."]['nom'] = '".$rep['med_nom']."';\n";
    				echo "med[".$n."]['tel1'] = '".rtrim($rep['med_tel'])."';\n";
    				echo "med[".$n."]['tel2'] = '".rtrim($rep['med_tel2'])."';\n";
    				echo "med[".$n."]['tel3'] = '".rtrim($rep['med_tel3'])."';\n";
    				echo "med[".$n."]['adresse'] = '".str_replace("'","\'",$rep['med_adresse'])."';\n";
    				echo "med[".$n."]['marker'] = 0;\n";
    				echo "med[".$n."]['long'] = ".$rep['lng'].";\n";
    				echo "med[".$n."]['lat'] = ".$rep['lat'].";\n";
    				$n ++;
    			}
    		?>
    		for (var i=0;i<med.length;i++)
    		{
    				unPoint = new GLatLng(med[i]['lat'],med[i]['long']);
    				infoText = "<div style='width:200px'><b>Dr " + med[i]["nom"] + "</b><br>";
    				infoText += med[i]['adresse'] + "<br>";
    				infoText += "<br>" + med[i]['tel1'];
    				if(med[i]['tel2)']) infoText += "<br>" + med[i]['tel2'];
    				if(med[i]['tel3)']) infoText += "<br>" + med[i]['tel3'];
    				infoText += "</div>";
    				med[i]["marker"] = createMarker(unPoint,infoText,icon);
    				
    		}
	}
    		
   if(dessine)
	{
			for (var i=0;i<med.length;i++)
				map.addOverlay(med[i]["marker"]);
   }
   else
   {
   		for (var i=0;i<med.length;i++)
				map.removeOverlay(med[i]["marker"]);
	}
}

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
			var ville_id = <?php echo $_SESSION['ville_ID'] ?>;
			<?php
    			$requete = "SELECT * FROM pharmacie WHERE ID_commune = '$_SESSION[ville_ID]'";
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
    				infoText = "<div style='width:200px'><b>Pharmacie " + pharma[i]["nom"] + "</b><br>";
    				infoText += pharma[i]['adresse'] + "<br>"+ pharma[i]['zip']+" " + pharma[i]['nom'];
    				infoText += "<br>" + pharma[i]['tel'] + "</div>";
    				pharma[i]["marker"] = createMarker(unPoint,infoText,icon);
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

window.onload = init;
window.unload = GUnload;
