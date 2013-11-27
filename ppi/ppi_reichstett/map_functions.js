/**
* PPI Reichstett: données spécifiques
* @version $Id: map_functions.js 44 2008-04-16 06:55:34Z jcb $
* @author jcb
*/

// coordonnées de la raffinerie 
var centerLatitude = 48.6603;
var centerLongitude = 7.76639;
var startZoom = 13;

var map;
var circleA ,circleB;
var mouseTracking;
var cicle1Set = false;// bool
var circleMarker;

/**
	Crée un marqueur à l'endroit point, avec l'image icon et lui associe un évènement Click
	En cas de click affiche une fenêtre avec le contenu html
*/
function createMarker(point,html,icon) 
{
	var marker = new GMarker(point,icon);
	GEvent.addListener(marker, "click", function() {marker.openInfoWindowHtml(html);});
	return marker;
}

/**
	Expérimental: crée un marqueur avec 2 onglets
*/
function addAMarker(point,icon) 
{
	var marker = new GMarker(point,icon);
	GEvent.addListener(marker, "click", function() {
	var tab1 = new GInfoWindowTab("Info", '<div id="tab1" class="bubble">PRM<br>Point de rassemblement des moyens<br>A4 Bretelle de sortie Reichstett</div>');
	var tab2 = new GInfoWindowTab("Moyens", '<div>VSAV Nord<br>ASSU 834<br>ASSU 835<br>AR1 Strasbourg</div>');
	var infoTabs = [tab1,tab2];
	marker.openInfoWindowTabsHtml(infoTabs);

		//var dMapDiv = document.getElementById("detailmap");
		//var detailmap = new GMap2(dMapDiv);
		//detailmap.setCenter(point , 13);

		//var CopyrightDiv = dMapDiv.firstChild.nextSibling;
		//var CopyrightImg = dMapDiv.firstChild.nextSibling.nextSibling;
		//CopyrightDiv.style.display = "none"; 
		//CopyrightImg.style.display = "none"; 
	
	});
	//map.addOverlay(marker);
	return marker;
}

/**
	Expérimental: dessine un polygone à partir de points stocvkés dans un fichier TEXT
*/
function polyg()
{
	var poly = Array();
	<?php
		$fp = fopen("reichstett.txt","r");
		while(!feof($fp))
		{
			$mot = fgets($fp);
			$c = explode("\t",$mot);
			?>
			var x = <?php echo $c['0'] ?>;
			var y = <?php echo $c['1'] ?>;
			var point = new GLatLng(parseFloat(y),parseFloat(x));
			poly.push(point);
			<?php 
		}
	?>
	circle = new GPolygon(poly, true, '#ff0000', 0.25, true);	
	map.addOverlay(circle);
}

function mouseMove(mousePt)
{
	if(mouseTracking)
   {
		mouseLatLng = mousePt;
		var zoom = map.getZoom();
		var oStatusDiv = document.getElementById("mouseTrack")	
		var mousePx = normalProj.fromLatLngToPixel(mousePt, zoom);
		oStatusDiv.innerHTML = 'Mouse LatLng: ' + mousePt.y.toFixed(6) + ', ' + mousePt.x.toFixed(6) ;
		oStatusDiv.innerHTML += '<br> ';
		oStatusDiv.innerHTML += 'Mouse Px: ' + mousePx.x + ', ' + mousePx.y;
		oStatusDiv.innerHTML += '<br>';
		oStatusDiv.innerHTML += 'Tile: ' + Math.floor(mousePx.x / 256) + ', ' + Math.floor(mousePx.y / 256);

		if (centerMarker)
		{
			var mouseDistance = centerMarker.getPoint().distanceFrom(mouseLatLng);

			// convert to meters
			if (circleUnits == 'MI') 
			{
				var cRadius = circleRadius * 1.609344 * 1000;
			}
			else 
			{
				var cRadius = circleRadius * 1000;
			}
			//GLog.write(circleRadius + ' - ' + cRadius);
			if (mouseDistance < cRadius) 
			{
				map.openInfoWindowHtml(mouseLatLng,'Mouse inside circle');
			}
			else 
			{
				map.closeInfoWindow();
			}
		}
	}
}
    
function moveEnd()
{
    
}
    
function zoomEnd()
{
    
}
    
function updateStatusBar()
{
    
}

