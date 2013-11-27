function pharmacies(dessine)
{
	if(pharma.length < 1)
	{
			var icon = new GIcon();
			icon.image = "./../../images/marker_GREEN.png";
			icon.shadow = "./../../images/marker_shadow.png";
			icon.iconSize = new GSize(20,34);
			icon.shadowSize = new GSize(22, 20);
			icon.iconAnchor = new GPoint(6, 20);
			icon.infoWindowAnchor = new GPoint(5, 1);
			
			var bd = map.getBounds();
			var sw = bd.getSouthWest();
			var ne = bd.getNorthEast();
			x1 = sw.lat();
			y1 = sw.lng();
			x2 = ne.lat();
			y2 = ne.lng();
			alert (x1+","+y1+","+x2+","+y2);
			
			objet_hxr = createXHR();
			objet_hxr.open("get","pharma.php?x1="+x1+"&y1="+y1+"&x2="+x2+"&y2="+y2,true);
			objet_hxr.onreadystatechange = affiche_pharma;
			objet_hxr.send(null);

			<?php
				// WHERE commune_ID = '$_REQUEST[ville_ID]'
    			$requete = "SELECT * FROM pharmacie ";
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