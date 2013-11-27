<?php
/*
*	file_manip.php
*  routines de manipulation de fichiers
*	@version 1.0
*  @date 22/08/2007
*	@copyright JCB
*/

/*
*
*/
function create_dir($dirname)
{
	if(mkdir($dirname,0777))
		return true;
	return false;
}

/*
*	Supprime un dossier et tout ce qu'il contient
*/
function remove_dir($dirname){
        if ($dirHandle = opendir($dirname)){
            $old_cwd = getcwd();
            chdir($dirname);

            while ($file = readdir($dirHandle)){
                if ($file == '.' || $file == '..') continue;

                if (is_dir($file)){
                    if (!full_rmdir($file)) return false;
                }else{
                    if (!unlink($file)) return false;
                }
            }

            closedir($dirHandle);
            chdir($old_cwd);
            if (!rmdir($dirname)) return false;

            return true;
        }else{
            return false;
        }
}

/*
* supprime un fichier
*/
function remove_file($filename)
{
	if (!unlink($filename)) return false;
	else return true;
}

/*
*	renomme un fichier
*/
function rename_file($old_name, $new_name)
{
	return rename($old_name, $new_name);
}

?>