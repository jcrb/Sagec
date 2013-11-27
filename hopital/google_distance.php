/**
 * google_distance.php
 *
 * @version $Id: lanxes.js 38 2008-02-27 21:07:19Z jcb $
 * @package Sagec
 * @author JCB
 * @copyright 2009
 */

function init()
{
	if(GBrowserIsCompatible())
	{
		//map = new GMap2(document.getElementById("map_canvas"));
		//gdir = new GDirections(map);
		gdir = new GDirections();
		GEvent.addListener(gdir, "load", affiche);
		//map.setCenter(new GLatLng(0,0),0);	// inital setCenter()  added by Esa.
		from = "48.57558,7.74042";// Strasbourg,FR
		to = "Krautwiller,FR";
		gdir.load("from: "+from+" to: "+ to,{ "locale": "fr" , "getSteps":true});
	}
}

function affiche()
{
		d = gdir.getDistance();
		t = gdir.getDuration();
		alert('distance Strasbourg-Krautwiller = '+ d['html'] + "  durée: "+t['html']);
		alert('distance = '+ d['meters'] + " mètres,  durée: "+t['seconds']+' secondes');
}

window.onload = init;
window.unload = GUnload;
