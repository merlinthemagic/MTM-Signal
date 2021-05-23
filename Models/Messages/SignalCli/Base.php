<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Messages\SignalCli;

abstract class Base extends \MTM\SignalApi\Models\Messages\Base
{
	protected $_userObj=null;
	protected $_timestamp=null;
	
	public function getUser()
	{
		return $this->_userObj;
	}
	public function getTimestamp()
	{
		return $this->_timestamp;
	}
	public function initialize($userObj, $timestamp)
	{
		if ($userObj instanceof \MTM\SignalApi\Models\Users\SignalCli\Base === false) {
			throw new \Exception("Invalid user input");
		} elseif (is_int($timestamp) === false) {
			throw new \Exception("Invalid timestamp input");
		}
		
		$this->_userObj		= $userObj;
		$this->_timestamp	= $timestamp;
		
		return $this;
	}
}