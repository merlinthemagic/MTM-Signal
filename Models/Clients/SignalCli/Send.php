<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Clients\SignalCli;

abstract class Send extends Register
{
	public function sendText($userObj, $username, $text)
	{
		if (is_string($username) === false) {
			throw new \Exception("Invalid username input");
		}
		if (is_string($text) === false) {
			if (is_int($text) === true) {
				$text	= (string) $text;
			} else {
				throw new \Exception("Invalid text input");
			}
		}
		if ($userObj->getUserType() == "phoneNbr") {
			$strCmd		= "-u ".$this->getSafeArg($userObj->getUsername())." send -m ".$this->getSafeArg($text)." ".$this->getSafeArg($username);
			$rObj		= $this->exeCmd($userObj, $strCmd);
			if ($rObj->error != "") {
				throw new \Exception("Failed to send: ".$rObj->error);
			} elseif (ctype_digit($rObj->data) === true) {
				return (int) $rObj->data;
			} else {
				throw new \Exception("Invalid return: '".$rObj->data."'");
			}
		} else {
			throw new \Exception("Not handled for user type: ".$userObj->getUserType());
		}
	}
	public function sendContactText($userObj, $contactObj, $text)
	{
		if ($contactObj instanceof \MTM\SignalApi\Models\Contacts\SignalCli\Base === false) {
			throw new \Exception("Invalid contact input");
		}
		return $this->sendText($userObj, $contactObj->getUsername(), $text);
	}
	public function sendGroupText($grpObj, $text)
	{
		if ($grpObj instanceof \MTM\SignalApi\Models\Groups\SignalCli\Base === false) {
			throw new \Exception("Invalid group input");
		}
		if (is_string($text) === false) {
			if (is_int($text) === true) {
				$text	= (string) $text;
			} else {
				throw new \Exception("Invalid text input");
			}
		}
		$userObj	= $grpObj->getUser();
		if ($userObj->getUserType() == "phoneNbr") {
			$strCmd		= "-u ".$this->getSafeArg($userObj->getUsername())." send -g ".$this->getSafeArg($grpObj->getId())." -m ".$this->getSafeArg($text);
			$rObj		= $this->exeCmd($userObj, $strCmd);
			if ($rObj->error != "") {
				throw new \Exception("Failed to send: ".$rObj->error);
			} elseif (ctype_digit($rObj->data) === true) {
				return (int) $rObj->data;
			} else {
				throw new \Exception("Invalid return: '".$rObj->data."'");
			}
		} else {
			throw new \Exception("Not handled for user type: ".$userObj->getUserType());
		}
	}
	
}