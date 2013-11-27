/**
* utilitaires javascript
*/

/* document.onkeypress = process_keypress; */

/** modifie la couleur du fond si sélection */
		function _select(id)
		{
			document.getElementById(id).style.backgroundColor='#FFFFCC';
		}
		function deselect(id)
		{
			document.getElementById(id).style.backgroundColor='white';
		}
/**
*	permet de passer automatiquement au champ suivant
*	enCours: id du champ courant
*	suivant: id du champ suivant
*	limite: nb max de caractères acceptés avant saut au champ suivant
* http://www.journaldunet.com/developpeur/tutoriel/dht/040105_champ_suivant_auto.shtml
*/	
	function suivant(enCours, suivant, limite)
	{
  		if (enCours.value.length == limite)
    		document.code[suivant].focus();
  	}
  	
/**
* ajouter un champ avec son "name" propre;
*/
var c,c2,c3, ch1, ch2,old_result='resultat1',count=2;
 
function plus()
{
	//var value = document.getElementById('code1').value;//alert("value: "+value);
	//gestionClic(value);
	c=document.getElementById('cmd');

	var p = document.createElement("p");
	c.appendChild(p);
	var nom_label = document.createTextNode("Produit "+count+" ");
	var label = document.createElement("label");
	label.appendChild(nom_label);
	c.appendChild(label);

	//c2=c.getElementsByTagName('input');
	ch2=document.createElement('input');
 
	var idd='code'+count;
	ch2.setAttribute('type','text');
	ch2.setAttribute('size','13');
	ch2.setAttribute('name','commande[]');
	ch2.setAttribute('id',idd);
	ch2.setAttribute("onChange","plus()");
	ch2.setAttribute("onFocus","_select('"+idd+"')");
	ch2.setAttribute("onBlur","deselect('"+idd+"')");
	//c.appendChild(ch1);
	c.appendChild(ch2);
	ch2.focus();
	
	// creation du champ quantité 
	
	var nom_label2 = document.createTextNode(" quantité: ");
	c.appendChild(nom_label2);
	
	idd='qte'+count;
	ch3=document.createElement('input');
	ch3.setAttribute('type','text');
	ch3.setAttribute('size','3');
	ch3.setAttribute('name','qte[]');
	ch3.setAttribute('value','1');
	ch3.setAttribute('id',idd);
	ch3.setAttribute("onFocus","_select('"+idd+"')");
	ch3.setAttribute("onBlur","deselect('"+idd+"')");
	//c.appendChild(ch1);
	c.appendChild(ch3);
	/**
	var idc = 'resultat'+count;
	sp.setAttribute('id',idc);
	sp.setAttribute('name','spanclass');
	sp.innerHTML = '????';
	c.appendChild(sp);
	old_result = idc;
	*/
 	count++;
 	
	//document.getElementById('sup').style.display='inline';
}

function gestionClic(val)
{
    var url = './valide.php'; 
    var myAjax = new Ajax.Request(
            url, 
            {
                method: 'get',
                parameters: {nom1: val, nom2: 2},
					onSuccess: function()
					{
						var c=document.getElementById('cmd');
						var sp = document.createElement('span');
						var txt = document.createTextNode("aaaa");
						sp.appendChild(txt);
						c.appendChild(sp);
						//alert("idd = "+ c);
					},
					onFailure: function() { alert("Une erreur est survenue lors de l'appel AJAX.\nRecharger la page devrait résoudre le problème.") }

            });
} // gestionClic()

function gestionReponse(xhr)
{
    if (xhr.status == 200)
    {
    		alert("idd = "+xhr.param2);
      	$('resultatId').innerHTML = xhr.responseText;
    }
    else
    {
    		alert("pas ok");
        $('resultatId').innerHTML = xhr.status;
    }
    plus();
}
