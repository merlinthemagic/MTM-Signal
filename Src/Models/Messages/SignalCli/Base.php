<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Messages\SignalCli;

abstract class Base extends \MTM\SignalApi\Models\Messages\Base
{
	protected $_userObj=null;
	protected $_timestamp=null;
	protected $_msgType=null;
	
	public function getUser()
	{
		return $this->_userObj;
	}
	public function getTimestamp()
	{
		return $this->_timestamp;
	}
	public function getType()
	{
		return $this->_msgType;
	}
	public function initialize($userObj, $timestamp, $type)
	{
		if ($userObj instanceof \MTM\SignalApi\Models\Users\SignalCli\Base === false) {
			throw new \Exception("Invalid user input");
		} elseif (is_int($timestamp) === false) {
			throw new \Exception("Invalid timestamp input");
		}
		
		$this->_userObj		= $userObj;
		$this->_timestamp	= $timestamp;
		$this->_msgType		= $type;
		return $this;
	}
}