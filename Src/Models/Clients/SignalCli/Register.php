<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Clients\SignalCli;

abstract class Register extends Receive
{
	public function registerByCaptcha($userObj, $captcha)
	{
		if (is_string($captcha) === false) {
			throw new \Exception("Invalid captcha. Goto: https://signalcaptchas.org/registration/generate.html get link from dev tools after completed captcha");
		}
		if (strpos($captcha, "signalcaptcha://") === 0) {
			$captcha	= substr($captcha, 16);
		}
		if ($userObj->getUserType() == "phoneNbr") {
			$strCmd		= "-u ".$this->getSafeArg($userObj->getUsername())." register --captcha ".$this->getSafeArg($captcha);
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
	public function registerByVoice($userObj)
	{
		if ($userObj->getUserType() == "phoneNbr") {
			$strCmd		= "-u ".$this->getSafeArg($userObj->getUsername())." register -v";
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
	public function isPhoneRegistered($userObj, $username)
	{
		$rObjs	= $this->isPhonesRegisteredMulti($userObj, array($username));
		return reset($rObjs);
	}
	public function isPhonesRegisteredMulti($userObj, $usernames)
	{
		if (is_array($usernames) === false) {
			throw new \Exception("Invalid usernames input");
		}
		foreach ($usernames as $username) {
			if (preg_match("/^(\+[0-9]+)$/", $username) === 0) {
				throw new \Exception("Invalid username: '".$username."'. Usernames can be phone numbers in the format '+Country Number', e.g British number. '+446654323345'");
			}
		}
		if ($userObj->getUserType() == "phoneNbr") {
			
			$rObjs		= array();
			$perSet		= 10;
			$curSet		= array();
			$usernames	= array_values($usernames);
			$count		= count($usernames) - 1;
			foreach ($usernames as $id => $username) {
				$curSet[]	= $this->getSafeArg($username);
				if ($id === $count || count($curSet) === $perSet) {
					$strCmd		= "-o json -u ".$this->getSafeArg($userObj->getUsername())." getUserStatus ".implode(" ", $curSet);
					$rObj		= $this->exeCmd($userObj, $strCmd);
					if ($rObj->error != "") {
						throw new \Exception("Failed to register: ".$rObj->error);
					}
					$json	= json_decode($rObj->data);
					if (is_array($json) === true) {
						$rObjs	= array_merge($rObjs, $json);
					} else {
						throw new \Exception("Invalid return: '".$rObj->data."'");
					}
				}
			}
			return $rObjs;
			
		} else {
			throw new \Exception("Not handled for user type: ".$userObj->getUserType());
		}
	}
}