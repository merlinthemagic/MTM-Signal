<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Contacts\SignalCli;

abstract class Base extends \MTM\SignalApi\Models\Contacts\Base
{
	protected $_userObj=null;
	protected $_blocked=null;
	protected $_username=null;
	protected $_name=null;
	protected $_userType=null;
	protected $_userHash=null;
	
	public function getUser()
	{
		return $this->_userObj;
	}
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
	public function setBlocked($bool)
	{
		if (is_bool($bool) === false) {
			throw new \Exception("Invalid input");
		}
		if ($this->_blocked !== $bool) {
			$this->_blocked	= $bool;
		}
		return $this;
	}
	public function isBlocked()
	{
		return $this->_blocked;
	}
}