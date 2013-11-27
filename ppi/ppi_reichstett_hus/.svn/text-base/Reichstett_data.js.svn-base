var centerLatitude = 48.6603;
var centerLongitude = 7.76639;
var startZoom = 13;
var description = 'Raffinerie de Reichstett';

var bou_ico = new GIcon(baseIcon, "http://maps.google.com/mapfiles/kml/pal2/icon16.png", null, "http://maps.google.com/mapfiles/kml/pal2/icon16s.png");
var prm_ico = new GIcon(baseIcon, "http://maps.google.com/mapfiles/kml/pal4/icon15.png", null, "http://maps.google.com/mapfiles/kml/pal4/icon15s.png");
var pma_ico   = new GIcon(baseIcon, "http://maps.google.com/mapfiles/kml/pal3/icon46.png", null, "http://maps.google.com/mapfiles/kml/pal3/icon46s.png");
var pco_ico = new GIcon(baseIcon, "http://maps.google.com/mapfiles/kml/pal3/icon53.png", null, "http://maps.google.com/mapfiles/kml/pal3/icon53s.png");
var heb_ico = new GIcon(baseIcon, "http://maps.google.com/mapfiles/kml/pal2/icon20.png", null, "http://maps.google.com/mapfiles/kml/pal2/icon20s.png");

var bouclage = new Array();
var pmas = new Array();
var hebergement = new Array();
var prmMarker;
var pcoMarker;
var circleA;
var circleB;
var cicleSet = false;// bool
var circleMarker;
var mouseTracking;
var mtoStatus = '';

function pointsBouclage(dessine)
{
   if(bouclage.length < 1)
	{
    	bouclage[0] = new Array();
    	bouclage[0]["no"] = 6;
    	bouclage[0]["lat"] = 48.680024;
    	bouclage[0]["long"] = 7.776432;
    	bouclage[0]["marker"] = 0;

    	bouclage[1] = new Array();
    	bouclage[1]["no"] = 7;
    	bouclage[1]["lat"] = 48.679967;
    	bouclage[1]["long"] = 7.78038;
    	bouclage[1]["marker"] = 0;

    	bouclage[2] = new Array();
    	bouclage[2]["no"] = 10;
    	bouclage[2]["lat"] = 48.668944;
    	bouclage[2]["long"] = 7.798147;
    	bouclage[2]["marker"] = 0;

    	bouclage[3] = new Array();
    	bouclage[3]["no"] = 8.2;
    	bouclage[3]["lat"] = 48.683623;
    	bouclage[3]["long"] = 7.810721;
    	bouclage[3]["marker"] = 0;

    	bouclage[4] = new Array();
    	bouclage[4]["no"] = 8.1;
    	bouclage[4]["lat"] = 48.683878;
    	bouclage[4]["long"] = 7.814069;
    	bouclage[4]["marker"] = 0;

    	bouclage[5] = new Array();
    	bouclage[5]["no"] = 3;
    	bouclage[5]["lat"] = 48.664976;
    	bouclage[5]["long"] = 7.743473;
    	bouclage[5]["marker"] = 0;

    	bouclage[6] = new Array();
    	bouclage[6]["no"] = 4.2;
    	bouclage[6]["lat"] = 48.671438;
    	bouclage[6]["long"] = 7.736692;
    	bouclage[6]["marker"] = 0;

    	bouclage[7] = new Array();
    	bouclage[7]["no"] = 4.1;
    	bouclage[7]["lat"] = 48.677502;
    	bouclage[7]["long"] = 7.734203;
    	bouclage[7]["marker"] = 0;

    	bouclage[8] = new Array();
    	bouclage[8]["no"] = 2;
    	bouclage[8]["lat"] = 48.658740;
    	bouclage[8]["long"] = 7.733946;
    	bouclage[8]["marker"] = 0;

    	bouclage[9] = new Array();
    	bouclage[9]["no"] = 1.1;
    	bouclage[9]["lat"] = 48.645464;
    	bouclage[9]["long"] = 7.733409;
    	bouclage[9]["marker"] = 0;

    	bouclage[10] = new Array();
    	bouclage[10]["no"] = 1.2;
    	bouclage[10]["lat"] = 48.646414;
    	bouclage[10]["long"] = 7.733409;
    	bouclage[10]["marker"] = 0;

    	bouclage[11] = new Array();
    	bouclage[11]["no"] = 14;
    	bouclage[11]["lat"] = 48.633497;
    	bouclage[11]["long"] = 7.753977;
    	bouclage[11]["marker"] = 0;

    	bouclage[12] = new Array();
    	bouclage[12]["no"] = 13;
    	bouclage[12]["lat"] = 48.630866;
    	bouclage[12]["long"] = 7.765317;
    	bouclage[12]["marker"] = 0;

    	bouclage[13] = new Array();
    	bouclage[13]["no"] = 12;
    	bouclage[13]["lat"] = 48.629987;
    	bouclage[13]["long"] = 7.776614;
    	bouclage[13]["marker"] = 0;

    	bouclage[14] = new Array();
    	bouclage[14]["no"] = 11.2;
    	bouclage[14]["lat"] = 48.656521;
    	bouclage[14]["long"] = 7.815313;
    	bouclage[14]["marker"] = 0;

    	bouclage[15] = new Array();
    	bouclage[15]["no"] = 11.1;
    	bouclage[15]["lat"] = 48.658832;
    	bouclage[15]["long"] = 7.818274;
    	bouclage[15]["marker"] = 0;

    	bouclage[16] = new Array();
    	bouclage[16]["no"] = 9;
    	bouclage[16]["lat"] = 48.665259;
    	bouclage[16]["long"] = 7.822909;
    	bouclage[16]["marker"] = 0;

    	for (var i=0;i<bouclage.length;i++)
    	{
    		unPoint = new GLatLng(bouclage[i]["lat"],bouclage[i]["long"]);
    		bouclage[i]["marker"] = createMarker(unPoint,'Point de bouclage '+bouclage[i]["no"],bou_ico);
    	}
    }
	if(dessine)
	{
    	for (var i=0;i<bouclage.length;i++)
    		map.addOverlay(bouclage[i]["marker"]);
    }
    else
    {
		for (var i=0;i<bouclage.length;i++)
			map.removeOverlay(bouclage[i]["marker"]);
	}
}

