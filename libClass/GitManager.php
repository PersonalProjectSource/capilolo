<?php

require_once("Validator.php");
require_once("ReleaseManager.php");

<<<<<<< HEAD

=======
>>>>>>> 60a7096b05016b30699adc003f995d504098a374
class GitManager {
	
	const UP_TO_DATE = "Already up-to-date.";
	const CLONE_ALREADY_EXIST = "fatal: destination path 'Diagonalisation' already exists and is not an empty directory.";
	const PULL_DONE = "Checking connectivity... done."; // Check la valeur avec la commande
	const CLONE_DONE = "Checking connectivity... done.";
	const NOTHING = "";

	const PULL_COMMAND = "git pull ";
	const CLONE_COMMAND = "git clone ";

	const RELEASE_SOURCE_FOLDER = "sourceRelease/";
	const RELEASE_BASE_NAME = "CustomName";
<<<<<<< HEAD

    // TODO a modifier si l'on connais le pattern precis du format de l'url git.
    const PATTERN_URL_GIT = "((http:\/\/|https:\/\/)?(www.)?(([a-zA-Z0-9-]){2,}\.){1,4}([a-zA-Z]){2,6}(\/([a-zA-Z-_\/\.0-9#:?=&;,]*)?)?)";
=======
>>>>>>> 60a7096b05016b30699adc003f995d504098a374
	
	protected $url;
	protected $validator;
	protected $releaseManager;

<<<<<<< HEAD
    /**
     * Constructeur
     * @param $url
     */
	public function __construct ($url) {

		$this->url = $url;
		$this->releaseManager = new ReleaseManager();
	}

    /**
     * Gere le git Clone
     * @throws Exception
     */
	public function cloneSource ($argv) {

		$iTokkenId = time();
        $sReleasePath = self::RELEASE_SOURCE_FOLDER.$iTokkenId;

        $this->releaseManager->aRealeaseIndex['last'] = $sReleasePath;
        $this->releaseManager->aRealeaseIndex['token'] = $iTokkenId;
        echo "#################################### Check du retour de la commande git clone  ####################################################\n";
        echo (self::CLONE_COMMAND." ".$this->url." ".$sReleasePath."/");
		$sResult = system(self::CLONE_COMMAND." ".$this->url." ".$sReleasePath."/");
		if ($this->urlIsAgreed($this->url)) {
            var_dump("CheckResultVar ===>>> ",$sResult);
			switch ($sResult) {
				case self::CLONE_DONE:
					$this->validator->sourceValidator(); // TODO lbrau : Voir les conditions de validation du validator.
=======
	public function __construct ($url) {

		$this->url = $url;
		$this->validator = new Validator();
		$this->releaseManager = new ReleaseManager();
	}

	public function cloneSource () {

		// Extraire la commande system dans une methode pour plus de lisibilité.
		// Voir le role que pourrait jouer la classe ReleaseManager dans la suite de la commande

        // Release traitement.
		$iTokkenId = time();
		$sReleasePath = self::RELEASE_SOURCE_FOLDER.self::RELEASE_BASE_NAME.$iTokkenId;
		$this->aRealeaseIndex[$iTokkenId] = $sReleasePath;

		$sResult = system(self::CLONE_COMMAND." ".$this->url." ".$sReleasePath."/");

		if ($this->urlIsAgreed()) { // TODO lbrau
			switch ($sResult) {
				case self::CLONE_DONE:
					$this->validator->sourceValidator(); // TODO lbrau
>>>>>>> 60a7096b05016b30699adc003f995d504098a374
					$this->releaseManager->addRelease();
					break;
				case self::CLONE_ALREADY_EXIST:
					throw new Exception("Le depot existe deja \n"); // TODO 403 actuellement aucun moyen de verifier l'existant avec les retours fonction php.
					break;
				case self::NOTHING:
<<<<<<< HEAD
                    var_dump("##### passe 3 #####\n");
                    $this->releaseManager->addRelease(); // TODO voir si suppression apres test
					throw new Exception("L'erreur n'a pas pu etre identifiee. Faire une recherche sur 'TODO 403' dans les sources\n");
					break;
				default:
                    var_dump("##### passe 4 #####\n");
                    $this->releaseManager->addRelease(); // TODO voir si suppression apres test
                    //$this->releaseManager->revertRelease();die('dodone');
					throw new Exception("Operation terminee \n");
					break;
			}

			

=======
					throw new Exception("L'erreur n'a pas pu etre identifiee. Faire une recherche sur 'TODO 403' dans les sources\n");
					break;
				default:
					throw new Exception("Probleme lors de la mise à jour des sources\n");
					break;
			}
>>>>>>> 60a7096b05016b30699adc003f995d504098a374
		}
		else {
			throw new Exception("l'url n'est pas valide\n");
		}
	}

	public function checkout () {
		$bDone = true;
		return $bDone;
	}

<<<<<<< HEAD
    /**
     * Fait le pull uniquement si les condition de validation sont remplies
     *
     * @param null $argv
     * @param null $sParam
     * @throws Exception
     */
=======
	/**
	*	Fait le pull uniquement si les condition de validation sont remplies
	*/
>>>>>>> 60a7096b05016b30699adc003f995d504098a374
	public function pull ($argv = null, $sParam = null) {

		$sResult = system(self::TEST_COMMAND." ".$argv[1]);

<<<<<<< HEAD
		if ((boolean)$this->urlIsAgreed($this->url)) {
=======
		if ($this->urlIsAgreed()) { // TODO lbrau
>>>>>>> 60a7096b05016b30699adc003f995d504098a374
			switch ($sResult) {
				case self::UP_TO_DATE:
					// Code de mise a jour des sources
					break;
				case self::PULL_DONE:
					// Code de mise a jour des sources
					// Lancement des tests pour passer les sources téléchargé dans le validator.
<<<<<<< HEAD
					$this->validator->sourceValidator(); // TODO lbrau : Voir les conditions de validation du validator.
=======
					$this->validator->sourceValidator(); // TODO lbrau
>>>>>>> 60a7096b05016b30699adc003f995d504098a374
					break;
				case self::OTHER_CODE:
					throw new Exception("Probleme lors de la mise à jour des sources\n");
					break;
			}
		}
		else {
			throw new Exception("l'url n'est pas valide\n");
		}
	}

<<<<<<< HEAD
    /**
     * Check avec une regex la conformité de l'url ($this->url) du depot github.
     * retour true si l'url est conforme.
     * @return bool
     */
	private function urlIsAgreed ($sUrl) {
        $sPatternUrlGit = self::PATTERN_URL_GIT;
        return preg_match($sPatternUrlGit, $sUrl);
=======
	/**
	*	Check avec une regex la conformité de l'url ($this->url) du depot github
	*/
	private function urlIsAgreed () {
		return true;
>>>>>>> 60a7096b05016b30699adc003f995d504098a374
	}

	public function push ($sParam) {
		
	}

	public function merge ($sParam) {
		
	}



}