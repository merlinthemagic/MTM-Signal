<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Factories;

class Clients extends Base
{
	//USE: $cObj	= \MTM\SignalApi\Facts::getClients()->__METHOD__();
	
	public function getSignalCli($path=null)
	{
		$rObj	= new \MTM\SignalApi\Models\Clients\SignalCli\Zstance();
		if ($path !== null) {
			$rObj->setDefaultDataDir($path);
		}
		return $rObj;
	}
}