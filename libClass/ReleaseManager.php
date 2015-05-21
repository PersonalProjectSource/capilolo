<?php

class ReleaseManager {


    const PATH_VENDORS = "sourceRelease/shared";
    const VENDOR_RELATIVE_PATH_FROM_RELEASE = "../shared/vendor/";
    const BIN_RELATIVE_PATH_FROM_RELEASE = "../shared/bin/";
    const NOMBRE_RELEASES_HISTORISEES = 5;
    const PATH_RELEASE_CACHE = "cache/releaseName.cache";
    const VHOST_PATH = "";

    public $aRealeaseIndex;
    protected static $bVendorsIsCreated;

	public function __construct() {
		$aRealeaseIndex = array();
        self::$bVendorsIsCreated = false;
	}

	/**
	*	Ajoute une release apres validation. 
	*	Cree un lien symbolique pour faire la liaison avec le projet.
	*/
	public function addRelease() {

        if (false == self::$bVendorsIsCreated) {
            system("sudo mkdir ".self::PATH_VENDORS);
            system("sudo chmod -R 777 ".self::PATH_VENDORS);
            system("sudo chmod 777 -R sourceRelease/");
        }

        echo "----------- start ---------------\n";
        system("pwd");
        system("curl -sS https://getcomposer.org/installer | php");
        echo "------------ end ---------------\n";

        system("sudo mv composer.phar ".self::PATH_VENDORS);
        system("sudo cp ".$this->aRealeaseIndex['last']."/composer.json ".self::PATH_VENDORS."/");
        system("cd ".self::PATH_VENDORS."/ && php composer.phar install");
        $this->createSymlink(self::PATH_VENDORS."/vendor", $this->aRealeaseIndex['last']);
        $this->keepLimitedReleases();

        // TODO add symlink avec le path VHOST
	}

    /**
     * Gere la creation de liens symboliques pour les sources a partager avec la release courante.
     */
    private function createSymlink() {
        system("ln -s ".self::VENDOR_RELATIVE_PATH_FROM_RELEASE." ".$this->aRealeaseIndex['last']."/vendor");
        echo "_____________check________________\n";
        system('pwd');
        echo("pwd && sudo rm -R  ".$this->aRealeaseIndex['last']."/bin/\n");

        // Test de suppression de bin old
        system("sudo rm -R  ".$this->aRealeaseIndex['last']."/bin/\n");
        system("ln -s ".self::BIN_RELATIVE_PATH_FROM_RELEASE." ".$this->aRealeaseIndex['last']."/"); // ln lib/
        echo "_____________endcheck________________\n";
    }

    /**
     * Methode servant a garantir le nombre de release historisées
     * Ce parametre est configurable dans la constante de classe release manager.
     */
    public function keepLimitedReleases() {

        $iReleaseNumber = $this->getNumberOfRelease();
        $this->createCacheRelease($this->aRealeaseIndex['last']);
        if (self::NOMBRE_RELEASES_HISTORISEES < $iReleaseNumber) {
            // Suprime les plus anciennes releases.
            $this->smashRelease(GitManager::RELEASE_SOURCE_FOLDER);
        }
    }

    /**
     * Parcours le dossier et supprime les plus anciennes release pour qu'il n'en reste plus que 5.
     */
    private function smashRelease ($sFolderToSmash) {
        //TODO faire le systeme de clean release avec le dossier de cache.
    }

    /**
     * Renvoi le nombre de release présent dans le dossier release.
     * @return string
     */
    private function getNumberOfRelease() {
        // Voir si l'on garde la commande ou si l'on utilise le fichier de cache release.
        $iReleaseNumber = trim(system("ls -L ".GitManager::RELEASE_SOURCE_FOLDER."| wc -l "));
        return $iReleaseNumber;
    }

    /**
     * Gere la mise en cache des noms de releases (ajout/edition).
     * @param string $sAction
     */
    public function createCacheRelease($sReleaseName, $sAction = "add") {
        // Creation d'un fichier de cache release
        $pStream = fopen(self::PATH_RELEASE_CACHE,"a");
        fwrite($pStream, $sReleaseName."\n");
        if ("add" == $sAction) {
            echo "ajoute une release\n";
        }
    }





    public function revertRelease () {}

    public function removeRelease() {}
}