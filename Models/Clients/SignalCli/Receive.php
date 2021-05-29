<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Clients\SignalCli;

abstract class Receive extends Lists
{
	public function receiveMessages($userObj, $timeout=null)
	{
		if ($userObj->getUserType() == "phoneNbr") {
			
			$strCmd		= "-u ".$this->getSafeArg($userObj->getUsername())." -o json receive";
			$rObj		= $this->exeCmd($userObj, $strCmd, $timeout);
			if ($rObj->error != "") {
				throw new \Exception("Failed to receive: ".$rObj->error);
			}
			$msgObjs	= array();
			$lines		= array_filter(explode("\n", $rObj->data));
			foreach ($lines as $line) {
				file_put_contents("/dev/shm/merlin.txt", print_r($line, true)."\n", FILE_APPEND);
				
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