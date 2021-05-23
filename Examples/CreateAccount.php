<?php
//© 2021 Martin Peter Madsen

### Example minimal package install on CentOS 7 with composer:

//yum install http://rpms.remirepo.net/enterprise/remi-release-7.rpm
//yum install php74-php-cli --enablerepo=remi
//ln -s /usr/bin/php74 /usr/bin/php
//yum install git-core java-11-openjdk
//curl -sS https://getcomposer.org/installer | php
//cp /root/composer.phar /usr/bin/composer
//cd /path/to/your/project
//composer require merlinthemagic/mtm-signal-api
//composer install

//Then run:
$autoloadPath	= realpath("/path/to/composer/vendor/autoload.php");
if ($autoloadPath === false) {
	die("Composer autoloader is missing");
}

require_once $autoloadPath;

$dataPath	= MTM_FS_TEMP_PATH. "signaltest";
$clientObj	= \MTM\SignalApi\Facts::getClients()->getSignalCli($dataPath);

$phoneNumber	= "+12134567890";
$userObj		= $clientObj->getUser($phoneNumber);

//STEP 1:
//WARNING! This method will disconnect any existing devices from the phone number. You will be taking over the account, not linking a new device
//Goto: https://signalcaptchas.org/registration/generate.html
//Complete the Captcha, hit "F12" to open developer tools. Right click the link in the console that starts with: "signalcaptcha://"
//uncomment 2 lines below and paste the link:

//$captcha		= "signalcaptcha://03ADsBq82yYFHDEA.....";
//$userObj->registerByCaptcha($captcha);


//STEP 2:
//comment out the 2 lines above again. 
//uncomment 2 lines below and type in the code you received by SMS:

// $code			= "908908";
// $userObj->verifyBySmsCode($code);


//STEP 3:
//comment out the 2 lines above again. 
//uncomment 3 lines below and send your first message to someone:

// $toNbr		= "+13109981100";
// $msg			= "Hi Mama,\nPlease buy food, im so hungry!\nThx";
// $userObj->sendText($toNbr, $msg);