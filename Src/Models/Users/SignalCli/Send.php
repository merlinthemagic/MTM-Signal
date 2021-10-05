<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Users\SignalCli;

abstract class Send extends Register
{
	public function sendText($username, $text)
	{
		return $this->getClient()->sendText($this, $username, $text);
	}
}