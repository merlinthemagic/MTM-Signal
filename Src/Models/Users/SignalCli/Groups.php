<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Users\SignalCli;

abstract class Groups extends Contacts
{
	protected $_groupObjs=null;
	
	public function createGroup($name=null)
	{
		$id	= $this->getClient()->createGroup($this, $name);
		foreach ($this->getGroups(true) as $grpObj) {
			if ($grpObj->getId() === $id) {
				return $grpObj;
			}
		}
		throw new \Exception("Group does not exist after creation");
	}
	public function getGroups($refresh=true)
	{
		if (is_bool($refresh) === false) {
			throw new \Exception("Invalid refresh input");
		} elseif ($this->_groupObjs === null || $refresh === true) {

			$rObjs	= $this->getClient()->listGroups($this);
			if ($this->_groupObjs === null) {
				$this->_groupObjs	= array();
			}
			$nObjs	= array();
			foreach ($rObjs as $rObj) {
				$hash		= hash("sha256", strtolower(trim($rObj->id)).strtolower(trim($this->getUsername())));
				if (array_key_exists($hash, $this->_groupObjs) === true) {
					$grpObj	= $this->_groupObjs[$hash];
				} else {
					$grpObj	= new \MTM\SignalApi\Models\Groups\SignalCli\Zstance();
				}

				$memberObjs	= array();
				foreach ($rObj->members as $member) {
					if ($member->number !== $this->getUsername()) {
						$cObj	= $this->getContactByUsername($member->number, false);
						if ($cObj === null) {
							$cObj	= $this->newContact($member->number, $member->number, false);
						}
						$memberObjs[]	= $cObj;
					}
				}

				$isAdmin	= false;
				$adminObjs	= array();
				foreach ($rObj->admins as $admin) {
					if ($admin->number !== $this->getUsername()) {
						$cObj	= $this->getContactByUsername($admin->number, false);
						if ($cObj === null) {
							$cObj	= $this->newContact($admin->number, $admin->number, false);
						}
						$adminObjs[]	= $cObj;
					} else {
						$isAdmin		= true;
					}
				}

				//name and description can be null in 0.8.3, fized in 0.9.0
				$nObjs[$hash]	= $grpObj->initialize($this, $rObj->id, $rObj->name, $rObj->description, $rObj->groupInviteLink, $rObj->isMember, $isAdmin, $rObj->isBlocked, $memberObjs, $adminObjs);

				//need to implement:
				//pendingMembers, requestingMembers, 
			}
			$this->_groupObjs	= $nObjs;
		}
		return array_values($this->_groupObjs);
	}
	public function getGroupById($id, $throw=false)
	{
		if (is_string($id) === false) {
			throw new \Exception("Invalid id input");
		} elseif (is_bool($throw) === false) {
			throw new \Exception("Invalid throw input");
		}
		$this->getGroups(false); //find group with out refreshing
		$hash	= hash("sha256", strtolower(trim($id)).strtolower(trim($this->getUsername())));
		if (array_key_exists($hash, $this->_groupObjs) === true) {
			return $this->_groupObjs[$hash];
		}
		
		//try refreshing to find the group
		$this->getGroups(true);
		if (array_key_exists($hash, $this->_groupObjs) === true) {
			return $this->_groupObjs[$hash];
		} elseif ($throw === true) {
			throw new \Exception("Group does not exist");
		} else {
			return null;
		}
	}
}