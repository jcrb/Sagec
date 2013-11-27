
function Choix(form)
{
	document.Intervenants.submit();
}

function newLangue(id)
{
	adresse = "langue/langue_saisie.php?personne_id="+id;
	fenLangue=window.open(adresse,"langue","width=260,height=150,scrolling=no,toolbar=no,menubar=no,location=center,directories=no,status=no");
}
/*
	newContact()
	id identifiant de l'objet auquel se rattache le contact
	type opération à effectuer: création=0, modifier=1, supprimer=2
	nature caractéristique de l'objet auquel se rattache le contact: personne, organisme, service, etc.
	enregistrement_id n°de l'enregistrement dans le fichier contact
*/
function newContact(id,type,nature,enregistrement_id)//type= 0 nouveau 1 = modifier 2 = supprimer
{
	adresse = "contact/contact_saisie.php?personne_id="+id+"&type="+type+"&enregistrement="+enregistrement_id+"&nature="+nature;
fenContact=window.open(adresse,"contacts","width=700,height=250,scrolling=no,toolbar=no,menubar=no,location=center,directories=no,status=no");
}

function ferme()
{
	if(typeof(fenLangue)=="object" && fenLangue.closed==false)
		fenLangue.close();
}

function fermeContact()
{
	if(typeof(fenContact)=="object" && fenLangue.closed==false)
		fenContact.close();
}
/*
	alerte_supprimer
	no 		n° de l'enregistrement à supprimer
	id 		paramètres pour le retour
	back 	adresse de retour
	param 	nom de la variable pour le retour. par ex. pour un intervenant on aura param = personne et
			id = personne_ID
*/
function alerte_supprimer(no,id,back,param)
{
	if(confirm("Voulez-vous vraiment supprimer cet enregistrement ?"))
	{
		location.replace("contact/contact_supprime.php?enregistrement_ID=" + no + "&back="+ back +"&param="+param+"&id="+id);
		//"&back=../intervenant_saisie.php&personne="
	}
}
