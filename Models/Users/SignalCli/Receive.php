<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Models\Users\SignalCli;

abstract class Receive extends Lists
{
	public function receive()
	{
		$rObjs	= array();
		$dObjs	= $this->getClient()->receiveMessages($this);
		foreach ($dObjs as $dObj) {
			
			$rObj	= null;
			if (property_exists($dObj, "envelope") === false) {
				throw new \Exception("Input missing: envelope");
			}
			$envObj		= $dObj->envelope;
			if (property_exists($envObj, "dataMessage") === true) {
				$rObj	= $this->getDataMessage($envObj);
			} elseif ($envObj instanceof \stdClass === false) {
				throw new \Exception("Envelope is invalid");
			} elseif (property_exists($envObj, "receiptMessage") === true) {
				$rObj	= $this->getReceiptMessage($envObj);
			} elseif (property_exists($envObj, "syncMessage") === true) {
				$rObj	= $this->getSyncMessage($envObj);
			} else {
				//deal with other types of messages
			}
			
			if ($rObj !== null) {
				$rObjs[]	= $rObj;
			}
		}
		return $rObjs;
	}
	protected function getDataMessage($envObj)
	{
		if (property_exists($envObj, "timestamp") === false) {
			throw new \Exception("Envelope timestamp is missing");
		} elseif (property_exists($envObj, "source") === false) {
			throw new \Exception("Envelope source is missing");
		} elseif (property_exists($envObj, "sourceDevice") === false) {
			throw new \Exception("Envelope sourceDevice is missing");
		} elseif (property_exists($envObj, "dataMessage") === false) {
			throw new \Exception("Envelope dataMessage is missing");
		}
		
		$rObj		= new \MTM\SignalApi\Models\Messages\SignalCli\Data\Zstance();
		$rObj->initialize($this, $envObj->timestamp);

		$msgObj		= $envObj->dataMessage;
		if (property_exists($msgObj, "message") === false) {
			throw new \Exception("Message is missing");
		}
		$rObj->setMessage($msgObj->message);
		
		if (property_exists($msgObj, "attachments") === false) {
			throw new \Exception("Attachments is missing");
		}
		foreach ($msgObj->attachments as $aObj) {
			if ($aObj instanceof \stdClass === false) {
				throw new \Exception("Attachment not object");
			} elseif (property_exists($aObj, "contentType") === false) {
				throw new \Exception("Attachment missing: contentType");
			} elseif (property_exists($aObj, "filename") === false) {
				throw new \Exception("Attachment missing: filename");
			} elseif (property_exists($aObj, "id") === false) {
				throw new \Exception("Attachment missing: id");
			} elseif (property_exists($aObj, "size") === false) {
				throw new \Exception("Attachment missing: size");
			}

			$attObj				= new \MTM\SignalApi\Models\Attachments\SignalCli\Zstance();
			$attObj->initialize($rObj, $aObj->contentType, $aObj->filename, $aObj->id, intval($aObj->size));
			$rObj->addAttachment($attObj);
		}
		return $rObj;
	}
	protected function getReceiptMessage($msgObj)
	{
		//not ready to deal with read receipts
		return null;
	}
	protected function getSyncMessage($msgObj)
	{
		//not ready to deal with sync messages
		return null;
	}
}