<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Users\SignalCli;

abstract class Register extends Receive
{
	public function registerByCaptcha($captcha)
	{
		return $this->getClient()->registerByCaptcha($this, $captcha);
	}
	public function registerByVoice($captcha)
	{
		return $this->getClient()->registerByVoice($this);
	}
	public function isPhoneRegistered($phoneNbr)
	{
		$rObj	= $this->getClient()->isPhoneRegistered($this, $phoneNbr);
		return $rObj->isRegistered;
	}
}