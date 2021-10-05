<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Messages\SignalCli\Receipt;

abstract class Base extends \MTM\SignalApi\Models\Messages\SignalCli\Base
{
	protected $_srcAddress=null;
	protected $_srcDevice=null;
	protected $_when=null;
	protected $_isDelivery=null;
	protected $_isRead=null;
	protected $_timestamps=array();
	
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
	public function getWhen()
	{
		return $this->_when;
	}
	public function setWhen($value)
	{
		$this->_when	= $value;
		return $this;
	}
	public function getIsDelivery()
	{
		return $this->_isDelivery;
	}
	public function setIsDelivery($value)
	{
		$this->_isDelivery	= $value;
		return $this;
	}
	public function getIsRead()
	{
		return $this->_isRead;
	}
	public function setIsRead($value)
	{
		$this->_isRead	= $value;
		return $this;
	}
	public function getTimestamps()
	{
		return $this->_timestamps;
	}
	public function setTimestamps($value)
	{
		$this->_timestamps	= $value;
		return $this;
	}
}