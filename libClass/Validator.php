<?php

class Validator {

	/**
	*	Execute les conditions du validator. Throw une exception si une erreur est levée.
	*/
	public function sourceValidator() {
		$traitementAFaire = true;
		if (false == $traitementAFaire) {
			throw new Exception("throw validator", 1);
		}

		return true;
	}

	public function test() {

		return " validator ok ";
	}
}