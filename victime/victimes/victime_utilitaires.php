<?php
/**
  *	victime_utilitaires.php
  *
  */

/**
  *	 est-ce un bracelet civic ?
  */
	function is_civic($identifiant)
	{
		if(substr($identifiant,0,4)=="3367")
		{
			global $gravite;
			$g = substr($identifiant,7,1);
			switch($g)
			{
				case 1: $gravite = 1; break;
				case 2: $gravite = 2; break;
				case 3: $gravite = 6; break;
				case 4: $gravite = 5; break;
			}
			$code = "F67 ";
			if(substr($$identifiant,4,3)=="010")
				$code .= "SM ";
			else
				$code .= "SD ";
			$code .= substr($identifiant,7,5);
		
			$identifiant = $code;
		}
		return $identifiant;
	}
?>