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
}
