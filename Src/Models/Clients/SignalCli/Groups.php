<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Clients\SignalCli;

abstract class Groups extends Exec
{
	public function createGroup($userObj, $name=null)
	{
		if ($userObj instanceof \MTM\SignalApi\Models\Users\SignalCli\Base === false) {
			throw new \Exception("Invalid group input");
		} elseif (is_string($name) === false && is_null($name) === false) {
			throw new \Exception("Invalid name input");
		}
		if ($userObj->getUserType() == "phoneNbr") {
			$strCmd		= "-u ".$this->getSafeArg($userObj->getUsername())." updateGroup";
			if ($name !== null) {
				$strCmd		.= " -n ".$this->getSafeArg($name);
			}
			$rObj		= $this->exeCmd($userObj, $strCmd);
			if ($rObj->error != "") {
				throw new \Exception("Failed to send: ".$rObj->error);
			} elseif (preg_match("/^Created new group: \"(.+?)\"$/i", trim($rObj->data), $raw) === 1) {
				return $raw[1];
			} else {
				throw new \Exception("Received invalid return data: '".$rObj->data."'");
			}
		} else {
			throw new \Exception("Not handled for user type: ".$userObj->getUserType());
		}
	}
	public function addGroupMember($grpObj, $contactObj)
	{
		if ($grpObj instanceof \MTM\SignalApi\Models\Groups\SignalCli\Base === false) {
			throw new \Exception("Invalid group input");
		} elseif ($contactObj instanceof \MTM\SignalApi\Models\Contacts\SignalCli\Base === false) {
			throw new \Exception("Invalid contact input");
		}
		$userObj	= $grpObj->getUser();
		if ($userObj->getUserType() == "phoneNbr") {
			if ($contactObj->getUserType() == "phoneNbr") {

				$strCmd		= "-u ".$this->getSafeArg($userObj->getUsername())." updateGroup";
				$strCmd		.= " -g ".$this->getSafeArg($grpObj->getId())." -m [".$this->getSafeArg($contactObj->getUsername())."]";
				$rObj		= $this->exeCmd($userObj, $strCmd);
				if ($rObj->error != "") {
					throw new \Exception("Failed to add group member: ".$rObj->error);
				} elseif (ctype_digit($rObj->data) === true) {
					return (int) $rObj->data;
				} else {
					throw new \Exception("Invalid return: '".$rObj->data."'");
				}
			} else {
				throw new \Exception("Not handled for contact type: ".$contactObj->getUserType());
			}
		} else {
			throw new \Exception("Not handled for user type: ".$userObj->getUserType());
		}
	}
	public function removeGroupMember($grpObj, $contactObj)
	{
		if ($grpObj instanceof \MTM\SignalApi\Models\Groups\SignalCli\Base === false) {
			throw new \Exception("Invalid group input");
		} elseif ($contactObj instanceof \MTM\SignalApi\Models\Contacts\SignalCli\Base === false) {
			throw new \Exception("Invalid contact input");
		}
		$userObj	= $grpObj->getUser();
		if ($userObj->getUserType() == "phoneNbr") {
			if ($contactObj->getUserType() == "phoneNbr") {
				
				$strCmd		= "-u ".$this->getSafeArg($userObj->getUsername())." updateGroup";
				$strCmd		.= " -g ".$this->getSafeArg($grpObj->getId())." -r [".$this->getSafeArg($contactObj->getUsername())."]";
				$rObj		= $this->exeCmd($userObj, $strCmd);
				if ($rObj->error != "") {
					throw new \Exception("Failed to remove group member: ".$rObj->error);
				} elseif (ctype_digit($rObj->data) === true) {
					return (int) $rObj->data;
				} else {
					throw new \Exception("Invalid return: '".$rObj->data."'");
				}
			} else {
				throw new \Exception("Not handled for contact type: ".$contactObj->getUserType());
			}
		} else {
			throw new \Exception("Not handled for user type: ".$userObj->getUserType());
		}
	}
	public function addGroupAdmin($grpObj, $contactObj)
	{
		if ($grpObj instanceof \MTM\SignalApi\Models\Groups\SignalCli\Base === false) {
			throw new \Exception("Invalid group input");
		} elseif ($contactObj instanceof \MTM\SignalApi\Models\Contacts\SignalCli\Base === false) {
			throw new \Exception("Invalid contact input");
		}
		$userObj	= $grpObj->getUser();
		if ($userObj->getUserType() == "phoneNbr") {
			if ($contactObj->getUserType() == "phoneNbr") {
				
				$strCmd		= "-u ".$this->getSafeArg($userObj->getUsername())." updateGroup";
				$strCmd		.= " -g ".$this->getSafeArg($grpObj->getId())." --admin [".$this->getSafeArg($contactObj->getUsername())."]";
				$rObj		= $this->exeCmd($userObj, $strCmd);
				if ($rObj->error != "") {
					throw new \Exception("Failed to add group admin: ".$rObj->error);
				} elseif (ctype_digit($rObj->data) === true) {
					return (int) $rObj->data;
				} else {
					throw new \Exception("Invalid return: '".$rObj->data."'");
				}
			} else {
				throw new \Exception("Not handled for contact type: ".$contactObj->getUserType());
			}
		} else {
			throw new \Exception("Not handled for user type: ".$userObj->getUserType());
		}
	}
	public function removeGroupAdmin($grpObj, $contactObj)
	{
		if ($grpObj instanceof \MTM\SignalApi\Models\Groups\SignalCli\Base === false) {
			throw new \Exception("Invalid group input");
		} elseif ($contactObj instanceof \MTM\SignalApi\Models\Contacts\SignalCli\Base === false) {
			throw new \Exception("Invalid contact input");
		}
		$userObj	= $grpObj->getUser();
		if ($userObj->getUserType() == "phoneNbr") {
			if ($contactObj->getUserType() == "phoneNbr") {
				
				$strCmd		= "-u ".$this->getSafeArg($userObj->getUsername())." updateGroup";
				$strCmd		.= " -g ".$this->getSafeArg($grpObj->getId())." --remove-admin [".$this->getSafeArg($contactObj->getUsername())."]";
				$rObj		= $this->exeCmd($userObj, $strCmd);
				if ($rObj->error != "") {
					throw new \Exception("Failed to remove group admin: ".$rObj->error);
				} elseif (ctype_digit($rObj->data) === true) {
					return (int) $rObj->data;
				} else {
					throw new \Exception("Invalid return: '".$rObj->data."'");
				}
			} else {
				throw new \Exception("Not handled for contact type: ".$contactObj->getUserType());
			}
		} else {
			throw new \Exception("Not handled for user type: ".$userObj->getUserType());
		}
	}
	public function setGroupName($grpObj, $name=null)
	{
		if ($grpObj instanceof \MTM\SignalApi\Models\Groups\SignalCli\Base === false) {
			throw new \Exception("Invalid group input");
		} elseif (is_string($name) === false && is_null($name) === false) {
			throw new \Exception("Invalid name input");
		}
		$userObj	= $grpObj->getUser();
		if ($userObj->getUserType() == "phoneNbr") {
			$strCmd		= "-u ".$this->getSafeArg($userObj->getUsername())." updateGroup";
			$strCmd		.= " -g ".$this->getSafeArg($grpObj->getId())." -n ".$this->getSafeArg($name);
			$rObj		= $this->exeCmd($userObj, $strCmd);
			if ($rObj->error != "") {
				throw new \Exception("Failed to set group name: ".$rObj->error);
			} elseif (ctype_digit($rObj->data) === true) {
				return (int) $rObj->data;
			} else {
				throw new \Exception("Invalid return: '".$rObj->data."'");
			}
		} else {
			throw new \Exception("Not handled for user type: ".$userObj->getUserType());
		}
	}
	public function setGroupDescription($grpObj, $desc=null)
	{
		if ($grpObj instanceof \MTM\SignalApi\Models\Groups\SignalCli\Base === false) {
			throw new \Exception("Invalid group input");
		} elseif (is_string($desc) === false && is_null($desc) === false) {
			throw new \Exception("Invalid desc input");
		}
		$userObj	= $grpObj->getUser();
		if ($userObj->getUserType() == "phoneNbr") {
			$strCmd		= "-u ".$this->getSafeArg($userObj->getUsername())." updateGroup";
			$strCmd		.= " -g ".$this->getSafeArg($grpObj->getId())." -d ".$this->getSafeArg($desc);
			$rObj		= $this->exeCmd($userObj, $strCmd);
			if ($rObj->error != "") {
				throw new \Exception("Failed to set group description: ".$rObj->error);
			} elseif (ctype_digit($rObj->data) === true) {
				return (int) $rObj->data;
			} else {
				throw new \Exception("Invalid return: '".$rObj->data."'");
			}
		} else {
			throw new \Exception("Not handled for user type: ".$userObj->getUserType());
		}
	}
	public function setGroupPermissionAddMember($grpObj, $adminOnly)
	{
		if ($grpObj instanceof \MTM\SignalApi\Models\Groups\SignalCli\Base === false) {
			throw new \Exception("Invalid group input");
		} elseif (is_bool($adminOnly) === false) {
			throw new \Exception("Invalid adminOnly input");
		}
		$userObj	= $grpObj->getUser();
		if ($userObj->getUserType() == "phoneNbr") {
			if ($adminOnly === true) {
				$perm	= "only-admins";
			} else {
				$perm	= "every-member";
			}
			
			$strCmd		= "-u ".$this->getSafeArg($userObj->getUsername())." updateGroup";
			$strCmd		.= " -g ".$this->getSafeArg($grpObj->getId())." --set-permission-add-member ".$this->getSafeArg($perm);
			$rObj		= $this->exeCmd($userObj, $strCmd);
			if ($rObj->error != "") {
				throw new \Exception("Failed to set add member permission: ".$rObj->error);
			} elseif (ctype_digit($rObj->data) === true) {
				return (int) $rObj->data;
			} else {
				throw new \Exception("Invalid return: '".$rObj->data."'");
			}
		} else {
			throw new \Exception("Not handled for user type: ".$userObj->getUserType());
		}
	}
	public function setGroupPermissionEditDetail($grpObj, $adminOnly)
	{
		if ($grpObj instanceof \MTM\SignalApi\Models\Groups\SignalCli\Base === false) {
			throw new \Exception("Invalid group input");
		} elseif (is_bool($adminOnly) === false) {
			throw new \Exception("Invalid adminOnly input");
		}
		$userObj	= $grpObj->getUser();
		if ($userObj->getUserType() == "phoneNbr") {
			if ($adminOnly === true) {
				$perm	= "only-admins";
			} else {
				$perm	= "every-member";
			}
			
			$strCmd		= "-u ".$this->getSafeArg($userObj->getUsername())." updateGroup";
			$strCmd		.= " -g ".$this->getSafeArg($grpObj->getId())." --set-permission-edit-details ".$this->getSafeArg($perm);
			$rObj		= $this->exeCmd($userObj, $strCmd);
			if ($rObj->error != "") {
				throw new \Exception("Failed to set edit detail permission: ".$rObj->error);
			} elseif (ctype_digit($rObj->data) === true) {
				return (int) $rObj->data;
			} else {
				throw new \Exception("Invalid return: '".$rObj->data."'");
			}
		} else {
			throw new \Exception("Not handled for user type: ".$userObj->getUserType());
		}
	}
	public function setGroupLinkState($grpObj, $enabled, $withApproval)
	{
		if ($grpObj instanceof \MTM\SignalApi\Models\Groups\SignalCli\Base === false) {
			throw new \Exception("Invalid group input");
		} elseif (is_bool($enabled) === false) {
			throw new \Exception("Invalid enabled input");
		} elseif (is_bool($withApproval) === false) {
			throw new \Exception("Invalid with approval input");
		}
		$userObj	= $grpObj->getUser();
		if ($userObj->getUserType() == "phoneNbr") {
			if ($enabled === true) {
				if ($withApproval === true) {
					$perm	= "enabled-with-approval";
				} else {
					$perm	= "enabled";
				}
				
			} else {
				$perm	= "disabled";
			}
			$strCmd		= "-u ".$this->getSafeArg($userObj->getUsername())." updateGroup";
			$strCmd		.= " -g ".$this->getSafeArg($grpObj->getId())." --link ".$this->getSafeArg($perm);
			$rObj		= $this->exeCmd($userObj, $strCmd);
			if ($rObj->error != "") {
				throw new \Exception("Failed to set group link state: ".$rObj->error);
			} elseif (ctype_digit($rObj->data) === true) {
				return (int) $rObj->data;
			} else {
				throw new \Exception("Invalid return: '".$rObj->data."'");
			}
		} else {
			throw new \Exception("Not handled for user type: ".$userObj->getUserType());
		}
	}
}