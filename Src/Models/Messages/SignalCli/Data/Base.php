<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Messages\SignalCli\Data;

abstract class Base extends \MTM\SignalApi\Models\Messages\SignalCli\Base
{
	protected $_srcAddress=null;
	protected $_srcDevice=null;
	protected $_msgText=null;
	protected $_attachObjs=array();
	protected $_grpObj=null;
	protected $_grpType=null;//type of message in the group
	
	public function getSourceUsername()
	{
		return $this->_srcAddress;
	}
	public function setSourceUsername($value)
	{
		$this->_srcAddress		= $value;
		return $this;
	}
	public function getSourceDevice()
	{
		return $this->_srcDevice;
	}
	public function setSourceDevice($value)
	{
		$this->_srcDevice		= $value;
		return $this;
	}
	public function getMessage()
	{
		return $this->_msgText;
	}
	public function setMessage($value)
	{
		$this->_msgText		= $value;
		return $this;
	}
	public function getAttachments()
	{
		return $this->_attachObjs;
	}
	public function addAttachment($attObj)
	{
		$this->_attachObjs[]	= $attObj;
		return $this;
	}
	public function getGroup()
	{
		return $this->_grpObj;
	}
	public function setGroup($obj)
	{
		$this->_grpObj		= $obj;
		return $this;
	}
	public function getGroupType()
	{
		return $this->_grpType;
	}
	public function setGroupType($value)
	{
		$this->_grpType		= $value;
		return $this;
	}
}