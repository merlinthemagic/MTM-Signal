<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Attachments\SignalCli;

abstract class Base extends \MTM\SignalApi\Models\Attachments\Base
{
	protected $_msgObj=null;
	protected $_mimeType=null;
	protected $_fileName=null;
	protected $_id=null;
	protected $_size=null;
	protected $_fileObj=null;
	
	public function getMessage()
	{
		return $this->_msgObj;
	}
	public function getMimeType()
	{
		return $this->_mimeType;
	}
	public function getFilename()
	{
		return $this->_fileName;
	}
	public function getId()
	{
		return $this->_id;
	}
	public function getSize()
	{
		return $this->_size;
	}
	public function getFile()
	{
		if ($this->_fileObj === null) {
			$path			= $this->getMessage()->getUser()->getDataDir()->getPathAsString()."attachments";
			$this->_fileObj	= \MTM\FS\Factories::getFiles()->getFile($this->getId(), $path);
		}
		return $this->_fileObj;
	}
}