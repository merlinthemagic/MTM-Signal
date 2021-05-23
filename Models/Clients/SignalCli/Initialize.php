<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Clients\SignalCli;

abstract class Initialize extends Exec
{
	protected $_isInit=false;
	protected $_signalBin=null;
	
	protected function getSignalBinFile()
	{
		return $this->_signalBin;
	}
	public function initialize()
	{
		if ($this->_isInit === false) {
			
			if ($this->getDefaultDataDir() === null) {
				throw new \Exception("Default data directory is not set");
			}
			$osTool		= \MTM\Utilities\Factories::getSoftware()->getOsTool();
			if ($osTool->getType() == "linux") {
				$fileObj	= \MTM\FS\Factories::getFiles()->getFile("signal-cli", MTM_SIGNAL_API_BASE_PATH . implode(DIRECTORY_SEPARATOR, array("Vendors", "SignalCli", "bin")));
				if ($fileObj->getExists() === false) {
					throw new \Exception("Signal-cli binary file does not exist");
				} elseif ($fileObj->getMode() === "0644") {
					throw new \Exception("Signal-cli binary is not executable");
				}
				$this->_signalBin	= $fileObj;
				
				$strCmd		= "echo \$JAVA_HOME";
				$rObj		= $this->getCtrl()->write($strCmd)->read();
				$javaHome	= trim($rObj->data);
				if ($javaHome == "") {
					$javaPath			= $osTool->getExecutablePath("java");
					if ($javaPath === false) {
						throw new \Exception("Install java-11-openjdk or equivilent");
					}
					
					$strCmd		= $javaPath." -XshowSettings:properties -version 2>&1 > /dev/null | grep 'java.home'";
					$rObj		= $this->getCtrl()->write($strCmd)->read();
					if (($pos = strpos($rObj->data, "=")) === false) {
						throw new \Exception("Failed to determine java home directory");
					}
					$dirObj		= \MTM\FS\Factories::getDirectories()->getDirectory(trim(substr($rObj->data, ($pos +1))));
					if ($dirObj->getExists() === false) {
						throw new \Exception("Failed to locate Java home directory");
					}
					
					$strCmd		= "export JAVA_HOME=".$dirObj->getPathAsString()."; ";
					$this->getCtrl()->write($strCmd);
					
					$strCmd		= "echo \$JAVA_HOME";
					$rObj		= $this->getCtrl()->write($strCmd)->read();
					if (trim($rObj->data) != $dirObj->getPathAsString()) {
						throw new \Exception("Java home directory env was not set correctly");
					}
				}

			} else {
				throw new \Exception("Not handled for OS type: ".$osTool->getType());
			}
			
			$this->_isInit	= true;
		}
		return $this;
	}
}