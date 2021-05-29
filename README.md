# MTM-Signal

## What is this?

Send and receive messages using the Signal Messenger. This project is a wrapper for <a href="https://github.com/AsamK/signal-cli">Signal-CLI</a> giving you a simple OOP API for using signal in a PHP environment.

## Install:

### Requirements:

Linux, PHP 7.x, JRE 11

### Composer install:

Install the lib via composer:

```
composer require merlinthemagic/mtm-signal-api

```

### Manual install:

If you prefer you can simply download the 3 packages separately and include their autoloaders in yur project.

```
require_once "/path/to/mtm-utilities/Enable.php";
require_once "/path/to/mtm-fs/Enable.php";
require_once "/path/to/mtm-signal-api/Enable.php";

```

### Post install:

You must make the signal-cli binary executable:

```
chmod +x /path/to/mtm-signal-api/Vendors/SignalCli/bin/signal-cli

```


##Quick start:


### Get a Client:

```
//Secure the data directory you will be using, private keys and passphrases are stored in plaintext
//make sure the folder is writable by your php user
$safePath		= "/path/to/secure/folder/";

//For testing on linux you can use the following:
//$safePath		= MTM_FS_TEMP_PATH. "sigtest";

$clientObj		= \MTM\SignalApi\Facts::getClients()->getSignalCli($safePath);
```

### Get a user to work with:

```
$phoneNumber	= "+12134567890";
$userObj	= $clientObj->getUser($phoneNumber);

```

#### Register New Account via Captcha:

WARNING! This method will disconnect any existing devices from the phone number.
You will be taking over the account, not linking a new device

Goto: https://signalcaptchas.org/registration/generate.html

Complete the Captcha, hit "F12" to open developer tools. Right click the link in the console that starts with: "signalcaptcha://" Copy the link address so you can paste it to the register method below

```
$captcha		= "signalcaptcha://03ADsBq82yYFHDEA.....";
$userObj->registerByCaptcha($captcha); //will throw on error
```

You will receive an SMS code on your device, use that to run the next step of verification

#### Verify New Account via SMS code:

```
$code			= "234568";
$userObj->verifyBySmsCode($code); //will throw on error
```


#### Send a text message from phone number to phone number:

```
$toNbr			= "+13109981100";
$msg			= "Hi Mom,\nPlease buy food, im so hungry!\nThx";
$timeStamp		= $userObj->sendText($toNbr, $msg); //will throw on error
```

#### Receive pending messages for a phone number:

```
//return array of message objects
$msgObjs		= $userObj->receive(); //will throw on error
foreach ($msgObjs as $msgObj) {
	if ($msgObj->getType() == "DataMessage") {
			echo $msgObj->getMessage()."<br><br>";
	} elseif ($msgObj->getType() == "ReceiptMessage") {
			echo $msgObj->getWhen()."<br><br>";
	}
}
```

#### Link to a master account:

This will generate a URI that can be used to link the client as a slave on an existing master.
This method will NOT disconnect any existing devices. It will simply allow 
a master device to approve the server as a linked account
NOTE: This method is executed on the client object, not on any specific user. The generated user depends on
the master device that accepts the link

```
$name		= "My Test Server"; //shows up on master as identification
$uri		= $clientObj->getDeviceLinkUri($name); //will throw on error
```

Now load the URI into your favorite QR generator or paste it to:
https://www.cssscript.com/demo/pure-javascript-qr-code-generator-qrious/
Then scan the QR code with a master device.
Voila the server has a new linked user account that can send and receive messages

#### Accept slave link request:

This will accept a request to link from a slave.
This method will NOT disconnect any existing devices. It will simply allow 
a slave device to become a linked account of the master account that approves the request
NOTE: This method is executed on the user object. The slave user depends on who generate the uri

```
$uri		= "tsdevice:/?uuid=BBm...";
$userObj->linkDeviceByUri($uri); //will throw on error
```


### Contacts:

#### Get Contacts:

```
//return array of Contact objs
$array			= $userObj->getContacts(); //will throw on error
```

#### Get Contact By Username:

```
//return contact obj, null or throws
$username		= "+13109997765";
$throw			= false;
$contactObj	= $userObj->getContactByUsername($username, $throw);
```



### Groups:


#### Get Groups:

```
//return array of Group objs
$array			= $userObj->getGroups(); //will throw on error
```

#### Get Group By ID:

```
//return group obj, null or throws
$id				= "efefekneef....";
$throw			= false;
$groupObj		= $userObj->getGroupById($id, $throw);
```

#### Create Group:

```
//return group obj
$name				= "My Group";
$groupObj			= $userObj->createGroups($name); //will throw on error
```

#### Set Group Name:

```
//return group obj
$name				= "My New Group Name";
$groupObj->setName($name);
```

#### Set Group Edit detail permission:

```
$adminOnly				= true; //true or false
$groupObj->setEditDetailAdminOnly($adminOnly);
```

#### Set Group Add members permission:

```
$adminOnly				= true; //true or false
$groupObj->setAddMemberAdminOnly($adminOnly);
```


#### Add Member to group:

```
$contactObj	= $userObj->getContactByUsername("+13109997765");
$groupObj->addMember($contactObj);
```

#### Remove Member from group:

```
$contactObj	= $userObj->getContactByUsername("+13109997765");
$groupObj->removeMember($contactObj);
```

#### Get Group Members:

```
//Does not return user self. Use $groupObj->getIsMember() to determine user membership

//return array of Contact objs
$array		= $groupObj->getMembers();
```

#### Add Admin to group:

```
$contactObj	= $userObj->getContactByUsername("+13109997765");
$groupObj->addAdmin($contactObj);
```

#### Remove Admin from group:

```
$contactObj	= $userObj->getContactByUsername("+13109997765");
$groupObj->removeAdmin($contactObj);
```

#### Get Group Admins:

```
//Does not return user self. Use $groupObj->getIsAdmin() to determine user is admin

//return array of Contact objs
$array		= $groupObj->getAdmins();
```


#### Identities:

#### Get Identities (not-ready):

```
//return array of identity objects
$array			= $userObj->getIdentities(); //will throw on error
```

#### Devices:

#### Get Devices (not-ready):

```
//return array of device objects
$array			= $userObj->getDevices(); //will throw on error
```