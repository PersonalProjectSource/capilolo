#!/usr/bin/env php
<?php
require "libClass/GitManager.php";
$manager = new GitManager($argv[1]);
try {
    $manager->cloneSource();
}
catch (Exception $e) {
    echo "Une exception a ete levee : ".$e->getMessage()."\n";
}