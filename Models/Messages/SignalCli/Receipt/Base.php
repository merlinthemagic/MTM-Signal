<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Messages\SignalCli\Receipt;

abstract class Base extends \MTM\SignalApi\Models\Messages\SignalCli\Zstance
{
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
	// 	protected $_msgTimestamp=null;
	// 	protected $_msgText=null;
	// 	protected $_attachObjs=null;
}