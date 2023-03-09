<?php /*I'm a page!*/ 
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
