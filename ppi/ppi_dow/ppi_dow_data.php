/**
 * ppi_pmc_data.php
 *
 * @version $Id: lanxes.js 38 2008-02-27 21:07:19Z jcb $
 * @package Sagec
 * @author JCB
 * @copyright 2007
 */
<?php
$backPathToRoot = "../../"; 
include_once($backPathToRoot."dbConnection.php");
include_once($backPathToRoot."login/init_security.php");

$ppi = 0;	//21

/**
*	remplace()
*	remplace les caractères \n\r, \r,\n par <br>
*	évite les plantages liées au stockage des textarea
*/
function remplace($str)
{
	
	// Ordre des remplacements
	$order   = array("\r\n", "\n", "\r");
	$replace = '<br>';
	// Traitement du premier \r\n, ils ne seront pas convertis deux fois.
	$newstr = str_replace($order, $replace, $str);
	return $newstr;
	
}

?>
var startZoom = 15;
var normalProj = G_NORMAL_MAP.getProjection();
var mouseTracking;
var map;
var ppi;
var path = "../../";
var pathpdf = "../../";
   
var polys = [];
var labels = [];
var cercle_danger = new Array;
var cercles = new Array;
var marker_ppi = new Array;


/**
*	rend visible ou pas une div
*/
function visibilite(thingId, action)
{
	var targetElement;
	targetElement = document.getElementById(thingId) ;
	targetElement.style.display = action ;
}


/**
 *
 * @access public
 * @return void
 **/
function setControles()
{
	map.addControl(new GScaleControl());
	map.addControl(new GLargeMapControl());
	//map.addControl(new GSmallMapControl());
	map.addControl(new GMapTypeControl());
	GEvent.addListener(map, 'mousemove', mouseMove);
}

function init()
{
	if(GBrowserIsCompatible())
	{
		<?php
		/**
		*	Récupération des paramères de centrage
		*	@data centerLatitude 
		*	@data centerLongitude 
		*	@data description 
		*/
	
		$requete = 	"SELECT plan_ID FROM plan_courant WHERE plan_courant_ID = 1";
		$resultat = ExecRequete($requete,$connexion);
		$rub=mysql_fetch_array($resultat);
		$ppi = $rub['plan_ID'];

		$requete = 	"SELECT center_lat,center_lng,ppi_nom FROM ppi WHERE ppi_ID = '$ppi'";
		$resultat = ExecRequete($requete,$connexion);
		$rub=mysql_fetch_array($resultat);
		
		print("var centerLatitude = ".$rub['center_lat'].";");
		print("var centerLongitude = ".$rub['center_lng'].";");
		print("var description = '".Security::db2str($rub['ppi_nom'])."';");
		
		?>
		ppi = "<?php echo $ppi;?>";
		map = new GMap2(document.getElementById("map"));
		setControles();
		var location = new GLatLng(centerLatitude,centerLongitude);
		map.setCenter(location,startZoom);
		texte = "<div id='produit'><b>"+description+"</b></div><br>";
		addMarker(centerLatitude,centerLongitude,texte);
		// 		oStatusDiv.innerHTML = navigator.appName;
		structures_temporaires();
		info_ppi(ppi);
		ST_preetablies();
		stockages_associes();
		zonage();
	}
}

/**
  *	stockages_associes
  * 	regarde dans la table stockage s'il y a des éléments associés au PPI
  *	Si oui, les affiche
  */
function stockages_associes()
{
	<?php
		$requete = "SELECT stockage_industriel.*,stockage_conteneur_nom,chem_nom,unite_nom
						FROM stockage_industriel,stockage_conteneur,produitsChimiques, med_unites
						WHERE ppi_ID = '$ppi'
						AND stockage_industriel.stocki_type = stockage_conteneur.stockage_conteneur_ID
						AND stockage_industriel.produit_ID = chem_ID
						AND stocki_qte_unite = unite_ID
					  ";
		$resultat = ExecRequete($requete,$connexion);
		while($rub=mysql_fetch_array($resultat))
		{
			print("Latitude = ".$rub['stocki_lat'].";");
			print("Longitude = ".$rub['stocki_lng'].";");
			print("nom = '".addslashes($rub['stocki_nom'])."';");
			print("conteneur = '".addslashes($rub['stockage_conteneur_nom'])."';");
			print("hauteur = '".$rub['stocki_hauteur']."';");
			print("diametre = '".$rub['stocki_diametre']."';");
			print("volume = '".$rub['stocki_qte']."';");
			print("unit = '".addslashes($rub['unite_nom'])."';");
			print("produit = '".addslashes($rub['chem_nom'])."';");
			
			?>
				texte = '<b>'+nom+'</b>' + '<br>' + 'Type: ' + conteneur + '<br>' + 'Hauteur (m): '+ hauteur + '<br>'
							+ 'Diametre (m): ' + 0 + '<br>' +  'Volume: ' + volume +' '+unit + '(s)' + '<br>' + 'Produit: ' + '<a href="doc.html" target="_blank">'+produit+'</a>';
				point = new GLatLng(Latitude,Longitude);
				//icone = getIcone(type); 
				markerH = createMarker(point,texte,violet_ico);
				map.addOverlay(markerH);
			<?php
		}
	?>
}

