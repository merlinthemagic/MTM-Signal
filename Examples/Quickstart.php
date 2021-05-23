<?php
//© 2021 Martin Peter Madsen
namespace MTM\SignalApi\Examples;

class Quickstart
{
	protected $_clientObj=null;
	
	public function getClient()
	{
		if ($this->_clientObj === null) {
			$dataPath			= MTM_FS_TEMP_PATH. "signaltest";
			$this->_clientObj	= \MTM\SignalApi\Facts::getClients()->getSignalCli($dataPath);
		}
		return $this->_clientObj;
	}
	public function getUser()
	{
		$phoneNumber	= "+12134567890";
		return $this->getClient()->getUser($phoneNumber);
	}
	public function registerByCaptcha()
	{
		//WARNING! This method will disconnect any existing devices from the phone number. You will be taking over the account, not linking a new device
		
		//Goto: https://signalcaptchas.org/registration/generate.html
		//Complete the Captcha, hit "F12" to open developer tools. 
		//Right click the link in the console that starts with: "signalcaptcha://" 
		//Copy the link address so you can paste it to the register method below
		$captcha		= "signalcaptcha://03ADsBq82yYFHDEA.....";
		return $this->getUser()->registerByCaptcha($captcha); //will throw on error, else true
		
		//you will receive a SMS code, once you have it call: $this->verifyBySmsCode();
	}
	public function verifyBySmsCode()
	{
		$code			= "234568";
		return $this->getUser()->verifyBySmsCode($code); //will throw on error, else true
		
		//done! your account is ready for use
	}
	public function sendMessage()
	{
		$toNbr			= "+13109981100";
		$msg			= "Hi Mom,\nPlease buy food, im so hungry!\nThx";
		return $this->getUser()->sendText($toNbr, $msg); //will throw on error, else return a timestamp
	}
	public function receiveMessages()
	{
		$msgObjs	= $this->getUser()->receive();
		foreach ($msgObjs as $msgObj) {
			if ($msgObj->getType() == "DataMessage") {
				
				//get the text message
				echo $msgObj->getMessage()."<br><br>";
				
				
				foreach ($msgObj->getAttachments() as $attachObj) {
					if (preg_match("/image/", $attachObj->getMimeType()) == 1) {
						echo "<img src='data:image/jpeg;base64, ".base64_encode($attachObj->getFile()->getContent())."'/><br><br>";
					} else {
						//do something else with the file.
						//to get file content: $attachObj->getFile()->getContent()
					}
				}
			} else {
				//no other data types supported yet
			}
		}
	}
}