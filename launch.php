<<<<<<< HEAD
#!/usr/bin/env php
<?php
require "libClass/GitManager.php";

if ($argv[1] == 'revert') {
	@include "libClass/ReleaseManager.php";
	$rm = new ReleaseManager();
	echo 'revert encours'; 
	$rm->revertRelease();
}
else {
	$argv[1] = "-b preprod https://adelou:oustAdel210285@github.com/NGRP/Total-Bitume.git";
	$manager = new GitManager($argv[1]);
	try {
	    $manager->cloneSource();
	}
	catch (Exception $e) {
	    echo "Une exception a ete levee : ".$e->getMessage()."\n";
	}	
=======
<?php

 // Script de gestion de l'installation:
 //	- mise a jour des sources Github
 //	- revert des sources en cas de probleme 
 // - revert à volonté

require "libClass/Gitmanager.php";


$manager = new GitManager($argv[1]);

try {
	$manager->cloneSource();
}
catch (Exception $e) {
	echo "Une exception a ete levee : ".$e->getMessage()."\n";
>>>>>>> 60a7096b05016b30699adc003f995d504098a374
}