function drawCircle() 
    {
		var oUnitsMI = document.getElementById('unitsMI');
		var oUnitsKM = document.getElementById('unitsKM');

		//circleRadius = oRadius.value;
		circleRadius = 1;//km
		circleUnits = 'KM';

		doDrawCircle();
	}

    function doDrawCircle()
    {
		//var center = map.getCenter();
		var center = circleCenter;
		var circlePoints = Array();
		var bounds = new GLatLngBounds();
		with (Math) 
		{
			if (circleUnits == 'KM') 
			{
				var rLat = (circleRadius/6378.8) * (180/PI);
			}
			else 
			{ //miles
				var rLat = (circleRadius/3963.189) * (180/PI);
			}
			var rLng = rLat/cos(center.lat() * (PI/180));

			for (var a = 0 ; a < 361 ; a+=1 ) 
			{
				var aRad = a*(PI/180);
				var x = center.lng() + (rLng * cos(aRad));
				var y = center.lat() + (rLat * sin(aRad));
				var point = new GLatLng(parseFloat(y),parseFloat(x));
				bounds.extend(point);
				circlePoints.push(point);
			}
		}

		//map.removeOverlay(centerMarker);
		//centerMarker = new GMarker(center);
		//map.addOverlay(centerMarker);

		map.removeOverlay(circle); 
		circle = new GPolygon(circlePoints, true, '#ff0000', 0.25, true);	
		map.addOverlay(circle); 

		map.setZoom(map.getBoundsZoomLevel(bounds));
}

/**
*	Cercle:renvoie un objet GPolygon décrivant un cercle
*	lat: latitude du centre
* 	lng: longitude du centre
* 	rayon: rayon du cercle en km
*	color: couleur du cercle
*	transparence: entre  0 et 1
*/
function cercle(lat,lng,rayon,color,transparence)
{
	var center = new GLatLng(lat,lng);
	var circlepoints = new Array();
	with (Math)
	{
		var rLat = (rayon/6378.8) * (180/PI);
		var rLng = rLat/cos(center.lat() * (PI/180));
		for (var a = 0 ; a < 361 ; a+=1 ) 
		{
			var aRad = a*(PI/180);
			var x = center.lng() + (rLng * cos(aRad));
			var y = center.lat() + (rLat * sin(aRad));
			var point = new GLatLng(parseFloat(y),parseFloat(x));
			circlepoints.push(point);
		}
	}
	var couleur_trait = color;
	var epaisseur_trait = 1;
	var transparence_trait = 0.5;
	var a_circle = new GPolygon(circlepoints, couleur_trait,epaisseur_trait,transparence_trait,color, transparence);
	return a_circle;
}

function setControles()
{
	map.addControl(new GScaleControl());
	map.addControl(new GLargeMapControl());
	map.addControl(new GMapTypeControl());
}

/**
*
*/
function scenario1(oZoneRisque)
{
	if(oZoneRisque.checked)
	{
		if(cicle1Set == false)
		{
			
			circleA = cercle(48.649083,7.779334,1.170,'#ff0000',0.25);
			map.addOverlay(circleA);
		
			circleB = cercle(48.649083,7.779334,1.337,'#ff0000',0.25);
			map.addOverlay(circleB);

			cicle1Set = true;

			var unPoint = new GLatLng(48.649083,7.779334);
			var texte = "<a href='scenario1.php' TARGET='_blank'><u>Scénario 1:</u></a><br> BLEVE sur la sphère de butane";
			circleMarker = createMarker(unPoint,texte,'');
			map.addOverlay(circleMarker);
		}
	}
	else if(cicle1Set== true)
	{
		map.removeOverlay(circleA);
		map.removeOverlay(circleB);
		map.removeOverlay(circleMarker);
		cicle1Set = false;
	}
}

function analyseMenu()
{
	//alert("analyse menu");
	
	var oStatusDiv = document.getElementById("statusBar")	
	oStatusDiv.innerHTML = 'analyse menu';
	
	var oTracking = document.getElementById('mt');
	if(oTracking.checked) 
	{
    		mouseTracking = true;
    		oStatusDiv.innerHTML = 'Mouse tracking activé status = ' + mouseTracking;
	}
	else
	{
    		mouseTracking = false;
    		oStatusDiv.innerHTML = 'Mouse tracking désactivé status = ' + mouseTracking;
	}
		
	var oZoneRisque = document.getElementById('zr');
	scenario1(oZoneRisque);
	/*
	if(oZoneRisque.checked)
	{
		map.removeOverlay(circleA);
		map.removeOverlay(circleB);
		
		circleA = cercle(48.649083,7.779334,1.170,'#ff0000',0.25);
		map.addOverlay(circleA);
		
		circleB = cercle(48.649083,7.779334,1.337,'#ff0000',0.25);
		map.addOverlay(circleB);
	}
	else
	{
		map.removeOverlay(circleA);
		map.removeOverlay(circleB);
	}
	*/
   		
	var oZoneBouclage = document.getElementById('pb');
	if(oZoneBouclage.checked)
		pointsBouclage(true);
	else
		pointsBouclage(false);

	
	var oPma = document.getElementById('pma');
	if(oPma.checked)
	{
		pma2(true);
	}
	else
	{
		pma2(false);
	}
		
	var oPrm = document.getElementById('prm');
	if(oPrm.checked)
		prm(true);
	else
		prm(false);
	
	var oPco = document.getElementById('pco');
	if(oPco.checked)
		pco(true);
	else
		pco(false);
		
	
	var oHeb = document.getElementById('heb');
	if(oHeb.checked)
		pointHebergement(true);
	else
		pointHebergement(false);
}


