<?php /*I'm a page!*/ 
//getenv('HTTP_HOST')
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');
//require_once('db_conf.php');

/********************************************************************************
*	GNERATE RANDOM STRING FUNCTION
*		Max value for length should not exceed 16 for URL generation.
*		Otherwise use whatever. I don't care. I'm a comment, not the police.
********************************************************************************/
function generateRandomString($length = 16) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

/********************************************************************************
*	NULL INPUT STRING TO NULL VALUE FUNCTION
*		Note: non-empty strings are left as-is.
*		This function prepares values for SQL Insert.
********************************************************************************/
function null_input($data) {
  if(strlen($data) == 0)
	{	//The Great Nullifier
		$data = NULL;
	}
  return $data;
}

/********************************************************************************
*	CLEAN INPUT FUNCTION
*		Function restricts data overall length, trims whitespace, escapes, returns
********************************************************************************/
function cleanInput($data){
	if(strlen($data) > 65535)
	{
		fwrite(STDERR, "An error occurred. Check the length of your input.\n");
		exit(1); // A response code other than 0 is a failure
	}
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

/********************************************************************************
*	LIGHT CLEAN INPUT FUNCTION
*		Function restricts data overall length, trims whitespace, escapes, returns
********************************************************************************/
function lightCleanInput($data){
	if(strlen($data) > 65535)
	{
		fwrite(STDERR, "An error occurred. Check the length of your input.\n");
		exit(1); // A response code other than 0 is a failure
	}
	$data = trim($data);
	return $data;
}

/********************************************************************************
*	INPUT ERROR REDIRECT HELPER FUNCTION
*		Note: redirects only work before page content loads.
*
*	redirect('http://imade.yourmother.com/');
********************************************************************************/
function redirect($url, $statusCode = 303){
   header('Location: ' . $url, true, $statusCode);
   die();
}

/********************************************************************************
*	GET COOKIE FUNCTION
*		Note: Checks shit.
********************************************************************************/
function getSessionCookie($cookie_name){
    if(isset($_POST['session'])) {
        $sessionCleaned = cleanInput($_POST['session']);
        if(!isset($_COOKIE[$cookie_name])){
            return 0;
        }else{
            return $_COOKIE[$cookie_name];
        }
    }elseif (isset($_GET['session'])) {
        $sessionCleaned = cleanInput($_GET['session']);
        if(!isset($_COOKIE[$cookie_name])){
            return 0;
        }else{
            return $_COOKIE[$cookie_name];
        }
    }
	else {
		echo "Cookie not found?";
		return 0;
		//redirect($_SERVER['DOCUMENT_ROOT']."/quiz/");
		//exit(0);
	}
}
/********************************************************************************
*	SET COOKIE FUNCTION
*		Note: Makes shit.
********************************************************************************/
function setSessionCookie($cookie_name, $cookie_value){
	setcookie($cookie_name, $cookie_value, time() + (86400 * 7), "/"); // 86400 = 1 day, this is for 1 week	
	return 1;
}
/********************************************************************************
 *	UNSET COOKIE FUNCTION
 *		Note: Makes shit.
 ********************************************************************************/
function unsetSessionCookie($cookie_name){
    setcookie($cookie_name, null, -1, "/"); // 86400 = 1 day, this is for 1 week
    return 1;
}
