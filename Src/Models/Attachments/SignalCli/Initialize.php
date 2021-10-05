<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Attachments\SignalCli;

abstract class Initialize extends Base
{
	public function initialize($msgObj, $mimeType, $filename, $id, $size)
	{
		if ($msgObj instanceof \MTM\SignalApi\Models\Messages\SignalCli\Base === false) {
			throw new \Exception("Invalid message input");
		} elseif (is_string($mimeType) === false) {
			throw new \Exception("Invalid mime type input");
		} elseif (is_string($filename) === false) {
			throw new \Exception("Invalid filename input");
		} elseif (is_string($id) === false) {
			throw new \Exception("Invalid id input");
		} elseif (is_int($size) === false) {
			throw new \Exception("Invalid size input");
		}
		$this->_msgObj		= $msgObj;
		$this->_mimeType	= $mimeType;
		$this->_fileName	= $filename;
		$this->_id			= $id;
		$this->_size		= $size;
		
		return $this;
	}
}