function pointHebergement(dessine)
{
	if(hebergement.length < 1)
	{
	// Hébergement Vendenheim espace culturel
		hebergement[0] = new Array();
		hebergement[0]["nom"] = 'Hébergement Vendenheim';
		hebergement[0]["adresse"] = 'Espace culturel<br>rue Jean Holweg';
		hebergement[0]["places"] = 700;
		hebergement[0]["lat"] = 48.665086;
		hebergement[0]["long"] = 7.710562;
		hebergement[0]["marker"] = 0;

   // Hébergement Brumath espace culturel
    	hebergement[1] = new Array();
		hebergement[1]["nom"] = 'Hébergement Brumath<br>(Réservé évac. CHS Hoerdt)';
		hebergement[1]["adresse"] = 'Espace culturel<br>29 rue André Malraux';
		hebergement[1]["places"] = 600;
		hebergement[1]["lat"] = 48.737392;
		hebergement[1]["long"] = 7.711651;
		hebergement[1]["marker"] = 0;

		var texte="test";
		for (var i=0;i<hebergement.length;i++)
   	{
			unPoint = new GLatLng(hebergement[i]["lat"],hebergement[i]["long"]);
			texte = "<u>"+hebergement[i]["nom"]+"</u><br>" + hebergement[i]["adresse"]+"<br>" + hebergement[i]["places"]+" places";
			hebergement[i]["marker"] = createMarker(unPoint,texte,heb_ico);
		}
	}

	if(dessine)
	{
		for (var i=0;i<hebergement.length;i++)
			map.addOverlay(hebergement[i]["marker"]);
   }
   else
   {
   	for (var i=0;i<hebergement.length;i++)
			map.removeOverlay(hebergement[i]["marker"]);
	}

}

function pco(dessine)
{
	if(!pcoMarker)
	{
			pcoPoint = new GLatLng(48.665556,7.710556);
			pcoMarker = createMarker(pcoPoint,'PCO Vendenheim<br>Mairie rue Jean Holweg',pco_ico);
	}
	if(dessine)
	{
		map.addOverlay(pcoMarker);
	}
	else
	{
		map.removeOverlay(pcoMarker);
	}
}

function prm(dessine)
{
	if(!prmMarker)
	{
			prmPoint = new GLatLng(48.647265,7.736896);
			prmMarker = addComplexMarker(prmPoint,prm_ico);
	}
	if(dessine)
	{
		map.addOverlay(prmMarker);
	}
	else
	{
		map.removeOverlay(prmMarker);
	}
}


