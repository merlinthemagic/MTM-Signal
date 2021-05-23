<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Users\SignalCli;

abstract class Register extends Receive
{
	public function registerByCaptcha($captcha)
	{
		return $this->getClient()->registerByCaptcha($this, $captcha);
	}
}