<?php
/**
  *	moyens_engages.php
  *
  *	cette classe doit être appelée par un wraper qui doit lui fournir
  *	la connexion au BD ainsi que l'environnement d'affichage
  *	Voir le fichier asso/moyens_wraper pour un exemple
  */

$requete="SELECT Vec_Nom,Vec_Type,Vec_Engage,Vec_ID FROM vecteur WHERE org_ID = '$_SESSION[organisation]'";
			if($type_moyen != 0)
	  			$requete .= "AND Vec_Type = '$type_moyen'
	  		";
			$resultat = ExecRequete($requete,$connexion);

?>
<div id="div2">
	<fieldset id="field1">
		<legend>Vecteurs Engagés </legend>
		<p>
			<table id="tss" width="25%"><?php
			while($rub=mysql_fetch_array($resultat))
			{
				$e = $rub[Vec_ID];
				?>
				<tr>
					<?php if($rub['Vec_Engage'] =='o') echo('<td id="tdLeft" bgcolor="yellow">');else echo('<td id="tdLeft">');?>
					<label for="<?php echo $e;?>"><?php echo $rub['Vec_Nom']?></label></td>
					<?php if($rub['Vec_Engage'] =='o') echo('<td bgcolor="yellow">');else echo('<td>');?>
					<input type="checkbox" id="<?php echo $e;?>" onClick="ischeck(<?echo $e; ?>)") name="vec[]" value="<?php echo $e?>"
					<?php if($rub['Vec_Engage'] =='o') echo(' CHECKED bgcolor="yellow" ')?> />
				</td></tr>
				<?php }?>
				</table>
		</p>
	</fieldset>
</div>