<?php

 // Script de gestion de l'installation:
 //	- mise a jour des sources Github
 //	- revert des sources en cas de probleme 
 // - revert à volonté

require "libClass/Gitmanager.php";


$manager = new GitManager($argv[1]);


function cachecache($buffer) {

    echo "----------------------BUFFER-------------------------------\n";
    echo $buffer;
    echo "----------------------ENDBUFFER-------------------------------\n";
}

try {
	$manager->cloneSource();
}
catch (Exception $e) {
	echo "Une exception a ete levee : ".$e->getMessage()."\n";
}