function pma2(dessine)
{
	if(pmas.length < 1)
	{
		pmas[0] = new Array();
		pmas[0]["nom"] = 'PMA 1 Wantzenau';
		pmas[0]["adresse"] = 'Gymnase, rue neuve';
		pmas[0]["places"] = 115;
		pmas[0]["lat"] = 48.661333;
		pmas[0]["long"] = 7.829432;
		pmas[0]["marker"] = 0;

	// PMA 2 Wantzenau gymnase rue des vergers
		pmas[1] = new Array();
		pmas[1]["nom"] = 'PMA 2 Wantzenau';
		pmas[1]["adresse"] = 'Gymnase, rue des vergers';
		pmas[1]["places"] = 200;
		pmas[1]["lat"] = 48.661950;
		pmas[1]["long"] = 7.833177;
		pmas[1]["marker"] = 0;

	// PMA Hoenheim 1 rue du stade
		pmas[2] = new Array();
		pmas[2]["nom"] = 'PMA Hoenheim';
		pmas[2]["adresse"] = 'Salle de sport, 1 rue du stade';
		pmas[2]["places"] = 140;
		pmas[2]["lat"] = 48.625243;
		pmas[2]["long"] = 7.765950;
		pmas[2]["marker"] = 0;

	// PMA Vendenheim salle de sport
		pmas[3] = new Array();
		pmas[3]["nom"] = 'PMA Vendenheim';
		pmas[3]["adresse"] = 'Salle de sport, rue des chataigners';
		pmas[3]["places"] = 200;
		pmas[3]["lat"] = 48.665514;
		pmas[3]["long"] = 7.706276;
		pmas[3]["marker"] = 0;

	// PMA Mundolsheim salle de sport
		pmas[4] = new Array();
		pmas[4]["nom"] = 'PMA Mundolsheim';
		pmas[4]["adresse"] = 'Salle de sport, rue du collège';
		pmas[4]["places"] = 300;
		pmas[4]["lat"] = 48.644840;
		pmas[4]["long"] = 7.710557;
		pmas[4]["marker"] = 0;

	// PMA Souffelweyersheim salle de sport
		pmas[5] = new Array();
		pmas[5]["nom"] = 'PMA Souffelweyersheim';
		pmas[5]["adresse"] = 'Salle de sport, rue des 7 arpents';
		pmas[5]["places"] = 300;
		pmas[5]["lat"] = 48.631824;
		pmas[5]["long"] = 7.739911;
		pmas[5]["marker"] = 0;


		var texte="test";
		//var pma_ico2   = new GIcon(baseIcon, "icon46.png", null, "icon46.png");
		for (var i=0;i<pmas.length;i++)
   	{
			unPoint = new GLatLng(pmas[i]["lat"],pmas[i]["long"]);
			texte = "<u>"+pmas[i]["nom"]+"</u><br>" + pmas[i]["adresse"]+"<br>" + pmas[i]["places"]+" places";
			pmas[i]["marker"] = createMarker(unPoint,texte,pma_ico);
		}
	}


	if(dessine)
	{
		for (var i=0;i<pmas.length;i++)
			map.addOverlay(pmas[i]["marker"]);
   }
   else
   {
   	for (var i=0;i<pmas.length;i++)
			map.removeOverlay(pmas[i]["marker"]);
	}
}

/**
 * analyseMenu()
 * @access public
 * @return void
**/
function analyseMenu()
{
	alert("1");
	var oZoneRisque = document.getElementById('zr');
	if(oZoneRisque.checked)
	{
		if(cicleSet == false)
		{
			var lat = 48.649083;
			var lng = 7.779334;
			circleA = cercle(lat,lng,1.170,'#ff0000',0.25);
			map.addOverlay(circleA);
		
			circleB = cercle(lat,lng,1.337,'#ff0000',0.25);
			map.addOverlay(circleB);

			cicleSet = true;

			var unPoint = new GLatLng(lat,lng);
			var texte = "<a href='scenario1.php' TARGET='_blank'><u>Scénario 1:</u></a><br> BLEVE sur la plus grosse sphère de butane";
			circleMarker = createMarker(unPoint,texte,'');
			map.addOverlay(circleMarker);
		}
	}
	else
	{
		map.removeOverlay(circleA);
		map.removeOverlay(circleB);
		map.removeOverlay(circleMarker);
		cicleSet = false;
	}
alert("2");
 
	var oPma = document.getElementById('pma');
	if(oPma.checked)
		pma2(true);
	else
		pma2(false);
 
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

<script>
<!--
	var oZoneBouclage = document.getElementById('pb');
	if(oZoneBouclage.checked)
		pointsBouclage(true);
	else
		pointsBouclage(false);
-->
</script>