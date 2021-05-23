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
			$strCmd		= "-u ".$userObj->getUsername()." send -m '".$text."' ".$username;
			$rObj		= $this->exeCmd($userObj, $strCmd);
			if ($rObj->error != "") {
				throw new \Exception("Failed to send: ".$rObj->error);
			} elseif (ctype_digit($rObj->data) === true) {
				return (int) $rObj->data;
			} else {
				throw new \Exception("Received invalid return data: ".$rObj->data);
			}
		} else {
			throw new \Exception("Not handled for user type: ".$userObj->getUserType());
		}
	}
}