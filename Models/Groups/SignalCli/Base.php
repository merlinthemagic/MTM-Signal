<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Groups\SignalCli;

abstract class Base extends \MTM\SignalApi\Models\Groups\Base
{
	protected $_userObj=null;
	protected $_id=null;
	protected $_name=null;
	protected $_desc=null;
	protected $_isMember=null;
	protected $_isAdmin=null;
	protected $_blocked=null;
	protected $_grpHash=null;
	protected $_memberObjs=null;
	protected $_adminObjs=null;
	
	public function getUser()
	{
		return $this->_userObj;
	}
	public function getId()
	{
		return $this->_id;
	}
	public function getName()
	{
		return $this->_name;
	}
	public function setName($name)
	{
		$name	= trim($name);
		if ($this->getName() != $name) {
			$this->getUser()->getClient()->setGroupName($this, $name);
			$this->_name	= $name;
		}
		return $this;
	}
	public function getDescription()
	{
		return $this->_desc;
	}
	public function getIsMember()
	{
		return $this->_isMember;
	}
	public function getIsAdmin()
	{
		return $this->_isAdmin;
	}
	public function getBlocked()
	{
		return $this->_blocked;
	}
	public function getHash()
	{
		return $this->_grpHash;
	}
	public function setEditDetailAdminOnly($bool)
	{
		$this->getUser()->getClient()->setGroupPermissionEditDetail($this, $bool);
		return $this;
	}
	public function setAddMemberAdminOnly($bool)
	{
		$this->getUser()->getClient()->setGroupPermissionAddMember($this, $bool);
		return $this;
	}
	public function getMembers()
	{
		//member list will not return user self
		//use $this->getIsMember() to determine if user is a member
		return $this->_memberObjs;
	}
	public function addMember($contactObj)
	{
		foreach ($this->getMembers() as $memberObj) {
			if ($memberObj->getUsername() === $contactObj->getUsername()) {
				throw new \Exception("Cannot add contact is already a member of the group");
			}
		}
		$this->getUser()->getClient()->addGroupMember($this, $contactObj);
		$this->_memberObjs[]	= $contactObj;
		return $this;
	}
	public function removeMember($contactObj)
	{
		foreach ($this->_memberObjs as $index => $memberObj) {
			if ($memberObj->getUsername() === $contactObj->getUsername()) {
				$this->getUser()->getClient()->removeGroupMember($this, $contactObj);
				unset($this->_memberObjs[$index]);
				return $this;
			}
		}
		throw new \Exception("Cannot remove contact is not a member of the group");
	}
	public function getAdmins()
	{
		//admin list will not return user self
		//use $this->getIsAdmin() to determine if user is an admin
		return $this->_adminObjs;
	}
	public function addAdmin($contactObj)
	{
		foreach ($this->getAdmins() as $adminObj) {
			if ($adminObj->getUsername() === $contactObj->getUsername()) {
				throw new \Exception("Cannot add contact is already an admin of the group");
			}
		}
		$isMember	= false;
		foreach ($this->getMembers() as $memberObj) {
			if ($memberObj->getUsername() === $contactObj->getUsername()) {
				$isMember	= true;
				break;
			}
		}
		if ($isMember === false) {
			//must be a member before becoming an admin
			$this->addMember($contactObj);
		}
		$this->getUser()->getClient()->addGroupAdmin($this, $contactObj);
		$this->_adminObjs[]	= $contactObj;
		return $this;
	}
	public function removeAdmin($contactObj)
	{
		foreach ($this->_adminObjs as $index => $adminObj) {
			if ($adminObj->getUsername() === $contactObj->getUsername()) {
				$this->getUser()->getClient()->removeGroupAdmin($this, $contactObj);
				unset($this->_adminObjs[$index]);
				return $this;
			}
		}
		throw new \Exception("Cannot remove contact is not an admin of the group");
	}
}