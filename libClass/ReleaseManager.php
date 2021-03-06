<?php

class ReleaseManager {

<<<<<<< HEAD
    // PATH INTERNE A L'APPLI

    // PATH INTERNE A L'APPLI
    const PATH_VENDORS = "sourceRelease/shared";
    const VENDOR_RELATIVE_PATH_FROM_RELEASE = "../shared/vendor/";
    const BIN_RELATIVE_PATH_FROM_RELEASE = "../shared/bin/";
    const NOMBRE_RELEASES_HISTORISEES = 5;
    const PATH_RELEASE_CACHE = "cache/releaseName.cache";
    const VHOST_PATH = "/etc/httpd/conf.d/";
    const PROJECT_NAME = "finaltest.conf"; // TODO a parametrer

    // const API_ROOT_PATH = "/home/optimus/Documents/Total/capilolo/";
    // const PATH_PARAMETER_SYMLINK = "/Users/laurentbrau/Documents/Audit_ADEL/ScriptsAdel/sourceRelease/shared";
    // const VHOST_PROJECT_PATH = "/var/www/bitume";

    const API_ROOT_PATH = "/var/www/deploy/";
    const PATH_PARAMETER_SYMLINK = "/var/www/deploy/sourceRelease/shared";
    const VHOST_PROJECT_PATH = "/var/www/bitume";

    public $aRealeaseIndex;
    private $sLastReleaseName;
    protected static $bVendorsIsCreated;

