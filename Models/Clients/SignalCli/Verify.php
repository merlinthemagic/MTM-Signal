<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Clients\SignalCli;

abstract class Verify extends Send
{
	public function verifyBySmsCode($userObj, $code)
	{
		if (is_int($code) === true) {
			//deal with ints, we must keep leading zeros
			if ($code < 100000) {
				$code	= str_repeat ("0", (6 - strlen((string) $code))).$code;
			} else {
				$code	= (string) $code;
			}
		}
		if (is_string($code) === false || ctype_digit($code) === false || strlen($code) !== 6) {
			throw new \Exception("Invalid SMS code. Must be a string consisting of 6 digits");
		}
		if ($userObj->getUserType() == "phoneNbr") {
			$strCmd		= "-u ".$this->getSafeArg($userObj->getUsername())." verify ".$this->getSafeArg($code);
			$rObj		= $this->exeCmd($userObj, $strCmd);
			if ($rObj->error != "") {
				throw new \Exception("Failed to verify: ".$rObj->error);
			} else {
				return true;
			}
		} else {
			throw new \Exception("Not handled for user type: ".$userObj->getUserType());
		}
	}
}