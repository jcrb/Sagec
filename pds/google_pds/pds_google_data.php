/**
 * ppi_pmc_data.php
 *
 * @version $Id: lanxes.js 38 2008-02-27 21:07:19Z jcb $
 * @package Sagec
 * @author JCB
 * @copyright 2007
 */
<?php
//session_start();
require("../../pma_connect.php");
require("../../pma_connexion.php");
require("../../pma_requete.php");
$connexion = Connexion(NOM,PASSE,BASE,SERVEUR);

?>


var mouseTracking;

var pharma = new Array();
var med = new Array();
var ide = new Array();
var ville_id;



/**
 *
 * @access public
 * @return void
 **/
function setControles()
{
	map.addControl(new GScaleControl());
	map.addControl(new GLargeMapControl());
	map.addControl(new GMapTypeControl());
	GEvent.addListener(map, 'mousemove', mouseMove);
	GEvent.addListener(map, 'zoomend', zoomEnd);
	GEvent.addListener(map, 'dragend', zoomEnd);
}

/**
*	retourne les coordonnées géographiques du rectangle visible
*/
function getViewport()
{
	var bd = map.getBounds();
	var sw = bd.getSouthWest();
	var ne = bd.getNorthEast();
	var x1 = sw.lat();
	var y1 = sw.lng();
	var x2 = ne.lat();
	var y2 = ne.lng();
	/** alert (x1+","+y1+","+x2+","+y2); */
	return 'x1=' + x1 + '&y1=' + y1 + '&x2=' + x2 + '&y2=' + y2;
}

function mouseMove(mousePt)
{
	if(mouseTracking)
   {
		mouseLatLng = mousePt;
		var zoom = map.getZoom();
		var oStatusDiv = document.getElementById("mouseTrack")	
		var mousePx = normalProj.fromLatLngToPixel(mousePt, zoom);
		oStatusDiv.innerHTML = 'Latitude:   ' + mousePt.y.toFixed(6) + '<br>Longitude: ' + mousePt.x.toFixed(6) ;
	}
}

function affiche_pharma()
{
	if(objet_hxr.readyState == 4)
	{
		if(objet_hxr.status == 200)
		{
			var icon = new GIcon();
			icon.image = "./../../images/marker_GREEN.png";
			icon.shadow = "./../../images/marker_shadow.png";
			icon.iconSize = new GSize(20,34);
			icon.shadowSize = new GSize(22, 20);
			icon.iconAnchor = new GPoint(6, 20);
			icon.infoWindowAnchor = new GPoint(5, 1);
			
			pharma.length = 0;/** efface le contenu du tableau*/
			
			var ph = objet_hxr.responseText;
			json = ph.parseJSON();

			for(i=0;i<json.pharma.length;i++)
			{
    			unPoint = new GLatLng(json.pharma[i].lat,json.pharma[i].long);
    			infoText = "<div style='width:200px'><b>Pharmacie " + json.pharma[i].nom + "</b><br>";
    			infoText += json.pharma[i].adresse + "<br>"+ json.pharma[i].zip+" " + json.pharma[i].ville;
    			infoText += "<br>tel: " + json.pharma[i].tel + "<br>fax: " + json.pharma[i].fax + "</div>";
    			pharma[i] = new Array();
    			pharma[i]["marker"] = createMarker(unPoint,infoText,icon);
    			map.addOverlay(pharma[i]['marker']);
			}
		}
		else
		{
			alert("Erreur serveur: "+objet_hxr.status+" - "+objet_hxr.statusText);
			objet_hxr.abort();
			objet_hxr = null;
		}
	}
}			
			
function pharmacies(dessine)
{
   if(dessine)
	{	
		objet_hxr = createXHR();
		objet_hxr.open("get","pharma.php?cible=pharma&"+getViewport(),true);
		objet_hxr.onreadystatechange = affiche_pharma;
		objet_hxr.send(null);
   }
   else
   {
   		for (var i=0;i<pharma.length;i++)
				map.removeOverlay(pharma[i]["marker"]);
	}
}

function affiche_med()
{
	if(objet_hxr_med.readyState == 4)
	{
		if(objet_hxr_med.status == 200)
		{
			var icon = new GIcon();
			icon.image = "./../../utilitaires/google/icons/iconr.png";
			icon.shadow = "./../../images/marker_shadow.png";
			icon.iconSize = new GSize(20,34);
			icon.shadowSize = new GSize(22, 20);
			icon.iconAnchor = new GPoint(6, 20);
			icon.infoWindowAnchor = new GPoint(5, 1);
			
			med.length = 0;/** efface le contenu du tableau*/
			
			var ph = objet_hxr_med.responseText;
			json = ph.parseJSON();
			for(i=0;i<json.med.length;i++)
			{
    			unPoint = new GLatLng(json.med[i].lat,json.med[i].lng);
    			infoText = "<div style='width:200px'><b>Docteur " + json.med[i].med_nom + "</b><br>";
    			infoText += json.med[i].med_adresse + "<br>";
    			infoText += "<br>tel: " + json.med[i].med_tel + "<br>";
    			if(json.med[i].med_tel2) infoText += "<br>tel: " + json.med[i].med_tel2 + "<br>";
    			if(json.med[i].med_tel3) infoText += "<br>tel: " + json.med[i].med_tel3 + "<br>";
    			infoText += "</div>";
    			med[i] = new Array();
    			med[i]["marker"] = createMarker(unPoint,infoText,icon);
    			map.addOverlay(med[i]['marker']);
			}
		}
		else
		{
			alert("Erreur serveur: "+objet_hxr_med.status+" - "+objet_hxr_med.statusText);
			objet_hxr_med.abort();
			objet_hxr_med = null;
		}
	}
}

function medecins(dessine)
{
   if(dessine)
	{	
		objet_hxr_med = createXHR();
		objet_hxr_med.open("get","pharma.php?cible=med&"+getViewport(),true);
		objet_hxr_med.onreadystatechange = affiche_med;
		objet_hxr_med.send(null);
   }
   else
   {
   		for (var i=0;i<med.length;i++)
				map.removeOverlay(med[i]["marker"]);
	}
}

function zoomEnd()
{
	map.clearOverlays();
	analyseMenu();
}

function analyseMenu()
{
	
	var oTracking = document.getElementById('mt');
	if(oTracking.checked) 
	{
    		mouseTracking = true;
	}
	else
	{
    		mouseTracking = false;
	}
	
	var oPharma = document.getElementById('pharma');
		if(oPharma.checked)
			pharmacies(true);
		else
			pharmacies(false);
			
	var oMed = document.getElementById('med');
		if(oMed.checked)
			medecins(true);
		else
			medecins(false);
}

