<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Clients\SignalCli;

abstract class Base extends \MTM\SignalApi\Models\Clients\Base
{
	protected $_userObjs=array();
	protected $_dataDir=null;
	
	public function setDefaultDataDir($path)
	{
		if (is_string($path) === false) {
			throw new \Exception("Invalid input");
		}
		$dirObj	= \MTM\FS\Factories::getDirectories()->getDirectory($path);
		if ($dirObj->getExists() === false) {
			$dirObj->create();
		}
		$this->_dataDir		= $dirObj;
		return $this;
	}
	public function getDefaultDataDir()
	{
		return $this->_dataDir;
	}
	public function getUser($username)
	{
		$this->initialize();
		$hash	= hash("sha256", strtolower(trim($username)).strtolower(trim($this->getDefaultDataDir()->getPathAsString())));
		if (array_key_exists($hash, $this->_userObjs) === false) {
			$userObj				= new \MTM\SignalApi\Models\Users\SignalCli\Zstance();
			$userObj->initialize($this, $username, $this->getDefaultDataDir()->getPathAsString());
			$this->_userObjs[$hash]	= $userObj;
		}
		return $this->_userObjs[$hash];
	}
}