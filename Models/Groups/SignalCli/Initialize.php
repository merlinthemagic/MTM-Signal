<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Groups\SignalCli;

abstract class Initialize extends Base
{
	public function initialize($userObj, $id, $name, $desc, $link, $isMember, $isAdmin, $blocked, $members, $admins)
	{
		if ($userObj instanceof \MTM\SignalApi\Models\Users\SignalCli\Base === false) {
			throw new \Exception("Invalid user input");
		} elseif (is_string($name) === false && is_null($name) === false) {
			throw new \Exception("Invalid name input");
		} elseif (is_string($desc) === false && is_null($desc) === false) {
			throw new \Exception("Invalid description input");
		} elseif (is_string($link) === false && is_null($link) === false) {
			throw new \Exception("Invalid link input");
		} elseif (is_bool($isMember) === false) {
			throw new \Exception("Invalid isMember input");
		} elseif (is_bool($isAdmin) === false) {
			throw new \Exception("Invalid isAdmin input");
		} elseif (is_bool($blocked) === false) {
			throw new \Exception("Invalid blocked input");
		} elseif (is_array($members) === false) {
			throw new \Exception("Invalid members input");
		} elseif (is_array($admins) === false) {
			throw new \Exception("Invalid admins input");
		}
		$this->_userObj		= $userObj;
		$this->_id			= $id;
		$this->_name		= $name;
		$this->_desc		= $desc;
		$this->_inviteLink	= $link;
		$this->_isMember	= $isMember;
		$this->_isAdmin		= $isAdmin;
		$this->_blocked		= $blocked;
		$this->_memberObjs	= $members;
		$this->_adminObjs	= $admins;
		$this->_grpHash		= hash("sha256", strtolower(trim($id)).strtolower(trim($this->getUser()->getUsername())));
		return $this;
	}
}