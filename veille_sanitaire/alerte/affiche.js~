/**
*	affiche.js
*/

	function afficheListe()
	{			
		if(objet_hxr.readyState == 4)
		{
			if(objet_hxr.status == 200)
			{
				document.alerte.id_item.options.length = 0; /** efface la liste */
				var ph = objet_hxr.responseText;
				//alert(ph);
				json = ph.parseJSON();
				
				for(i=0;i<json.pharma.length;i++)
				{
					nom = json.pharma[i].nom;
					value = json.pharma[i].value;
    				document.alerte.id_item.options[i] = new Option(nom,value,false,false);
    			}
    			
    			document.getElementById("charge").style.visibility="hidden";
			}
			else
			{
				alert("Erreur serveur: "+objet_hxr.status+" - "+objet_hxr.statusText);
				document.getElementById("charge").style.visibility="hidden";
				objet_hxr.abort();
				objet_hxr = null;
			}
		}
	}
	
	function liste(item)
	{
		objet_hxr = createXHR();
		temps = new Date().getTime();//création d'une variable temps pour l'anti-cache
		objet_hxr.open("get","select_item.php?anticache="+temps+"&cible=pharma&option="+item,true);
		objet_hxr.onreadystatechange = afficheListe;
		document.getElementById("charge").style.visibility="visible";
		objet_hxr.send(null);// envoi de la requete
	}