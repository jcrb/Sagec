 <?php

 /*
 La connexion doit être effective à la bdd mysql
 $table : $table de la bdd concernée
 $value : colone de la table à seter dans les values
 $key : colone de la table à afficher dans le champ
 $where : condition optionnelle du select
 $origin : tableau $key => $value des options a préséter
 $selected : value de l'option sélectionnée
 $multiple : true = liste a selection multiple
 $class : class css a appliquer
 $style: $style css a appliquer

 description : fonction qui génère un élément de formulaire liste déroulante sélect
 */

//require_once("../pma_requete.php");


/**
*	genere_select("plan", "ppi","ppi_ID","ppi_name",$connect);
*	@data $name nom de la liste. C'est �galement le nom de la variable de retour
*	@data $table nom de la table dans la base de donn�es
*	@data	$value nom du champ de la table qui servira � renseigner VALUE de OPTION
*	@data $key   nom du champ de la table qui servira � renseigner le nom affich� dans la liste
*	@data $connect variable de connexion
*	@data	$where compl�ment pour la requete SQL
*	@data $origin tableau permettant d'imposer les premiers items ($origin = array('--?--'=>'0');)
*	@data $id	identifiant du code HTML
*	@data $selected valeur de $value permettant de s�lectionner l'item par d�faut de la liste
*/

//$backPathToRoot = "../";
require_once($backPathToRoot."login/init_security.php");

function genere_select($name,$table, $value, $key,$connect, $where='', $origin=array(), $id='', $selected='', $multiple=false, $class='', $style='',$todo='')
{
	$requete = "SELECT ".$value.", ".$key." FROM ".$table." ".$where; 
	$resultat = ExecRequete($requete,$connect);
	
	echo '<select';
 	if ($multiple == true) {echo ' multiple ';}
 	if ($class != '') {echo 'class="'.$class.'"';}
 	if ($style != '') {echo 'style="'.$style.'"';}
 	if($multiple == true)
 		echo ' name="'.$name.'[]" ';// si multiple, il faut un tableau 
 	else
 		echo ' name="'.$name.'" ';
 	echo ' id="'.$name.'" ';
 	if ($id != '') {echo 'id="'.$id.'"';} 
 	if($todo != '')
		echo 'onChange="submit()";';/*' onChange="submit();"';*/
	echo '>'."\n\r";
	
	//si on a un tableau d'options pr�remplis on les g�n�re
	if(count($origin)>0){
	 foreach ($origin as $k => $v)
	 {
 		echo '<option value="'.$v.'"';
 		if($v == $selected) { echo ' selected="selected" ';}
 		echo '>';
 		echo $k;
 		echo '</option>'."\n\r";
 	 }
 	}
	// le reste de la liste est fornie par la table 
 	while ($val = mysql_fetch_array($resultat))
 	{
 		echo '<option value="'.$val[$value].'"';
 		if($val[$value] == $selected)
 			{ echo ' selected="selected" '; }
 		echo '>';
 		echo Security::db2str($val[$key]);
 		echo '</option>'."\n\r";
 	}
	echo '</select>';
}

function genere_select2($name,$table, $value, $key,$connect, $where='', $origin=array(), $id='', $selected='', $class='', $style='')
{
	$requete = "SELECT ".$value.", ".$key." FROM ".$table." ".$where; 
	$resultat = ExecRequete($requete,$connect);
	
	echo '<select';
 	if ($multiple == true) {echo ' multiple ';}
 	if ($class != '') {echo 'class="'.$class.'"';}
 	if ($style != '') {echo 'style="'.$style.'"';}
 		echo ' name="'.$name.'[]" ';// si multiple, il faut un tableau 
 	if ($id != '') {echo 'id="'.$id.'"';} 
	echo '>'."\n\r";
	
	//si on a un tableau d'options préremplis on les génère
	 foreach ($origin as $k => $v)
	 {
 		echo '<option value="'.$v.'"';
 		if($v == $selected) { echo ' selected="selected" ';}
 		echo '>';
 		echo $k;
 		echo '</option>'."\n\r";
 	 }
	// le reste de la liste est fornie par la table 
 	while ($val = mysql_fetch_array($resultat))
 	{
 		echo '<option value="'.$val[$value].'"';
 		if($val[$value] == $selected)
 			{ echo ' selected="selected" '; }
 		echo '>';
 		echo $val[$key];
 		echo '</option>'."\n\r";
 	}

	echo '</select>';
}
/*
function genere_select2 ($name, $table, $value, $key, $where='', $origin=array(), $id='', $selected='', $multiple=false, $class='', $style='')
{
	
 	//if(!isset($name) or !isset($table) or !isset($value) or !isset($key)) { print("erreur");return false; break; }

 	echo '<select';
 	if ($multiple == true) {echo ' multiple ';}
 	if ($class != '') {echo 'class="'.$class.'"';}
 	if ($style != '') {echo 'style="'.$style.'"';}
 	echo ' name="'.$name.'" ';
 	if ($id != '') {echo 'id="'.$id.'"';} 
	 echo '>'."\n\r";
 	//si on a un tableau d'options préremplis on les génère
	 foreach ($origin as $k => $v)
	 {
 		echo '<option value="'.$v.'"';
 		if($v == $selected) { echo ' selected="selected" ';}
 		echo '>';
 		echo $k;
 		echo '</option>'."\n\r";
 	 }

 	//on sélect les données dans la bdd
 	$requete = "SELECT ".$value.", ".$key." FROM ".$table." ".$where; 
	$resultat = ExecRequete($requete,$connexion);

 	while ($val = mysql_fetch_array($req))
 	{
 		echo '<option value="'.$val[$value].'"';
 		if($val[$value] == $selected)
 			{ echo ' selected="selected" '; }
 		echo '>';
 		echo $val[$key];
 		echo '</option>'."\n\r";
 	}
 	echo '</select>';
 	 	print($resultat);
}*/
?>
