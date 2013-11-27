<?php
//----------------------------------------- SAGEC --------------------------------------------------------

// This file is part of SAGEC67 Copyright (C) 2003 (Jean-Claude Bartier).
// SAGEC67 is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
// SAGEC67 is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with SAGEC67; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
/**																										
*	programme: 			vecteur_ajout.php																	 	 
*	date de création: 09/09/2003																		
*	auteur:				jcb																				 
*	description:		Enregistre les modification d'état des vecteurs
*							et tient à jour le journal des modifications								 											
*	@version $Id$																				 
*	maj le:				12/08/2008																		
*/																										 
//---------------------------------------------------------------------------------------------------------
include($backPathToRoot."utilitairesHTML.php");
include($backPathToRoot."contact_main.php");
include($backPathToRoot."adresse_ajout.php");
//$back = $_REQUEST['back'];
?>
<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend>Moyen</legend>
		<p>
			<label for="nom" title="nom">Nom:</label>
			<input type="text" name="nom" id="nom" title="nom" value="<? echo $rub['Vec_Nom'];?>" size="50" onFocus="_select('nom');" onBlur="deselect('nom');"/>
		</p>
		<p>
			<label for="places_c" title="nombre de places allongées">Organisme:</label>
			<?php SelectOrganisme($connexion,$_SESSION['organisation'],$langue);?>
		</p>
		<p>
			<label for="type" title="type de vecteur">Type vecteur:</label>
			<?php SelectTypeVecteur($connexion,$rub['Vec_Type'],"");/* remplacer "" par $langue */?>
		</p>
		<p>
			<label for="ind" title="indicatif radio">Indicatif:</label>
			<input type="text" name="indicatif" id="ind" title="ind" value="<? echo $rub['Vec_Indicatif'];?>" size="50" onFocus="_select('ind');" onBlur="deselect('ind');"/>
		</p>
		<p>
			<label for="ind" title="indicatif radio">Immatriculation:</label>
			<input type="text" name="immatriculation" id="ind" title="ind" value="<? echo $rub['Vec_immatriculation'];?>" size="10" onFocus="_select('ind');" onBlur="deselect('ind');"/>
		</p>
		<p>
			<label for="places_a" title="nombre de places assises">Places assises:</label>
			<input type="text" name="places_a" id="places_a" title="places_a" value="<? echo $rub['Vec_place_assise'];?>" size="10" onFocus="_select('places_a');" onBlur="deselect('places_a');"/>
		</p>
		<p>
			<label for="places_c" title="nombre de places allongées">Places couchées:</label>
			<input type="text" name="places_c" id="places_c" title="places_c" value="<? echo $rub['Vec_place_couche'];?>" size="10" onFocus="_select('places_c');" onBlur="deselect('places_c');"/>
		</p>
		
		<!-- Status du véhicule -->
		<p>
			<label for="status" title="status">status: </label>
			<?php
			$etat=ChercheTypeEtatVecteur($_GET['ttvecteur'],$connexion);
			SelectEtatVecteur($connexion,$etat,$langue);// remplacer "" par $langue
			?>
		</p>
		<!--  engagé ou non -->
		<p>
		<label for="engage" title="engagé ?"><?php echo $string_lang['ENGAGE'][$langue];?></label>
		<?php if($rub['Vec_Engage']){?>
			<input type="checkbox" name="engage" value="o" checked>
		<?php }else{ ?>
			<input type="checkbox" name="engage" value="o">
			<?php } ?>
		</p>
		<P>
			<label for="lng" title="longitude degré décimaux">Longitude actuelle</label>
			<input type="text" name="lng_actuelle" id="lng" title="lng" value="<? echo $rub['lng'];?>" size="10" onFocus="_select('lng');" onBlur="deselect('lng');"/>
		</p>
		<P>
			<label for="lat" title="latitude degré décimaux">Latitude actuelle</label>
			<input type="text" name="lat_actuelle" id="lat" title="lat" value="<? echo $rub['lat'];?>" size="10" onFocus="_select('lat');" onBlur="deselect('lat');"/>
		</p>
		
		
	</fieldset>
	
	<fieldset id="field1">
		<legend><? echo $string_lang['CONTACT'][$langue];?> </legend>
		<?php
			$service_caracid=$_GET['ttvecteur'];
			$type=0;//nouveau
			$nature=3;//nature_contact = vecteur
			$back="vecteur_saisie.php";//adresse de retour
			$variable="$_GET[ttvecteur]";// variable de retour
			if($_GET['ttvecteur'])
				contact($service_caracid,$type,$nature,$contact_id,$back,$variable,$_GET['tri']);
		?>
	</fieldset>
	
	<fieldset id="field1">
		<legend> Caractéristiques </legend>
		<p>
			<label>&nbsp;</label>
			<?php if($rub['dsa'])
				print("<INPUT TYPE=\"CHECKBOX\" VALUE=\"o\" NAME=\"dsa\"CHECKED>DSA ");
			else
				print("<INPUT TYPE=\"CHECKBOX\" VALUE=\"o\" NAME=\"dsa\">DSA ");?>
		</p>
		<p>
			<label>&nbsp;</label>
			<?php if($rub['baria'])
				print("<INPUT TYPE=\"CHECKBOX\" VALUE=\"o\" NAME=\"baria\"CHECKED>Transport Bariatrique ");
			else
				print("<INPUT TYPE=\"CHECKBOX\" VALUE=\"o\" NAME=\"baria\">Transport Bariatrique ");?>
		</p>

	</fieldset>
	

		<?php
		$adresse_ID = $rub['adresse_ID'];
		print("<input type=\"hidden\" name=\"adresse_ID\" value=\"$adresse_ID\">");
		get_adresse($adresse_ID,$ville_ou_commune='V',$classe='');
		?>
	
	<!-- champ de type BUTTON -->
	<input type="submit" name="ok" id="valider" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
	
</div>

