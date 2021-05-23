<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Messages\SignalCli\Data;

abstract class Base extends \MTM\SignalApi\Models\Messages\SignalCli\Zstance
{
	protected $_msgText=null;
	protected $_attachObjs=array();
	
	public function getSender()
	{
		return $this->_srcObj;
	}
	public function getMessage()
	{
		return $this->_msgText;
	}
	public function getAttachments()
	{
		return $this->_attachObjs;
	}
}