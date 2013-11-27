<form name="" action= "" method = "post">

<div id="div2">
	<!-- champ de type INPUT -->
	<fieldset id="field1">
		<legend><? echo $string_lang['ORGANISME'][$langue];?> </legend>
		<p>
			<label for="nom" title="nom">Nom:</label>
			<input type="text" required placeholder="champ obligatoire" name="nom" id="nom" title="nom" value="<? echo $rub[0];?>" size="50" onFocus="_select('nom');" onBlur="deselect('nom');"/>
		</p>
		<p>
			<label for="nomc" title="nomc">Nom complet:</label>
			<input type="text" name="nomc" id="nomc" title="nomc" value="<? echo $rub[0];?>" size="50" onFocus="_select('nomc');" onBlur="deselect('nomc');"/>
		</p>
	</fieldset>
	<!-- champ de type TextArea -->
	<fieldset id="field1">
		<legend> Commentaires </legend>
		<p>
			<label for="rem" title="rem">Remarque:</label>
			<textarea name="rem" id="rem" rows="2" cols="50"></textarea>
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend> Calendrier </legend>
		<label for="date1" title="date1">Date 1:</label>
		<input TYPE="text" VALUE="" NAME="date" SIZE="10" id="date1">
		<input type="button" class="bouton" onClick="window.open('../calendrier/mycalendar.php?form=dispo_main&elem=date','Calendrier','width=200,height=280')">
	</fieldset>
	
	<fieldset id="field1">
		<legend> Case à cocher </legend>
		<p>
			<label for="ferme">ligne fermée :</label>
			<input type="checkbox" id="ferme" name="ferme" <?php if($way['way_ferme']=='o') echo(' CHECKED')?> />
		</p>
	</fieldset>
	
	<fieldset id="field1">
		<legend> Bouton radio </legend>
		<p>
			<label for="type" title="type">type :</label>
			<input type="radio" name="type" id="type" title="type" value="1" onFocus="_select('type');" onBlur="deselect('type');"/> Service
			<input type="radio" name="type" id="type" title="type" value="2" onFocus="_select('type');" onBlur="deselect('type');"/> UF
		</p>
	</fieldset>
	
	<!-- champ de type BUTTON -->
	<input type="submit" name="ok" id="valider" value="<? echo $string_lang['VALIDER'][$langue];?>"/>
	
</div>
