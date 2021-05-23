<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Clients\SignalCli;

abstract class Receive extends Lists
{
	public function receiveMessages($userObj)
	{
		if ($userObj->getUserType() == "phoneNbr") {
			
			$strCmd		= "-u ".$userObj->getUsername()." -o json receive";
			$rObj		= $this->exeCmd($userObj, $strCmd);
			if ($rObj->error != "") {
				throw new \Exception("Failed to receive: ".$rObj->error);
			}
			$msgObjs	= array();
			$lines		= array_filter(explode("\n", $rObj->data));
			foreach ($lines as $line) {
				$rObj	= json_decode(trim($line));
				if ($rObj instanceof \stdClass === false) {
					throw new \Exception("Invalid message: ".$line);
				}
				$msgObjs[]	= $rObj;
			}
			return $msgObjs;
		} else {
			throw new \Exception("Not handled for user type: ".$userObj->getUserType());
		}
	}
}