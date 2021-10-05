<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi;

class Facts
{
	//USE: $aFact		= \MTM\SignalApi\Facts::__METHOD_();
	
	protected static $_s=array();
	
	public static function getClients()
	{
		if (array_key_exists(__FUNCTION__, self::$_s) === false) {
			self::$_s[__FUNCTION__]	=	new \MTM\SignalApi\Factories\Clients();
		}
		return self::$_s[__FUNCTION__];
	}
}