/*
*	test.js
*/
window.onload=testerNavigateur;

function recupService(hopID)
{
	if(hopID != 0)
	{
		objet_hxr = createXHR();
		objet_hxr.open("get","test_database.php?cible=service&source="+hopID,true);
		objet_hxr.onreadystatechange = affiche_service;
		objet_hxr.send(null);
	}
}

function affiche_service()
{
	if(objet_hxr.readyState == 4)
	{
		if(objet_hxr.status == 200)
		{
			document.getElementById("serviceID").options.length = 1;
			var ph = objet_hxr.responseText;
			var json = ph.parseJSON();
			//alert(ph);
			for(i=0;i<json.listeServices.length;i++)
			{
				var elementOption = document.createElement('option'); 
				var texteOption = document.createTextNode(json.listeServices[i].service_nom); 
			 	elementOption.setAttribute('value',json.listeServices[i].service_ID); 
			 	elementOption.appendChild(texteOption); 
			 	document.getElementById("serviceID").appendChild(elementOption);
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

function recupUF(serviceID)
{
	if(serviceID != 0)
	{
		objet_hxr2 = createXHR();
		objet_hxr2.open("get","test_database.php?cible=uf&source="+serviceID,true);
		objet_hxr2.onreadystatechange = affiche_uf;
		objet_hxr2.send(null);
	}
}

function affiche_uf()
{
	if(objet_hxr2.readyState == 4)
	{
		if(objet_hxr2.status == 200)
		{
			document.getElementById("ufID").options.length = 1;
			var ph = objet_hxr2.responseText;
			var json = ph.parseJSON();
			//alert(ph);
			for(i=0;i<json.listeServices.length;i++)
			{
				var elementOption = document.createElement('option'); 
				var texteOption = document.createTextNode(json.listeServices[i].uf_nom); 
			 	elementOption.setAttribute('value',json.listeServices[i].uf_ID); 
			 	elementOption.appendChild(texteOption); 
			 	document.getElementById("ufID").appendChild(elementOption);
			}
		}
		else
		{
			alert("Erreur serveur: "+objet_hxr2.status+" - "+objet_hxr2.statusText);
			objet_hxr2.abort();
			objet_hxr2 = null;
		}
	}
}

function testerNavigateur()
{
	document.getElementById("ID_hopital").onChange=function(){recupService(this.value);}
	document.getElementById("serviceID").onChange=function(){recupUF(this.value);}
}