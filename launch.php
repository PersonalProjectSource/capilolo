#!/usr/bin/env php
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
}