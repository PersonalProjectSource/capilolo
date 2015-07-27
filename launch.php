#!/usr/bin/env php
<?php
require "libClass/GitManager.php";
require "libClass/ReleaseManager.php"


if ($argv[1] == 'revert') {

	$rm = new ReleaseManager();
	echo 'revert encours'; 
	$rm->revertRelease();
}
else {

	$manager = new GitManager($argv[1]);
	try {
	    $manager->cloneSource();
	}
	catch (Exception $e) {
	    echo "Une exception a ete levee : ".$e->getMessage()."\n";
	}	
}
