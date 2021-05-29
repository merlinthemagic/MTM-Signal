<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Users\SignalCli;

abstract class Initialize extends Groups
{
	public function initialize($clientObj, $username, $dataPath)
	{
		if ($clientObj instanceof \MTM\SignalApi\Models\Clients\SignalCli\Base === false) {
			throw new \Exception("Invalid client input");
		} elseif (is_string($username) === false) {
			throw new \Exception("Invalid username input");
		} elseif (is_string($dataPath) === false) {
			throw new \Exception("Invalid path input");
		}
		$this->_clientObj	= $clientObj;
		$this->_rawObj		= new \stdClass();
		$this->_confFile	= null;
		
		if (preg_match("/^(\+[0-9]+)$/", $username) == 1) {
			$this->_username	= $username;
			$this->_userType	= "phoneNbr";
			$this->_userHash	= hash("sha256", strtolower(trim($username)).strtolower(trim($clientObj->getDefaultDataDir()->getPathAsString())));
		} else {
			throw new \Exception("Invalid username. Usernames can be phone numbers in the format '+Country Number', e.g British number. '+446654323345'");
		}
		$dirObj	= \MTM\FS\Factories::getDirectories()->getDirectory($dataPath);
		if ($dirObj->getExists() === false) {
			$dirObj->create();
		}
		$this->_dataDir		= $dirObj;
		return $this;
	}
}