/**
  *	Récupération des structures temporaires normalement associée à ce PPI
  *	modifié le 03/04/2011 pour correction mise à la ligne et accents
  *	et masquage des contacts si le champ est vide
  */
function ST_preetablies()
{
	<?php
	$requete = "SELECT * 
					FROM temp_structure,ppi_structures_actives
					WHERE temp_structure.ts_ID = ppi_structures_actives.ts_ID
					AND ppi_structures_actives.ppi_ID = '$ppi'
					";
	$resultat = ExecRequete($requete,$connexion);
	while($rub=mysql_fetch_array($resultat))
	{
		print("Latitude = ".$rub['ts_lat'].";");
		print("Longitude = ".$rub['ts_long'].";");
		print("nom = '".addslashes(Security::db2str($rub['ts_nom']))."';");
		print("type = ".$rub['ts_type'].";");
		print("contacts = '".remplace(Security::db2str($rub['ts_contact']))."';");
		print("localisation = '".addslashes(remplace(Security::db2str($rub['ts_localisation'])))."';");
		print("plan = '".$rub['ts_plan']."';");
		?>
			texte ="<div id='produit'><b>"+ nom + "</b><br>";
			if(contacts != '')
				texte = texte + "(" + contacts + ")<br>";
			texte = texte + localisation + "<br>";
			texte = texte + '<a href="liste_victime.php?pma=<? echo $rub[ts_ID];?>" target="_blank">Liste des victimes</a><br>';
			if(plan != '')
				texte = texte + '<a href= ' + pathpdf + plan + '>plan</a><br>'
			texte = texte + "</div>";
			point = new GLatLng(Latitude,Longitude);
			icone = getIcone(type); 
			markerH = createMarker(point,texte,icone);
			map.addOverlay(markerH);
		<?php
	}
	?>
}

/**
*  Récupération des zones
*/
function zonage()
{
	<?php 
	$requete = "SELECT * FROM zone_enveloppe WHERE zenveloppe_active = 'o'";
	$resultat = ExecRequete($requete,$connexion);
	while($rub=mysql_fetch_array($resultat))
	{
		print("label = '".addslashes($rub['zenveloppe_nom'])."';");
		print("colour = '".$rub['zenveloppe_couleurFond']."';");
		print("trait = '".$rub['zenveloppe_couleurTrait']."';");
		print("transparence = '".$rub['zenveloppe_transparence']."';");
		print("epaisseur = '".$rub['zenveloppe_epaisseur']."';");
		print("nom = '".$rub['zenveloppe_nom']."';");
		$fileName = "../../pma/zones/".$rub['zenveloppe_file'];
		$fp = fopen($fileName,"r");
		$i = 0;
		//print("var pts = new Array();");
		print("var pts = [];");
		// retirer la première ligne
		$mot = fgets($fp);
		
		while(!feof($fp))
		{
			$mot = fgets($fp);
			$coord = explode(",",$mot);
			print("pts[".$i."] = new GLatLng(".$coord[1].",".$coord[0].");");
			if($i==0){
				print("lat = ".$coord[1].";");
				print("lng = ".$coord[0].";");
			}
			$i++;
		}
		if($rub[zenveloppe.objet]=="P")
		{
			?>
			// création du polygone
			transparence = transparence/100;
         var poly = new GPolygon(pts,trait,1,1,colour,transparence,{clickable:true});
         polys.push(poly);
         labels.push(label);
         map.addOverlay(poly);
         <?php
      }
      else
      {
      	?>
      	addMarker(lat,lng,nom);
      	transparence = 1;
      	var line = new GPolyline(pts,trait,epaisseur, transparence) ;
 			map.addOverlay(line) ;
      	<?php
      }
		fclose($fp);
	}
	?>
}
	
