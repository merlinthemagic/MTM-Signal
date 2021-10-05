<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Users\SignalCli;

abstract class Lists extends Link
{
	public function getIdentities()
	{
		//make into objects
		throw new \Exception("Not ready");
// 		return $this->getClient()->listIdentities($this);
	}
	public function getDevices()
	{
		//make into objects
		throw new \Exception("Not ready");
// 		return $this->getClient()->listDevices($this);
	}
}