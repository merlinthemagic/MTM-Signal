<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Messages\SignalCli\Data;

abstract class Initialize extends Base
{
	public function setMessage($value)
	{
		$this->_msgText		= $value;
		return $this;
	}
	public function addAttachment($attObj)
	{
		$this->_attachObjs[]	= $attObj;
		return $this;
	}
}