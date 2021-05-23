<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Clients\SignalCli;

abstract class Register extends Receive
{
	public function registerByCaptcha($userObj, $captcha)
	{
		if (is_string($captcha) === false) {
			throw new \Exception("Invalid captcha. Goto: https://signalcaptchas.org/registration/generate.html get link from dev tools after completed captcha");
		} elseif (strpos($captcha, "signalcaptcha://") === 0) {
			$captcha	= substr($captcha, 16);
		}
		
		if ($userObj->getUserType() == "phoneNbr") {
			$strCmd		= "-u ".$userObj->getUsername()." register --captcha ".$captcha;
			$rObj		= $this->exeCmd($userObj, $strCmd);
			if ($rObj->error != "") {
				throw new \Exception("Failed to register: ".$rObj->error);
			} else {
				return true;
			}
		} else {
			throw new \Exception("Not handled for user type: ".$userObj->getUserType());
		}
	}
}