/**
*	affiche tous les éléments dessinables, sauf cercles ?
*/
function affiche_tout()
{
	pma2(true);
	document.getElementById('pma').checked = true;
	pointHebergement(true);
	document.getElementById('heb').checked = true;
	pco(true);
	document.getElementById('pco').checked = true;
	prm(true);
	document.getElementById('prm').checked = true;
	pointsBouclage(true);
	document.getElementById('pb').checked = true;
	analyseMenu();
	teste_fichier_klm();
}

/*
*	Lit un fichier kml, le parse et affiche les résultats dans un conteneur
*/
function teste_fichier_klm()
{
	// ==== Create a KML Overlay ====
	var docFile = "reichstett.kml";
	var oStatusDiv = document.getElementById("statusBar")
			
	//var kml = new GGeoXml("localhost/sagec3/ppi/ppi_reichstett/reichstett.kml");
	//map.addOverlay(kml);

	GDownloadUrl(docFile,function(data,code)
	{
		// si le chargement des données s'est bien passé, alors code = 200
		if(code == 200)
		{
			//oStatusDiv.innerHTML = code + "<br>";
			var xml = GXml.parse(data);//xml = document
			var racine = xml.documentElement.nodeType;
			racine += " " + xml.documentElement.nodeName;
			oStatusDiv.innerHTML += "<br>Elément racine: " + racine +"<br>";

			var markers = xml.documentElement.getElementsByTagName("Placemark");
			oStatusDiv.innerHTML += "nb de marker: " + markers.length + "<br>";
			for (var i = 0; i < markers.length; i++)
			{
				oStatusDiv.innerHTML += markers[i].nodeName + " " +markers[i].childNodes.length+"<br>";
				for(var j = 0; j < markers[i].childNodes.length; j++)
				{
					var c1 = markers[i].childNodes[j];
					//oStatusDiv.innerHTML += "valeur = "+ c1.nodeValue + " type: "+c1.nodeType+ " nom: "+c1.nodeName;
					if(c1.nodeType == 1)
					{
						oStatusDiv.innerHTML += " type: "+c1.nodeType+ " nom: "+c1.nodeName;
						var c2 = c1.firstChild;
						oStatusDiv.innerHTML += " valeur: "+c2.nodeValue+"<br>"
						if(c1.nodeName == "Point")
						{
							oStatusDiv.innerHTML += c2.nodeType+"<br>";
							var coord = c1.getElementsByTagName("coordinates");
							oStatusDiv.innerHTML +="coord: "+  coord[0].nodeName + " val: " + coord[0].firstChild.nodeValue+ " type: "+coord[0].nodeType+"<br>";	
						}

					}
				}
			}
					
    				//for (var i = 0; i &lt; markers.length; i++)
    				//{
      				//var point = new GLatLng(parseFloat(markers[i].getAttribute("lat")),parseFloat(markers[i].getAttribute("lng")));
      				//map.addOverlay(new GMarker(point));
    				//}
		}
		else if(code == -1) 
		{
    		alert("Data request timed out. Please try later.");
  		} 
  		else 
  		{ 
    		alert("Request resulted in error. Check XML file is retrievable.");
    	}
	});
}

function load(lat,long,zoom) 
{
	if (GBrowserIsCompatible())
	{
      	container = document.getElementById("map");
			map = new GMap2(container, {draggableCursor:"crosshair"});
        	map.setCenter(new GLatLng(lat, long), zoom);
        	centerPoint = new GLatLng(lat,long);
        	//centerMarker = new GMarker(centerPoint);
        	centerMarker = createMarker(centerPoint,'Raffinerie de Reichstett<br><a href="">documents PPI</a>');
			map.addOverlay(centerMarker);
			
			<?php
				$im = imagecreatefrompng("manche.png");
				if(!$im)
				{
					?> 
						alert('Echec create'); 
					<?php
				}
				$rotate = imagerotate($im, 90, 0);
				if(!imagepng($rotate,"manche_rotate.png"))
				{
					?>
						alert('Echec rotation');
					<?php
				}
			?>
			var baseIcon = new GIcon();
   		baseIcon.iconSize=new GSize(32,72);
   		baseIcon.shadowSize=new GSize(56,32);
   		baseIcon.iconAnchor=new GPoint(17,72);
   		baseIcon.infoWindowAnchor=new GPoint(17,0);
			var mto_ico = new GIcon(baseIcon, "manche_rotate.png", null, "");
			mtoMarker = createMarker(centerPoint,'Météo',mto_ico);
			map.addOverlay(mtoMarker);
			//alert('mto');
			setControles();

			GEvent.addListener(map, 'mousemove', mouseMove);
			GEvent.addListener(map, "moveend", moveEnd);
			GEvent.addListener(map, "zoomend", zoomEnd);
			
			affiche_tout();
	}
}
	
function init()
{
	if(GBrowserIsCompatible())
	{
		map = new GMap2(document.getElementById("map"));
		var location = new GLatLng(centerLatitude,centerLongitude);
		map.setCenter(location, startZoom);
		load(centerLatitude,centerLongitude,startZoom);
	}
}

window.onload = init;
window.onunload = GUnload;
