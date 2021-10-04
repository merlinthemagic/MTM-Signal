<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Users\SignalCli;

abstract class Contacts extends Base
{
	protected $_contactObjs=null;
	
	protected function newContact($username, $name=null, $blocked=false)
	{
		if ($this->getContactByUsername($username, false) !== null) {
			throw new \Exception("Cannot add contact exists");
		} elseif ($username === $this->getUsername()) {
			throw new \Exception("Cannot add self as contact");
		}
		if ($name === null) {
			$name	= $username;
		}
		$hash						= hash("sha256", strtolower(trim($username)).strtolower(trim($this->getUsername())));
		$cObj						= new \MTM\SignalApi\Models\Contacts\SignalCli\Zstance();
		$this->_contactObjs[$hash]	= $cObj->initialize($this, $username, $name, $blocked);
		return $cObj;
	}
	public function getContacts($refresh=true)
	{
		if (is_bool($refresh) === false) {
			throw new \Exception("Invalid refresh input");
		} elseif ($this->_contactObjs === null || $refresh === true) {
			$rObjs	= $this->getClient()->listContacts($this);
			$nObjs	= array();
			if ($this->_contactObjs === null) {
				$this->_contactObjs	= array();
			}
			foreach ($rObjs as $rObj) {
				if ($rObj->username !== $this->getUsername()) {
					$hash		= hash("sha256", strtolower(trim($rObj->username)).strtolower(trim($this->getUsername())));
					if (array_key_exists($hash, $this->_contactObjs) === true) {
						$cObj	= $this->_contactObjs[$hash];
					} else {
						$cObj	= $this->newContact($rObj->username, $rObj->name, $rObj->blocked);
					}
					$nObjs[$hash]	= $cObj->initialize($this, $rObj->username, $rObj->name, $rObj->blocked);
				}
			}
			$this->_contactObjs	= $nObjs;
		}
		return array_values($this->_contactObjs);
	}
	public function getContactByUsername($username, $throw=false)
	{
		if (is_string($username) === false) {
			throw new \Exception("Invalid username input");
		} elseif (is_bool($throw) === false) {
			throw new \Exception("Invalid throw input");
		}
		$this->getContacts(false); //find contact with out refreshing
		$hash	= hash("sha256", strtolower(trim($username)).strtolower(trim($this->getUsername())));
		if (array_key_exists($hash, $this->_contactObjs) === true) {
			return $this->_contactObjs[$hash];
		}
			
		//try refreshing to find the contact
		$this->getContacts(true);
		if (array_key_exists($hash, $this->_contactObjs) === true) {
			return $this->_contactObjs[$hash];
		} elseif ($throw === true) {
			throw new \Exception("Contact does not exist");
		} else {
			return null;
		}
	}
}