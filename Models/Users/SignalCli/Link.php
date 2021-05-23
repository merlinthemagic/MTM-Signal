<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Users\SignalCli;

abstract class Link extends Initialize
{
	public function linkDeviceByUri($uri=null)
	{
		return $this->getClient()->linkDeviceByUri($this, $uri);
	}
}