<?php

class ReleaseManager {

	public $aRealeaseIndex;


	public function __construct() {

		$aRealeaseIndex = array();
	}

	/**
	*	Ajoute une release apres validation. 
	*	Cree un lien symbolique pour faire la liaison avec le projet.
	*/
	public function addRelease() {
		echo "methode add release\n";
	}

	public function removeRelease() {}

	public function revertRelease () {}
}