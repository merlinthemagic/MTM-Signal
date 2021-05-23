<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Users\SignalCli;

abstract class Verify extends Send
{
	public function verifyBySmsCode($code)
	{
		return $this->getClient()->verifyBySmsCode($this, $code);
	}
}