<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Users\SignalCli;

abstract class Verify extends Send
{
	public function verifyBySmsCode($code)
	{
		return $this->getClient()->verifyByCode($this, $code);
	}
	public function verifyByVoiceCode($code)
	{
		//no diff here in case the verification changes
		return $this->getClient()->verifyByCode($this, $code);
	}
}