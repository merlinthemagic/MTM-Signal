<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Clients\SignalCli;

abstract class Link extends Initialize
{
	public function getDeviceLinkUri($deviceName=null)
	{
		//you have about 100 (messured 103) seconds to complete the linking
		$this->initialize();
		
		$tmpFile	= \MTM\FS\Factories::getFiles()->getFile("signal-cli-".uniqid().".link", MTM_FS_TEMP_PATH);
		$strCmd		= "( ( nohup";
		$strCmd		.= " ".$this->getSignalBinFile()->getPathAsString();
		$strCmd		.= " --config \"".$this->getDefaultDataDir()->getPathAsString()."\"";
		$strCmd		.= " link";
		if ($deviceName !== null) {
			if (is_string($deviceName) === false) {
				throw new \Exception("Invalid input");
			}
			$strCmd		.= " -n ".$this->getSafeArg($deviceName)."";
		}
		$strCmd		.= " > ".$tmpFile->getPathAsString();
		$strCmd		.= " 2> ".$tmpFile->getPathAsString();
		$strCmd		.= " ; sleep 2s; rm -rf ".$tmpFile->getPathAsString().";  ) & ) > /dev/null 2>&1; echo \"MtmDone\"";
		$this->ctrlWrite($strCmd);
		$this->ctrlRead($this->getTimeout());
		
		$tTime	= \MTM\Utilities\Factories::getTime()->getMicroEpoch() + 5;
		while (true) {
			$cTime	= \MTM\Utilities\Factories::getTime()->getMicroEpoch();
			$uri	= $tmpFile->getContent();
			if ($uri != "" && ord(substr($uri, -1)) === 10) {
				$uri	= trim($uri);
				break;
			} elseif ($cTime > $tTime) {
				
				throw new \Exception("Failed to get link data: '".$uri."'");
			} else {
				usleep(100000);//dont max out the cpu/io for no reason
			}
		}
		if (
			strpos($uri, "tsdevice:/?uuid=") === 0
			&& strpos($uri, "&pub_key=") !== false
		) {
			return $uri;
		} else {
			throw new \Exception("Invalid uri return: ".$uri);
		}
	}
	public function linkDeviceByUri($userObj, $uri=null)
	{
		if ($userObj->isMaster() === false) {
			throw new \Exception("Only master users can link devices");
		}
		if (
			is_string($uri) === false
			|| strpos($uri, "tsdevice:/?uuid=") !== 0
			|| strpos($uri, "&pub_key=") === false
		) {
			throw new \Exception("Invalid uri");
		}
		
		if ($userObj->getUserType() == "phoneNbr") {
			$strCmd		= "-u ".$userObj->getUsername()." addDevice --uri \"".$uri."\"";
			$rObj		= $this->exeCmd($userObj, $strCmd);
			if ($rObj->error != "") {
				throw new \Exception("Failed to link: ".$rObj->error);
			} else {
				return true;
			}
		} else {
			throw new \Exception("Not handled for user type: ".$userObj->getUserType());
		}
	}
}