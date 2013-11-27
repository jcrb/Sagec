<?php
/**----------------------------------------- SAGEC ---------------------------------
  * This file is part of SAGEC67 Copyright (C) 2003-2010 (Jean-Claude Bartier).
  * SAGEC67 is free software; you can redistribute it and/or modify
  * it under the terms of the GNU General Public License as published by
  * the Free Software Foundation; either version 2 of the License, or
  * (at your option) any later version.
  * SAGEC67 is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  * GNU General Public License for more details.
  * You should have received a copy of the GNU General Public License
  * along with SAGEC67; if not, write to the Free Software
  * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
  */	
/** ---------------------------------------------------------------------------------
  * programme: 			bn_samu_lire.php
  * date de création: 	07/05/2011
  * auteur:					jcb
  * description:			Lit les données stockées dans la main courante SAMU et les
  *							affiche.
  *							Ce programme n'est pas autonome, il doit être inclu dans un
  *							wrapper qui lui fournit les primitives necessaires
  *								 
  * version:				1.0
  * maj le:			
  * -------------------------------------------------------------------------------*/
  
  $langue = $_SESSION['langue'];
  ?>
  <table>
  	<tr>
  		<th style="width:5%"><?php echo $string_lang['DATE'][$langue];?></th>
  		<th style="width:5%"><?php echo $string_lang['EXPEDITEUR'][$langue];?></th>
  		<th style="width:50%"><?php echo $string_lang['MESSAGE'][$langue];?></th>
  		<!--
  		<th style="width:5%"><?php echo $string_lang['MODIFIER'][$langue];?></th>
  		<th style="width:5%"><?php echo $string_lang['SUPPRIMER'][$langue];?></th>
  		-->
  	</tr>
  	<?php
  		$requete="SELECT LB_ID,LB_Date,LB_Expediteur,LB_Message,nom,livrebord.org_ID
		FROM livrebord,utilisateurs
		WHERE LB_Expediteur = ID_utilisateur
		AND LB_visible = 'o'
		ORDER BY LB_Date DESC";
		$result = ExecRequete($requete,$connexion);
		$mot = $string_lang['MODIFIER'][$langue];
		while($rep = mysql_fetch_array($result))
		{
			?><tr>
			<td><?php echo $rep['LB_Date'];?></td>
			<td><?php echo $rep['nom'];?></td>
			<td><div align="left"><?php echo Security::db2str($rep['LB_Message']);?></div></td>
						<!--
			<td><a href="bloc_note_modifier.php?LB_IDField=<?php echo $rep['LB_ID'];?>"><?php echo $mot;?></a></td>
			<td><?php echo $rep['LB_ID'];?></td>
						-->
			</tr><?php
		}
	?>
  </table>
  