/**
  *		Récupération des structures temporaires
  *		qui sont marquées actives
  *		Quelque soit le PPI déclenché
  */
function structures_temporaires()
{
	<?php
	$requete = "SELECT * FROM temp_structure WHERE ts_active = 'o'";
	$resultat = ExecRequete($requete,$connexion);
	while($rub=mysql_fetch_array($resultat))
	{
		print("Latitude = ".$rub['ts_lat'].";");
		print("Longitude = ".$rub['ts_long'].";");
		print("nom = '".addSlashes(Security::db2str($rub['ts_nom']))."';");
		print("type = ".$rub['ts_type'].";");
		print("contacts = '".remplace(Security::db2str($rub['ts_contact']))."';");
		//$loc =addslashes(Security::db2str(remplace($rub['ts_localisation'])));
		print("localisation = '".addslashes(remplace(Security::db2str($rub['ts_localisation'])))."';");
		//print("localisation = '".$loc."';");
		?>
			var contact = 123;
			var texte='';
			texte ="<div id='produit'><b>"+ nom + "</b><br>";
			texte = texte + localisation + '<br>' + contacts + '<br>';
		<?php
		
		/** si PMA afficher victimes et personnel */
		if($rub['ts_type']==1)
		{

			$requete = "SELECT * FROM victime WHERE localisation_ID = '$rub[ts_ID]'";
			$resultat2 = ExecRequete($requete,$connexion);
			while($rub2=mysql_fetch_array($resultat2))
			{
				print("no_ordre = '".$rub2['no_ordre']."';");
				print("nom_victime = '".$rub2['nom']."';");
				print("prenom_victime = '".$rub2['prenom']."';");
				?>
					texte = texte + ' '+ no_ordre + ' ' + nom_victime + ' ' + prenom_victime +'<br>';
				<?php
			}
		}
		/** si point de transit, vecteurs présents */
		if($rub['ts_type']==7)
		{
			$requete = "SELECT * FROM vecteur WHERE localisation_ID = '$rub[ts_ID]'";
			$resultat2 = ExecRequete($requete,$connexion);
			while($rub2=mysql_fetch_array($resultat2))
			{
				print("nom_vecteur = '".$rub2['Vec_Nom']."';");
				?>
					texte = texte + ' '+ nom_vecteur +'<br>';
				<?php
			}
		}
		?>
			texte = texte + '<a href="">'+'Liste des victimes'+'</a><br>';
			point = new GLatLng(Latitude,Longitude); 
			icone = getIcone(type);
			texte = texte + "***" + "</div>";
			markerH = createMarker(point,texte,icone);
			map.addOverlay(markerH);
		<?php
	}
	?>
}

/**
*	Infos PPI
*	recherche les stockages inbdustriels associés au PPI
*	ainsi que les produits chimiques associés
*/
function info_ppi(no_ppi)
{
	n = 0;
	<?php
	$requete = "SELECT stocki_nom,stocki_lat,stocki_lng,chem_nom,stocki_qte,unite_abrev,stocki_rayon1,stocki_rayon2,stocki_rayon3
					FROM stockage_industriel,produitsChimiques,med_unites 
					WHERE ppi_ID = '$ppi'
					AND stocki_qte_unite = med_unites.unite_ID
					AND stockage_industriel.produit_ID = produitsChimiques.chem_ID
					";
	$resultat = ExecRequete($requete,$connexion);
	while($rub=mysql_fetch_array($resultat))
	{
		print("Latitude = ".$rub['stocki_lat'].";");
		print("Longitude = ".$rub['stocki_lng'].";");
		print("stock_nom = '".addslashes($rub['stocki_nom'])."';");
		print("stock_qte = '".$rub['stocki_qte']."';");
		print("unite = '".$rub['unite_abrev']."';");
		print("nom = '".$rub['chem_nom']."';");
		print("r1 = ".$rub['stocki_rayon1'].";");
		print("r2 = ".$rub['stocki_rayon2'].";");
		print("r3 = ".$rub['stocki_rayon3'].";");
		?>
			point = new GLatLng(Latitude,Longitude);
			m = n +1;
			chim_ico = new GIcon(normalIcon, "../../utilitaires/google/icons/iconb"+ m +".png", null, "");
			contenu="<div id='produit'>" + stock_nom +"<br>";
			contenu = contenu + "<a href='doc.html' target='_blank'>"+nom+"</a><br>";
			contenu += stock_qte + " "+ unite;
			contenu = contenu + "</div>";
			marker_ppi[n] = createMarker(point,contenu, chim_ico);
			/** rayons de danger */
			var transparence = 0.10;
			cercles[n] = new Array();
			cercles[n][0] = cercle(Latitude,Longitude,r1,'#ff0000',transparence);
			cercles[n][1] = cercle(Latitude,Longitude,r2,'#ff0000',transparence);
			cercles[n][2] = cercle(Latitude,Longitude,r3,'#ff0000',transparence);
			n = n + 1;
		<?php
	}
	?>
}

