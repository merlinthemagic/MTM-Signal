<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Users\SignalCli;

abstract class Base extends \MTM\SignalApi\Models\Users\Base
{
	protected $_rawObj=null;
	protected $_username=null;
	protected $_userType=null;
	protected $_userHash=null;
	protected $_dataDir=null;
	protected $_confFile=null;
	protected $_clientObj=null;
	
	public function getUsername()
	{
		return $this->_username;
	}
	public function getUserType()
	{
		return $this->_userType;
	}
	public function getUserHash()
	{
		return $this->_userHash;
	}
	public function getClient()
	{
		return $this->_clientObj;
	}
	public function getDataDir()
	{
		return $this->_dataDir;
	}
	public function isRegistered()
	{
		$confObj	= $this->getRawConfig();
		if (property_exists($confObj, "registered") === true) {
			return $confObj->registered;
		} else {
			return false;
		}
	}
	public function isMaster()
	{
		//is this a master device or a linked account
		$confObj	= $this->getRawConfig();
		if (
			property_exists($confObj, "deviceId") === true
			&& $confObj->deviceId === 1
		) {
			return true;
		} else {
			return false;
		}
	}
	public function getRawConfig()
	{
		$fileObj	= $this->getConfigFile();
		if ($fileObj->getExists() === true) {
			foreach ($this->_rawObj as $prop => $value) {
				unset($this->_rawObj[$prop]);
			}
			$json	= json_decode($fileObj->getContent());
			foreach ($json as $prop => $value) {
				$this->_rawObj->$prop	= $value;
			}
		}
		return $this->_rawObj;
	}
	protected function getConfigFile()
	{
		if ($this->_confFile === null) {
			$path				= $this->getDataDir()->getPathAsString()."data";
			$this->_confFile	= \MTM\FS\Factories::getFiles()->getFile($this->getUsername(), $path);
		}
		return $this->_confFile;
	}
}