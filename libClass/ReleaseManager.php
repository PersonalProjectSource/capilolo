<?php

class ReleaseManager {

    const PATH_VENDORS = "sourceRelease/shared";
    const VENDOR_RELATIVE_PATH_FROM_RELEASE = "../shared/vendor/";
    const BIN_RELATIVE_PATH_FROM_RELEASE = "../shared/bin/";
    const NOMBRE_RELEASES_HISTORISEES = 5;
    const PATH_RELEASE_CACHE = "cache/releaseName.cache";
    const VHOST_PATH = "/etc/apache2/"; // TODO a parametrer
    const PROJECT_NAME = "ProjectName"; // TODO a parametrer

    const PATH_PARAMETER_SYMLINK = "/Users/laurentbrau/Documents/Audit_ADEL/ScriptsAdel/sourceRelease/shared";

    public $aRealeaseIndex;
    private $sLastReleaseName;
    protected static $bVendorsIsCreated;

	public function __construct() {
		$this->aRealeaseIndex = array();
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

        $this->createSymlink(self::PATH_VENDORS."/vendor", $this->aRealeaseIndex['last']);
        $this->keepLimitedReleases();

        $sLastReleasePath = $this->getLastReleasePath();
        $this->connectCurrentReleaseToProject(self::VHOST_PATH, $sLastReleasePath);
        $this->updateSharedFolderWithappRelease($this->sLastReleaseName, self::PATH_PARAMETER_SYMLINK);

        // TODO lbrau check avec toinant pour desmonstration de decoupage.
        system("curl -sS https://getcomposer.org/installer | php");
        system("sudo mv composer.phar ".self::PATH_VENDORS);
        system("sudo cp ".$this->aRealeaseIndex['last']."/composer.json ".self::PATH_VENDORS."/");
        system("cd ".self::PATH_VENDORS."/ && php composer.phar install");
	}

    /**
     * Crée le lien symbolique entre la derniere release et le projet.
     *
     * @param $sVhostPath
     */
    private function connectCurrentReleaseToProject($sVhostPath, $sLastReleasePath) {
        system("sudo ln -s ScriptsAdel/".trim($sLastReleasePath)." ".$sVhostPath."");
        // recuperation du nom de la release par une regex.
        if (preg_match("/[0-9]{3,}/",$sLastReleasePath, $apMatches)) {
            $this->sLastReleaseName = $apMatches[0];
            system("sudo mv ".$sVhostPath."".$apMatches[0]." ".$sVhostPath."".self::PROJECT_NAME);
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
        $sLastIndexReleaseFile = $aReleasesList[count($aReleasesList)-1];

       return $sLastIndexReleaseFile;
    }

    /**
     * Gere la creation de liens symboliques pour les sources a partager avec la release courante.
     */
    private function createSymlink() {
        system("ln -s ".self::VENDOR_RELATIVE_PATH_FROM_RELEASE." ".$this->aRealeaseIndex['last']."/vendor");
        system("sudo rm -R  ".$this->aRealeaseIndex['last']."/bin/\n"); // Supprime le bin existant
        system("ln -s ".self::BIN_RELATIVE_PATH_FROM_RELEASE." ".$this->aRealeaseIndex['last']."/"); // ajoute le symlink vers le bin/ shared
    }

    private function updateSharedFolderWithappRelease($sLastReleaseName, $sPathSymlinkParameterYml ) {
        system("cp sourceRelease/".$sLastReleaseName."/app/config/parameters.yml.dist sourceRelease/".$sLastReleaseName."/app/config/parameters.yml");
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
;        $pStream = fopen(self::PATH_RELEASE_CACHE,"a");
        fwrite($pStream, $sReleaseName."\n");
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

        return $aNewReleasesContentFile;
    }

    /**
     * Retourne toutes les releases enregistrées dans le fichier cache/releaseName.cache
     * @return array
     * @throws Exception
     */
    public function getAllReleaseFromFile() {

        $aReleaseNameList = array();
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
        foreach ($aReleasesListToDelete as $iKey => $sReleasePath) {
            $this->removeRelease($sReleasePath);
        }
    }

    public function revertRelease () {}
}