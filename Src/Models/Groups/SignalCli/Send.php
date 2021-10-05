<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Groups\SignalCli;

abstract class Send extends Initialize
{
	public function sendText($text)
	{
		return $this->getUser()->getClient()->sendGroupText($this, $text);
	}
}