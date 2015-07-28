<?php

class Validator {

	/**
	*	Execute les conditions du validator. Throw une exception si une erreur est levée.
	*/
	public function sourceValidator() {
		$traitementAFaire = true;
		if (false == $traitementAFaire) {
<<<<<<< HEAD
			throw new Exception("La derniere release ne satisfait pas aux conditions de validations.\n Retour a la derniere release fonctionnelle.");
=======
			throw new Exception("throw validator", 1);
>>>>>>> 60a7096b05016b30699adc003f995d504098a374
		}

		return true;
	}

	public function test() {

		return " validator ok ";
	}
}