<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Contacts\SignalCli;

abstract class Initialize extends Base
{
	public function initialize($userObj, $username, $name, $blocked)
	{
		if ($userObj instanceof \MTM\SignalApi\Models\Users\SignalCli\Base === false) {
			throw new \Exception("Invalid user input");
		} elseif (is_string($username) === false) {
			throw new \Exception("Invalid username input");
		} elseif (is_string($name) === false) {
			throw new \Exception("Invalid name input");
		} elseif (is_bool($blocked) === false) {
			throw new \Exception("Invalid blocked input");
		}
		$this->_userObj		= $userObj;
		$this->_name		= $name;
		$this->_blocked		= $blocked;
		
		if (preg_match("/^(\+[0-9]+)$/", $username) == 1) {
			$this->_username	= $username;
			$this->_userType	= "phoneNbr";
			$this->_userHash	= hash("sha256", strtolower(trim($username)).strtolower(trim($this->getUser()->getUsername())));
		} else {
			throw new \Exception("Invalid username. Usernames can be phone numbers in the format '+Country Number', e.g British number. '+446654323345'");
		}
		return $this;
	}
}