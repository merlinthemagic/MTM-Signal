<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Clients\SignalCli;

abstract class Exec extends Base
{
	protected $_cmdTimeout=10000;
	protected $_ctrlObj=null;
	
	public function getTimeout()
	{
		return $this->_cmdTimeout;
	}
	public function setTimeout($ms)
	{
		if (is_int($ms) === false) {
			throw new \Exception("Invalid input");
		}
		return $this->_cmdTimeout;
	}
	protected function getCtrl()
	{
		if ($this->_ctrlObj === null) {
			$this->_ctrlObj		= \MTM\Utilities\Factories::getSoftware()->getPhpTool()->getShell();
		}
		return $this->_ctrlObj;
	}
	protected function exeCmd($userObj, $strCmd)
	{
		//add MtmEmpty/MtmError so data/errors are returned quickly and do not just time out
		$this->initialize();
		$baseCmd		= $this->getSignalBinFile()->getPathAsString();
		$baseCmd		.= " --config \"".$userObj->getDataDir()->getPathAsString()."\"";
		$strCmd			= $baseCmd." ".$strCmd." | base64 -w0  && echo \"MtmEmpty\" || echo \"MtmError\"";

		$this->ctrlWrite($strCmd);
		$rObj			= $this->ctrlRead($this->getTimeout());
		$rObj->data		= trim(base64_decode(rtrim(trim($rObj->data), "MtmEmpty")));
		$rObj->error	= rtrim(trim($rObj->error), "MtmError");
		return $rObj;
	}
	protected function ctrlWrite($strCmd)
	{
		$this->getCtrl()->write($strCmd);
		return $this;
	}
	protected function ctrlRead($timeout)
	{
		return $this->getCtrl()->read($timeout);
	}
}