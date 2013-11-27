<?php
/**
  *	dossier_cata_utilitaires.php
  */
  
  $local = Array('','Secrétariat entrée','Secrétariat sortie');
  
  /**
    * poste_saisie()
    * retourne la liste des postes de saisie
    * @return $poste
    */
  function poste_saisie($p)
  {
  	?>
  	<select name="poste" size="1">
  		<option value="2" <?php if($p==2)echo 'SELECTED';?> >2.PRV</option>
  		<option value="6" <?php if($p==6)echo 'SELECTED';?> >6.PMA Secteur soins</option>
  		<option value="4" <?php if($p==4)echo 'SELECTED';?> >4.PMA-Secrétariat entrée</option>
  		<option value="1" <?php if($p==1)echo 'SELECTED';?> >1.Chantier</option>
  		<option value="3" <?php if($p==3)echo 'SELECTED';?> >3.PMA Attente Tri</option>
  		<option value="7" <?php if($p==7)echo 'SELECTED';?> >7.PMA Attente PRE</option>
  		<option value="8" <?php if($p==8)echo 'SELECTED';?> >8.PMA Secrétariat de sortie</option>
  		<option value="5" <?php if($p==5)echo 'SELECTED';?> >5.PMA Attente soins</option>
  		<option value="5" <?php if($p==9)echo 'SELECTED';?> >9.PMA Attente évacuation</option>
  		<option value="10" <?php if($p==10)echo 'SELECTED';?> >10.Evacuation en cours</option>
  		<option value="11" <?php if($p==11)echo 'SELECTED';?> >11.Arrivée destination</option>
  		<option value="12" <?php if($p==12)echo 'SELECTED';?> >12.Laissé sur place</option>
  		<option value="13" <?php if($p==13)echo 'SELECTED';?> >13.Morgue</option>
  		<option value="99" <?php if($p==99)echo 'SELECTED';?> >99.Autre</option>
  	</select>
  	<?php
  }
  
  /**
    * localisation()
    * Affiche la liste des structures temporaires de type PMA
    * @return $id_pma contient ID et le nom du PMA séparés par un ';'
    */
  function localisation($connexion,$item_select)
  {
  	$requete = "SELECT ts_ID, ts_nom FROM temp_structure WHERE ts_type ='1'";
  	$resultat = ExecRequete($requete,$connexion);
  	print($item_select);
  	print("<SELECT NAME=\"id_pma\" size=\"1\">");
	$mot="Inconnu";
	print("<OPTION VALUE = \"0\">$mot </OPTION> \n");
	while($rub=mysql_fetch_array($resultat))
	{	
		$rep = $rub['ts_ID'].';'.$rub['ts_nom'];
		print("<OPTION VALUE=\"$rep\" ");
		if($item_select == $rub['ts_ID']) print(" SELECTED");
		print(">".Security::db2str($rub['ts_nom'])."</OPTION> \n");
	}
	@mysql_free_result($resultat);
	print("</SELECT>\n");
  }
  
  /**
    *	nationalite
    * liste des nationalité possibles
    * @return $nationalite
    */
  function nationalite($connexion,$item_select)
  {
  		$requete = "SELECT pays_ID,pays_nom FROM pays ORDER BY pays_nom";
		$result = ExecRequete($requete,$connexion);
		print("<SELECT NAME =\"nationalite\" size=\"1\">");
		print("<OPTION VALUE=\"0\">inconnu ");
		while($pays=mysql_fetch_array($result))
		{
			print("<OPTION VALUE=\"$pays[pays_ID]\" ");
			if($item_select == $pays['pays_ID']) print(" SELECTED");
			print("> $pays[pays_nom] </OPTION> \n");
		}
		@mysql_free_result($result);
		print("</SELECT>\n");
  }
  
  /**
    *	age2
    * liste des tranches d'age possibles
    * @return $age2
    */
  function age2($connexion,$item_select)
  {
  		$requete = "SELECT uf_age_ID,uf_age_nom FROM uf_age ORDER BY uf_age_nom";
		$result = ExecRequete($requete,$connexion);
		print("<SELECT NAME =\"age2\" size=\"1\">");
		print("<OPTION VALUE=\"0\">inconnu ");
		while($rub=mysql_fetch_array($result))
		{
			print("<OPTION VALUE=\"$rub[uf_age_ID]\" ");
			if($item_select == $rub['uf_age_ID']) print(" SELECTED");
			print("> $rub[uf_age_nom] </OPTION> \n");
		}
		@mysql_free_result($result);
		print("</SELECT>\n");
  }
?>
