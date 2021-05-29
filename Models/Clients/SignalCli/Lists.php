<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Clients\SignalCli;

abstract class Lists extends Link
{
	public function listIdentities($userObj)
	{
		if ($userObj->getUserType() == "phoneNbr") {
			$strCmd			= "-u ".$this->getSafeArg($userObj->getUsername())." listIdentities";
			$rObj			= $this->exeCmd($userObj, $strCmd);

			if ($rObj->error != "") {
				throw new \Exception("Failed to list identities: ".$rObj->error);
			}
			$idObjs		= array();
			$lines		= array_filter(explode("\n", $rObj->data));
			foreach ($lines as $line) {
				
				$idObj					= new \stdClass();
				$idObj->username		= "";
				$idObj->status			= "";
				$idObj->added			= "";
				$idObj->safetyNumbers	= array();
				$idObj->fingerprint		= "";

				$find	= " Safety Number: ";
				if (($pos = strpos($line, $find)) !== false) {
					$idObj->safetyNumbers	= array_map("trim", explode(" ", trim(substr($line, ($pos + strlen($find))))));
					$line	= substr($line, 0, $pos);
				} else {
					throw new \Exception("Identity missing safety number");
				}
				$find	= " Fingerprint: ";
				if (($pos = strpos($line, $find)) !== false) {
					$idObj->fingerprint	= str_replace(" ", "", substr($line, ($pos + strlen($find))));
					$line	= substr($line, 0, $pos);
				} else {
					throw new \Exception("Identity missing fingerprint");
				}
				$find	= " Added: ";
				if (($pos = strpos($line, $find)) !== false) {
					$idObj->added	= trim(substr($line, ($pos + strlen($find))));
					$line	= substr($line, 0, $pos);
				} else {
					throw new \Exception("Identity missing added date/time");
				}
				$find	= ": ";
				if (($pos = strpos($line, $find)) !== false) {
					$idObj->status		= trim(substr($line, ($pos + strlen($find))));
					$idObj->username	= trim(substr($line, 0, $pos));
				} else {
					throw new \Exception("Identity missing status/username");
				}
				$idObjs[]	= $idObj;
			}
			return $idObjs;
		} else {
			throw new \Exception("Not handled for user type: ".$userObj->getUserType());
		}
	}
	public function listDevices($userObj)
	{
		if ($userObj->getUserType() == "phoneNbr") {
			$strCmd			= "-u ".$this->getSafeArg($userObj->getUsername())." listDevices";
			$rObj			= $this->exeCmd($userObj, $strCmd);
			if ($rObj->error != "") {
				throw new \Exception("Failed to list devices: ".$rObj->error);
			}
			$devObjs	= array();
			$devObj		= null;
			$lines		= array_filter(explode("\n", $rObj->data));
			foreach ($lines as $line) {
				$line	= trim($line);
				if ($devObj === null) {
					$devObj				= new \stdClass();
					$devObj->number		= 0;
					$devObj->name		= null;
					$devObj->created	= 0;
					$devObj->lastSeen	= 0;
				}
				
				if (preg_match("/^\-\sDevice\s([0-9]+)/", $line, $raw) === 1) {
					$devObj->number		= intval($raw[1]);
				} elseif (preg_match("/^Name:\s(.*)$/", $line, $raw) === 1) {
					$devObj->name		= trim($raw[1]);
					if ($devObj->name == "null") {
						$devObj->name	= null;//own device most likely
					}
				} elseif (preg_match("/^Created:\s([0-9]+)\s/", $line, $raw) === 1) {
					$devObj->created	= intval($raw[1]);
				} elseif (preg_match("/^Last seen:\s([0-9]+)\s/", $line, $raw) === 1) {
					$devObj->lastSeen	= intval($raw[1]);
					$devObjs[]			= $devObj;
					$devObj				= null;
				}
			}
			return $devObjs;
			
		} else {
			throw new \Exception("Not handled for user type: ".$userObj->getUserType());
		}
	}
	public function listContacts($userObj)
	{
		if ($userObj->getUserType() == "phoneNbr") {
			$strCmd			= "-u ".$this->getSafeArg($userObj->getUsername())." listContacts";
			$rObj			= $this->exeCmd($userObj, $strCmd);
			if ($rObj->error != "") {
				throw new \Exception("Failed to list contacts: ".$rObj->error);
			}
			$cObjs		= array();
			$lines		= array_filter(explode("\n", $rObj->data));
			foreach ($lines as $line) {
				
				$cObj					= new \stdClass();
				$cObj->username			= "";
				$cObj->name				= "";
				$cObj->blocked			= false;
				
				$find	= " Blocked: ";
				if (($pos = strpos($line, $find)) !== false) {
					if (trim(substr($line, ($pos + strlen($find)))) == "true") {
						$cObj->blocked	= true;
					} else {
						$cObj->blocked	= false;
					}
					$line	= substr($line, 0, $pos);
				} else {
					throw new \Exception("Contact missing blocked status");
				}
				
				$find	= " Name: ";
				if (($pos = strpos($line, $find)) !== false) {
					$cObj->name	= trim(substr($line, ($pos + strlen($find))));
					$line		= substr($line, 0, $pos);
				} else {
					throw new \Exception("Contact missing name");
				}
				$find	= "Number: ";
				if (($pos = strpos($line, $find)) !== false) {
					$cObj->username	= trim(substr($line, ($pos + strlen($find))));
					$line			= substr($line, 0, $pos);
				} else {
					throw new \Exception("Contact missing name");
				}
				$cObjs[]	= $cObj;
			}
			return $cObjs;
			
		} else {
			throw new \Exception("Not handled for user type: ".$userObj->getUserType());
		}
	}
	public function listGroups($userObj)
	{
		if ($userObj->getUserType() == "phoneNbr") {
			$strCmd			= "-o json -u ".$this->getSafeArg($userObj->getUsername())." listGroups";
			$rObj			= $this->exeCmd($userObj, $strCmd);
			if ($rObj->error != "") {
				throw new \Exception("Failed to list groups: ".$rObj->error);
			}
			$json			= json_decode($rObj->data);
			if (is_array($json) === true) {
				return $json;
			} else {
				throw new \Exception("Invalid return: '".$rObj->data."'");
			}
			
		} else {
			throw new \Exception("Not handled for user type: ".$userObj->getUserType());
		}
	}
}