/**
  *	Affichage tous les cercles de danger
  *
  */
  
function StructTemp(visible)
{
	if(visible){
		if(marker_ppi.length < 1)
			info_ppi(ppi);
		for(i=0;i<marker_ppi.length;i++)
		{
			map.addOverlay(marker_ppi[i]);
			for(j=0;j<3;j++)
			{
				map.addOverlay(cercles[i][j]);
			}
		}		
	}
	else{
		for(i=0;i<marker_ppi.length;i++)
		{
			map.removeOverlay(marker_ppi[i]);
			for(j=0;j<3;j++)
			{
				map.removeOverlay(cercles[i][j]);
			}
		}		
	}
}

/**
  *	affiche un scénario
  *
  */

function scenario(no, visible)
{
	if(visible)
	{
		if(!cercle_danger[no])
		{
			cercle_danger[no] = new Array();
			$.ajax({
   			type: "POST",
   			url: path2+"scenario.php",
   			data:"id="+no,
   			success: function(msg){
   				//alert(msg);
   				var dt = JSON.parse(msg);
   				cercle_danger[no][0] = cercle(dt[1],dt[2],dt['stocki_rayon1'],'#ff0000',0.10);
   				cercle_danger[no][1] = cercle(dt[1],dt[2],dt['stocki_rayon2'],'#ff0000',0.10);
   				cercle_danger[no][2] = cercle(dt[1],dt[2],dt['stocki_rayon3'],'#ff0000',0.10);
   				map.addOverlay(cercle_danger[no][0]);
					map.addOverlay(cercle_danger[no][1]);
					map.addOverlay(cercle_danger[no][2]);
   			}
   		})
		}
		else 
		{
			map.addOverlay(cercle_danger[no][0]);
			map.addOverlay(cercle_danger[no][1]);
			map.addOverlay(cercle_danger[no][2]);
		}
	}
	else{
		map.removeOverlay(cercle_danger[no][0]);
		map.removeOverlay(cercle_danger[no][1]);
		map.removeOverlay(cercle_danger[no][2]);
	}
}

/**
  *	méthode générique: dessine un cercle
  *	renvoie on objet cercle
  */

function cercle(lat,lng,rayon,color,transparence)
{
	var center = new GLatLng(lat,lng);
	var circlepoints = new Array();
	with (Math)
	{
		var rLat = (rayon/6378.8) * (180/PI);
		var rLng = rLat/cos(center.lat() * (PI/180));
		for (var a = 0 ; a < 361 ; a+=10 ) 
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

function helico()
{
	pt = new GLatLng(48.546808, 7.631815);
	markerH = new GMarker(pt,ico_heb);
	map.addOverlay(markerH);
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

function analyseMenu(no)
{
	if(no > 0)
	{
		var oScenario = document.getElementById(no);
		if(oScenario.checked)
			scenario(no, true);
		else
			scenario(no, false);
	}
	
	var oTracking = document.getElementById('mt');
	if(oTracking.checked) 
	{
    		mouseTracking = true;
	}
	else
	{
    		mouseTracking = false;
	}
	
	var oStructTemp = document.getElementById('st');
	if(oStructTemp.checked) 
	{
    		StructTemp(true);
	}
	else
	{
    		StructTemp(false);
	}
	var oRDV = document.getElementById('rdv');
	if(oRDV.checked)
		visibilite('rose','');
	else
		visibilite('rose','none');
	
	helico();
}

	$(document).ready(function () {  
		$.post("test.php", { name: "John", email: "john@ndd.com" },  
		function success(data){  
			alert(data.name +' '+data.email);  
			},"json"); // on passe en paramètre optionnel le type de retour ici JSON  
	});  

window.onload = init;
window.unload = GUnload;