	public function __construct() {
		$this->aRealeaseIndex = array();
        self::$bVendorsIsCreated = false;
=======
	public $aRealeaseIndex;


	public function __construct() {

		$aRealeaseIndex = array();
>>>>>>> 60a7096b05016b30699adc003f995d504098a374
	}

	/**
	*	Ajoute une release apres validation. 
	*	Cree un lien symbolique pour faire la liaison avec le projet.
	*/
	public function addRelease() {
<<<<<<< HEAD

        if (false == self::$bVendorsIsCreated) {

             system("mkdir ".self::PATH_VENDORS);
             system("mkdir ".self::PATH_VENDORS."/vendor");
             system("mkdir ".self::PATH_VENDORS."/bin");
             system("sudo chmod 777 -Rf sourceRelease/");
        }

        system('cd '.self::API_ROOT_PATH.$this->aRealeaseIndex['last'].' && sudo ln -s '.self::API_ROOT_PATH . self::PATH_VENDORS."/vendor/ vendor");
        system('cd '.self::API_ROOT_PATH.$this->aRealeaseIndex['last'].' && sudo rm -rf bin');
        system('cd '.self::API_ROOT_PATH.$this->aRealeaseIndex['last'].' && sudo ln -s '.self::API_ROOT_PATH . self::PATH_VENDORS."/bin/ bin");
        

        $this->keepLimitedReleases();
 
        $sLastReleasePath = $this->getLastReleasePath();
        $this->connectCurrentReleaseToProject(self::VHOST_PATH, $sLastReleasePath);
        $this->updateSharedFolderWithappRelease($this->sLastReleaseName, self::PATH_PARAMETER_SYMLINK);

        system("cd ". self::API_ROOT_PATH.$this->aRealeaseIndex['last'] ." && curl -sS https://getcomposer.org/installer | php");
        system("cd ". self::API_ROOT_PATH.$this->aRealeaseIndex['last'] ." && php -dmemory_limit=1G composer.phar self-update");
        //system("cd ". self::API_ROOT_PATH.$this->aRealeaseIndex['last'] ." && php -dmemory_limit=1G composer.phar install");
        system("cd ". self::API_ROOT_PATH.$this->aRealeaseIndex['last'] ." && php -dmemory_limit=1G composer.phar update");

        system('sudo rm -f '.self::VHOST_PROJECT_PATH);
        system('sudo ln -s '.self::API_ROOT_PATH.$this->aRealeaseIndex['last'].' '.self::VHOST_PROJECT_PATH);
        echo "Autorisation ecriture cache file \n";
        //system("sudo chmod -R 777 ".self::VHOST_PROJECT_PATH.'/app/*');
        system('sudo php '.self::VHOST_PROJECT_PATH.'/app/console ca:cl --env=prod');
        system('sudo php '.self::VHOST_PROJECT_PATH.'/app/console doctrine:schema:update --force');
        system('sudo php '.self::VHOST_PROJECT_PATH.'/app/console assetic:dump --env=prod');
        system('sudo php '.self::VHOST_PROJECT_PATH.'/app/console assets:install --symlink');
        system("sudo setsebool -P httpd_can_network_connect 1");
        system("sudo chcon -R -t public_content_rw_t ".self::VHOST_PROJECT_PATH."/app/cache");
        system("sudo chcon -R -t public_content_rw_t ".self::VHOST_PROJECT_PATH."/app/logs");
        system("sudo chcon -R -t public_content_rw_t ".self::VHOST_PROJECT_PATH."/web/webservices");
        system("sudo chcon -R -t public_content_rw_t ".self::VHOST_PROJECT_PATH."/web/excel");
        system("sudo chcon -R -t public_content_rw_t ".self::VHOST_PROJECT_PATH."/webservices");
        system("sudo setsebool -P allow_httpd_anon_write 1");
        system("sudo chmod -R 777 ".self::VHOST_PROJECT_PATH.'/app/cache/*');
        system("sudo chmod -R 777 ".self::VHOST_PROJECT_PATH.'/app/logs/*');
        system("sudo chmod -R 777 ".self::VHOST_PROJECT_PATH.'/web/webservices/*');
        system("sudo chmod -R 777 ".self::VHOST_PROJECT_PATH.'/webservices/*');
        system("sudo chmod -R 777 ".self::VHOST_PROJECT_PATH.'/web/excel/*');
        system("sudo service httpd restart");
	}

    /**
     * Crée le lien symbolique entre la derniere release et le projet.
     *
     * @param $sVhostPath
     */
    private function connectCurrentReleaseToProject($sVhostPath, $sLastReleasePath) {
        //system("sudo ln -s /home/optimus/Documents/Total/capilolo/".trim($sLastReleasePath)." ".$sVhostPath."");
        //system("sudo ln -s ".self::API_ROOT_PATH."".trim($sLastReleasePath)." ".$sVhostPath."");

        //API_ROOT_PATH
        // recuperation du nom de la release par une regex.
        if (preg_match("/[0-9]{3,}/",$sLastReleasePath, $apMatches)) {
            var_dump("----------------------------------------------------------", $apMatches, "------------------------------END----------------------");
            $this->sLastReleaseName = $apMatches[0];
        }
        else {
            throw new \Exception("Le nom de la release ne peut etre extrait du fichier releaseName.cache");
        }
    }

    /**
     * Renvoi le path de la derniere release du fichier releases en cache.
     *
     * @return String
     */
    private function getLastReleasePath() {
        $aReleasesList = $this->getAllReleaseFromFile();
        $sLastIndexReleaseFile = $aReleasesList[count($aReleasesList)-1]; // Remplacer par la fonction end()

       return $sLastIndexReleaseFile;
    }

    /**
     * Renvoi le path de la derniere release du fichier releases en cache.
     *
     * @return String
     */
    private function getAllReleasePath() {
        
        $aReleasesList = $this->getAllReleaseFromFile();
        return $aReleasesList;
    }


    private function updateSharedFolderWithappRelease($sLastReleaseName, $sPathSymlinkParameterYml ) {
        system("sudo cp ".self::VHOST_PROJECT_PATH."/app/config/parameters.yml sourceRelease/".$sLastReleaseName."/app/config/parameters.yml");
    }

    /**
     * Methode servant a garantir le nombre de release historisées
     * Ce parametre est configurable dans la constante de classe release manager.
     */
    public function keepLimitedReleases() {
        var_dump('function keepLimitedReleases()');
        $iReleaseNumber = $this->getNumberOfRelease();
        $this->createCacheRelease($this->aRealeaseIndex['last']);
        $aReleasesList = $this->getAllReleaseFromFile();

        if (self::NOMBRE_RELEASES_HISTORISEES < $iReleaseNumber) {
            var_dump('passe_limit');
            $this->removeRelease($aReleasesList[0]);
            $this->createCacheRelease($this->aRealeaseIndex['last']);
            // Regenere le fichier release cache.
            $aReleasesListToKeep = $this->cleanCacheReleaseFile($aReleasesList);
            $aReleasesListToDelete = array_diff($aReleasesList, $aReleasesListToKeep);
            var_dump('##### value arrayTodelete => '.$aReleasesListToDelete.'\n');
            $this->removeSomeReleases($aReleasesListToDelete);

            $aReleasesListToKeepInversed = $this->reverseArrayIndex($aReleasesListToKeep);
            $sCacheFileContentToAdd = implode("", $aReleasesListToKeepInversed);
            file_put_contents(self::PATH_RELEASE_CACHE, $sCacheFileContentToAdd);
        }
    }

    /**
     * Renvoi le tableau inverse du tableau entree en param.
     * Le premier indice devient le dernier.
     *
     * @param array $aArrayToReverse
     * @return array
     */
    private function reverseArrayIndex(Array $aArrayToReverse) {
        $aArrayReversed = array();
        for ($iRev = count($aArrayToReverse), $i = 1; $i <= count($aArrayToReverse); ++$i, --$iRev) {
            $aArrayReversed[$iRev] = $aArrayToReverse[$i];
        }

        return $aArrayReversed;
    }

    /**
     * Renvoi le nombre de release présent dans le dossier release.
     * @return string
     */
    private function getNumberOfRelease() {
        //$iReleaseNumber = trim(system("ls -L ".GitManager::RELEASE_SOURCE_FOLDER."| wc -l "));
        $iReleaseNumber = count($this->getAllReleaseFromFile());
        return $iReleaseNumber;
    }

    /**
     * Gere la mise en cache des noms de releases (ajout/edition).
     * @param $sReleaseName
     */
    public function createCacheRelease($sReleaseName) {
        // Creation d'un fichier de cache release
        var_dump('lbrau maj cache file');
        $pStream = fopen(self::PATH_RELEASE_CACHE,"a");
        var_dump('ici le fwrite',self::PATH_RELEASE_CACHE);
        var_dump(fwrite($pStream, $sReleaseName."\n"));
        fclose($pStream);
    }

    /**
     * Renvoi un tableau des nouvelles release chronologiquement a mettre en cache.
     * @param array $aReleasesList
     * @return mixed
     */
    public function cleanCacheReleaseFile(Array $aReleasesList) {
        $aNewReleasesContentFile = array();
        $iNbReleases = count($aReleasesList);

        for ($iNbMaxReleases = self::NOMBRE_RELEASES_HISTORISEES; $iNbMaxReleases > 0; --$iNbReleases, --$iNbMaxReleases) {
            $aNewReleasesContentFile[$iNbMaxReleases] = $aReleasesList[$iNbReleases-1];
        }
        var_dump('##### retour cleanCacheReleaseFile() => '.$aNewReleasesContentFile.'\n');
        return $aNewReleasesContentFile;
    }

    /**
     * Retourne toutes les releases enregistrées dans le fichier cache/releaseName.cache
     * @return array
     * @throws Exception
     */
    public function getAllReleaseFromFile() {

        $aReleaseNameList = array();
        echo "recuperation des caches releases\n";
        $pFileStream = fopen(self::PATH_RELEASE_CACHE, "r");
        if ($pFileStream) {
            while (($sLine = fgets($pFileStream)) !== false) {
                $aReleaseNameList[] = $sLine;
            }
        }
         else {
            throw new Exception("Probleme lors de la lecture du fichier cache");
        }
        fclose($pFileStream);
        return $aReleaseNameList;
    }

    /**
     * Renvoi la release a delete du dossier des sources.
     * @param $sRelasePathToRemove
     */
    public function removeRelease($sRelasePathToRemove) {

        system("sudo rm -R ".$sRelasePathToRemove);
    }

    /**
     * Renvoi la release a delete du dossier des sources.
     * @param $sRelasePathToRemove
     */
    public function removeSomeReleases($aReleasesListToDelete) {
        // TODO faire une gestion d'erreurs.
        var_dump('function removeSomeReleases()');
        foreach ($aReleasesListToDelete as $iKey => $sReleasePath) {
            $this->removeRelease($sReleasePath);
        }
    }

    /**
     * Renvoi le path de la derniere release du fichier releases en cache.
     *
     * @return String
     */
    private function getBeforeLastReleasePath() {
        $aReleasesList = $this->getAllReleaseFromFile();
        $sLastIndexReleaseFile = $aReleasesList[count($aReleasesList)-2]; // Remplacer par la fonction end()

       return $sLastIndexReleaseFile;
    }

    public function createSymlinkRevert() {

        // system("sudo ln -s ".$sVendorRelativePath." ".$sReleasePathIndex."/vendor");
        // system("sudo rm -R  ".$sReleasePathIndex."/bin/\n"); // Supprime le bin existant
        // system("sudo ln -s ".$sBinRelativePathFromRelease." ".$sReleasePathIndex."/"); // ajoute le symlink vers le bin/ shared

        $sPathReversed = $this->getBeforeLastReleasePath();
        echo('@@@@@@@@@@@ln -s '.self::API_ROOT_PATH.''.$sPathReversed.' '.self::VHOST_PATH.'@@@@@@@@'."\n");
        system('sudo rm -Rf '.self::VHOST_PATH.''.self::PROJECT_NAME);
        echo('sudo rm -Rf '.self::API_ROOT_PATH.' '.$this->getLastReleasePath());

        system('ln -s '.self::API_ROOT_PATH.' '.$sPathReversed.' '.self::VHOST_PATH.''.self::PROJECT_NAME);
    }

    /*
    *   Fait un revert sur l'avant derniere release.
    */
    public function revertRelease () {

        // recuperation de toutes les releases.
        $aAllReleases = $this->getAllReleaseFromFile();

        var_dump(count($aAllReleases));
        var_dump($this->getBeforeLastReleasePath());

        if (0 != count($aAllReleases)) {
            
            var_dump("recuperation de toute les releases---------------------------------------------------------\n", $aAllReleases);
            $sRealeaseToRevert = $this->getBeforeLastReleasePath();
            var_dump($sRealeaseToRevert);
            $this->createSymlinkRevert();
        }
        else {
            throw new Exception("Le fichier de cache semble vide", 1);
        }
        // recuperation de l'avant derniere relases.
        // creation du lien symbolique.
    }
=======
		echo "methode add release\n";
	}

	public function removeRelease() {}

	public function revertRelease () {}
>>>>>>> 60a7096b05016b30699adc003f995d504098a374
}