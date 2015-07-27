#!/usr/bin/env php
<?php
require "libClass/GitManager.php";



if ($argv[1] == 'revert') {
	require "libClass/ReleaseManager.php";
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
