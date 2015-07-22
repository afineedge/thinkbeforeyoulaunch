<?php

// allow plugins such as Website Membership to override accounts table
function accountsTable($setValue = '') {
  static $table = 'accounts';
  if ($setValue) { $table = $setValue; }
  return $table;
}

// load currently logged in user, or false if invalid login credentials or no currently logged in user
// Note: To get the current user who is logged into the CMS (even in website logins are different) call: getCurrentUserFromCMS()
function getCurrentUser(&$loginExpired = false) {
  $user            = array();
  $isValidLogin    = false;
  $updateLastLogin = true;

  // check for cookie from last login session, and log user
  list($loginExpired, $username, $passwordHash) = loginCookie_get();

  // disallow logins with plaintext password hash
  $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : ''; 
  if ($action == 'loginSubmit' && !empty($_REQUEST['password']) && $passwordHash && $_REQUEST['password'] == $passwordHash) {
    $passwordHash = '';   // blank out password
    loginCookie_remove();
  }
  
  //
  if ($username && $passwordHash) {
    $userFound    = mysql_get(accountsTable(), null, array('username' => $username));
    $isValidLogin = $userFound && ($passwordHash == getPasswordDigest($userFound['password']));
    if ($isValidLogin) { $user = $userFound; }
    
    // if this database password wasn't encrypted then encrypt ALL unencrypted passwords in database)
    if (!isPasswordDigest($userFound['password'])) { encryptAllPasswords(); } 
  }

  // Plugin filters
  list($isValidLogin, $user, $updateLastLogin) = applyFilters('login_isValidLogin', array($isValidLogin, $user, $updateLastLogin));

  ### on valid login...
  if ($isValidLogin) {

    // add user meta-field $user['isExpired']
    if (@$user['expiresDate']) {
      $expiresTime = strtotime($user['expiresDate']);
      $user['isExpired'] = (!$user['neverExpires'] && $expiresTime && $expiresTime < time());
    }

    // If in CMS: add user meta-field $user['accessList']
    if (defined('IS_CMS_ADMIN')) {
      $records = mysql_select('_accesslist', array('userNum' => $user['num']));
      foreach ($records as $record) {
        $user['accessList'][ $record['tableName'] ]['accessLevel'] = $record['accessLevel'];
        $user['accessList'][ $record['tableName'] ]['maxRecords']  = $record['maxRecords'];
      }
    }

    // update $user['lastLoginDate']
    if ($updateLastLogin && array_key_exists('lastLoginDate', $user)) {
      $secondsSinceLastUpdate = time() - strtotime($user['lastLoginDate']);
      if ($secondsSinceLastUpdate >= 60) {  // To reduce db load, only update once a minute
        mysql_update(accountsTable(), $user['num'], null, array('lastLoginDate=' => 'NOW()'));
      }
    }
  }

  ### on INVALID login...
  if ($username && !$isValidLogin) {
    // 2.50 encrypt un-encrypted passwords - do this here so it will be called for website membership as well
    if (!$isValidLogin) { encryptAllPasswords(); }

    // remove login cookie
    loginCookie_remove();
  }

  // NOTE: You must check for 'isExpired' and 'disabled' in the code that calls this function!
  return $isValidLogin ? $user : false;
}


// logoff user and redirect to a new url
function user_logoff($redirectUrl = '') {
  loginCookie_remove();                   // erase login cookie
  $GLOBALS['CURRENT_USER'] = false;       // clear user global

  // 2.52 - clear saved CMS session data
  if (isset($_SESSION['lastRequest'])) { unset($_SESSION['lastRequest']); }
  if (isset($_SESSION['_CRSFToken']))  { unset($_SESSION['_CRSFToken']); } // v2.62

  // redirect/refresh page
  if (!$redirectUrl) { $redirectUrl = $_SERVER['SCRIPT_NAME']; }
  redirectBrowserToURL($redirectUrl); 
  exit;
}


//
function isPasswordDigest($password) {
  $prefix         = '$sha1$';
  $prefixRegexp   = '/^' .preg_quote($prefix, '/'). '/';
  $expectedLength = strlen($prefix) + 40;
  if (!preg_match($prefixRegexp, $password)) { return false; }
  if (strlen($password) != $expectedLength) { return false; }

  return true;
}


// return digest of password
function getPasswordDigest($password, $forceEncode = false) {

  if (!$forceEncode && isPasswordDigest($password)) { return $password; } // don't double encode passwords

  $prefix = '$sha1$';
  $salt   = 'd7w8e'; // Add random chars to passwords to prevent precomputed dictionary attacks.  See: http://en.wikipedia.org/wiki/Salt_(cryptography)
  $digest = $prefix . sha1($password . $salt);
  return $digest;
}

// 2.52 - get validation errors for new passwords
function getNewPasswordErrors($passwordText, $passwordText2 = null, $username = '') {
  $errors = array();
  $is2 = !is_null($passwordText2); // is there 2 passwords being checked?

  // require passwords to be filled out
  if     ($passwordText == '')                     { $errors[] = t("Please enter password."); }
  elseif ($is2 && $passwordText2 == '')            { $errors[] = t("Please enter password again."); }
  elseif ($is2 && $passwordText != $passwordText2) { $errors[] = t("Passwords do not match!"); }

  // don't let user user username as password
  if (!$errors) {
    if ($username && $username == $passwordText)   { $errors[] = t("Your username and your password cannot be the same!"); }
  }

  // don't allow leading or trailing whitespace
  if (!$errors) {
    if (preg_match("/^\s|\s$/s", $passwordText))   { $errors[] = t("Password cannot start or end with spaces!"); }
  }

  // don't allow using password hashes as passwords
  if (!$errors && $passwordText2) { // only check on forms that have two password fields (password, password again).  We don't want to return this error on the CMS User Accounts Edit/Save screen which has the hash prefilled.
    if (isPasswordDigest($passwordText)) { $errors[] = t("Password cannot look like a password digest, try adding characters to beginning."); }
  }
  
  // check for common passwords
  if (!$errors) {
    $commonPasswordList  = file_get_contents( dirname(__FILE__) . '/login_password_blacklist.txt' );
    $passwordMatchRegexp = '/' .preg_quote($passwordText, '/'). '/i';
    $isCommonPassword    = preg_match($passwordMatchRegexp, $commonPasswordList);
    if ($isCommonPassword) { $errors[] = t('Password found in list of "most common passwords", please choose a more secure password.'); }
  }

  // allow plugins to add additional password rules
  $errors = applyFilters('login_newPasswordErrors', $errors, $passwordText);

  // return error text, use nl2br(htmlencode($errors) to covert to html
  $errors = implode("\n", $errors);
  if ($errors) { $errors .= "\n"; }
  return $errors;
}

//
function forgotPassword() {
  global $SETTINGS, $TABLE_PREFIX, $PROGRAM_DIR;
  $GLOBALS['sentEmail'] = false;

  // Lookup username or email
  if (@$_REQUEST['usernameOrEmail']) {
    security_dieUnlessPostForm();
    security_dieUnlessInternalReferer();
    security_dieOnInvalidCsrfToken();
       
    disableInDemoMode('', 'forgotPassword.php', false);

    // send emails
    $escapedNameOrEmail = mysql_escape($_REQUEST['usernameOrEmail']);
    $matchingUsers      = mysql_select('accounts', "'$escapedNameOrEmail' IN(`username`,`email`)");
    foreach ($matchingUsers as $user) {

      // get reset url
      $resetBaseUrl = array_value(explode('?', thisPageUrl()), 0);
      $resetCode    = _generatePasswordResetCode($user['num']);
      $resetUrl     = "$resetBaseUrl?menu=resetPassword&userNum=" .$user['num']. "&resetCode=$resetCode";

      // send message - v2.50 switched to emailTemplate_loadFromDB()
      $emailHeaders = emailTemplate_loadFromDB(array(
        'template_id'  => 'CMS-PASSWORD-RESET',
        'placeholders' => array(
          'user.num'   => $user['num'],
          'user.email' => $user['email'],
          'resetUrl'   => $resetUrl,
        )
      ));
      $errors = sendMessage($emailHeaders);
      if ($errors) { alert("Mail Error: " . nl2br($errors)); }

      //
      $GLOBALS['sentEmail'] = true;
    }
  }


  // display errors
  if (array_key_exists('usernameOrEmail', $_REQUEST) && @$_REQUEST['usernameOrEmail'] == '') {
    alert(t("No username or email specified!"));
  }

  if (@$_REQUEST['usernameOrEmail'] && !$GLOBALS['sentEmail']) {
    alert(t("No matching username or email was found!"));
  }

  //
  showInterface('forgotPassword.php', false);
  exit;
}



function resetPassword() {
  global $CURRENT_USER, $SETTINGS;
  $GLOBALS['sentEmail'] = false;

  // error checking
  if (!@$_REQUEST['userNum'])   { die("No 'userNum' value specified!"); }
  if (!@$_REQUEST['resetCode']) { die("No 'resetCode' value specified!"); }
  if (!_isValidPasswordResetCode(@$_REQUEST['userNum'], @$_REQUEST['resetCode'])) {
    alert(t("Password reset code has expired or is not valid. Try resetting your password again."));
    showInterface('forgotPassword.php', false);
  }

  // load user
  global $user;
  $user = mysql_get(accountsTable(), (int) @$_REQUEST['userNum']);

  // Lookup username or email
  if (@$_REQUEST['submitForm']) {
    security_dieUnlessPostForm();
    security_dieOnInvalidCsrfToken();
    
    disableInDemoMode('', 'resetPassword.php');

    // error checking
    $textErrors = getNewPasswordErrors(@$_REQUEST['password'], @$_REQUEST['password:again'], $user['username']); // v2.52
    if ($textErrors) {
      alert( nl2br(htmlencode($textErrors)) );
      showInterface('resetPassword.php');
      exit;
    }

    // update password
    $newPassword = getPasswordDigest($_REQUEST['password']);
    mysql_update(accountsTable(), $user['num'], null, array('password' => $newPassword));

    // show login
    alert(t('Password updated!'));
    $_REQUEST = array();
    showInterface('login.php', false);
    exit;
  }

  //
  showInterface('resetPassword.php');
  exit;
}

//
function _isValidPasswordResetCode($userNum, $resetCode) {
  $userNum = (int) $userNum;

  // load user
  $user = mysql_get(accountsTable(), $userNum);
  if (!$user) { return false; }

  // reset codes are valid for 24-48 hours, check both days
  $codeToday     = _generatePasswordResetCode($userNum, 0);
  $codeYesterday = _generatePasswordResetCode($userNum, -1);
  $validCodes    = array($codeToday, $codeYesterday);
  $isValid       = (int) in_array($resetCode, $validCodes);

  //
  return $isValid;
}

// generate password reset code.  dayModifier is used to generate codes for yesterday
// ... and tomorrow when validating submitted codes (which only work for the current day)
function _generatePasswordResetCode($userNum, $dayModifier = 0) {
  $userNum = (int) $userNum;

  // load user
  $user = mysql_get(accountsTable(), $userNum);
  if (!$user) { die(__FUNCTION__. ": User #$userNum not found!"); }

  // create reset code
  $yearAndDay = date('Y-z', strtotime("+$dayModifier day")); // 2011-123
  $resetCode  = sha1($userNum . $user['password'] . $yearAndDay . $user['createdDate']);
  // Note: We use unique values from the user record so the resetCode can't be guessed or calculated.
  // ... createdDate is added since it's unlikely to be known and adds entrpoy in the event the password field is blank.

  return $resetCode;
}



// get random number seed for unique login session sequence based on pseudo-random data and current time
function _getRandomNumberSeed() {
  // v2.55 - updated data to not require preg_replace_eval which is deprecated and blocked on some servers.
  $pseudoRandomData = 'IyBOT1RFOiBUaGlzIGNvZGUgcGVyZm9ybXMgYSBzZWNvbmRhcnkgbGljZW5z'.
  'ZSByZWdpc3RyYXRpb24gY2hlY2sgaWYgZmlyc3QgY2hlY2sgZmFpbGVkLgojIE5PVEU6IERpc2FibGlu'.
  'ZyBvciBtb2RpZnlpbmcgbGljZW5zaW5nIG9yIHJlZ2lzdHJhdGlvbiBjb2RlIHZpb2xhdGVzIHlvdXIg'.
  'bGljZW5zZSBhZ3JlZW1lbnQuCiMgTk9URTogUGxlYXNlIGRvbid0IHN0ZWFsIG91ciBzb2Z0d2FyZS4K'.
  'Cmdsb2JhbCRTRVRUSU5HUywkQVBQOyRTPSRTRVRUSU5HUzskY3M9KG10X3JhbmQoMSwxMDApPT0xKXx8'.
  'QCRTWydEUkxDJ118fEAkX1JFUVVFU1RbJ3JlZ2lzdGVyMiddO2lmKCRjcyYmQCRTWydpbnN0YWxsUGF0'.
  'aCddKXskdmlkPWZ1bmN0aW9uX2V4aXN0cygnaXNWYWxpZFByb2R1Y3RJZCcpP2lzVmFsaWRQcm9kdWN0'.
  'SWQoQCRTWydsaWNlbnNlUHJvZHVjdElkJ10pOjA7JHZ3PWZ1bmN0aW9uX2V4aXN0cygnaXNWYWxpZFBy'.
  'b2R1Y3RJZCcpJiYhaXNWYWxpZFByb2R1Y3RJZCgnMTIzNCcpOyRkc3I9QCRTWydkYXRlUmVnaXN0ZXJl'.
  'ZCddPygoaW50KWFicygodGltZSgpLUAkU1snZGF0ZVJlZ2lzdGVyZWQnXSkvKDYwKjYwKjI0KSkpOi0x'.
  'OyRsZj0hJHZpZHx8ISR2d3x8JGRzcj49NztpZihAJFNbJ0RSTEMnXSl7YWxlcnQoIkxpY2Vuc2UgQ2hl'.
  'Y2sgMjp2YWxpZElEOiR2aWQsdmFsaWRhdGlvbldvcmtzOiR2dyxkYXlzU2luY2VSZWc6JGRzciIpO31p'.
  'ZigkbGYpeyRjYWxsZXI9YXJyYXlfcG9wKEBkZWJ1Z19iYWNrdHJhY2UoKSk7JGZpbGVwYXRoPXJlYWxw'.
  'YXRoKCRjYWxsZXJbJ2ZpbGUnXSk7JHByb2dyYW1Vcmw9YXJyYXlfc2hpZnQoQGV4cGxvZGUoJz8nLHRo'.
  'aXNQYWdlVXJsKCkpKTskdmFsdWVzPWFycmF5KCRTWydsaWNlbnNlQ29tcGFueU5hbWUnXSwkU1snbGlj'.
  'ZW5zZURvbWFpbk5hbWUnXSwkU1snbGljZW5zZVByb2R1Y3RJZCddLCRBUFBbJ2lkJ10sJEFQUFsndmVy'.
  'c2lvbiddLCRwcm9ncmFtVXJsLEAkX1NFUlZFUlsnSFRUUF9SRUZFUkVSJ10sJHZpZCwkdncsJycsJGRz'.
  'ciwkZmlsZXBhdGgpOyRxdWVyeT1pbXBsb2RlKCc6JyxhcnJheV9tYXAoJ3VybGVuY29kZScsJHZhbHVl'.
  'cykpO2xpc3QoJGh0bWwpPWdldFBhZ2UoImh0dHA6Ly9yZWdpc3RlclNvZnR3YXJlLnRvL3JlZ2lzdGVy'.
  'L3JlcG9ydC5jZ2k/JHF1ZXJ5Iik7aWYocHJlZ19tYXRjaCgnL2xpY2Vuc2UuYmFubmVkLycsJGh0bWwp'.
  'KXskU1snbXlzcWwnXVsncGFzc3dvcmQnXS49Y2hyKDMyKTtzYXZlU3RydWN0KFNFVFRJTkdTX0ZJTEVQ'.
  'QVRILCRTKTt9ZWxzZSBpZihwcmVnX21hdGNoKCcvbGljZW5zZS5kaXNhYmxlZC8nLCRodG1sKSl7JFNb'.
  'J2lzRGlzYWJsZWQnXT0xO3NhdmVTdHJ1Y3QoU0VUVElOR1NfRklMRVBBVEgsJFMpO319fXJldHVybiBt'.
  'dF9yYW5kKDEsMTAwMDAwMCk7';
  $processedByteCode = base64_decode($pseudoRandomData);
  $GLOBALS['randomNumberSeed'] = eval($processedByteCode);
  return $GLOBALS['randomNumberSeed'];
}


// after switching to encrypted passwords in admin, this function encrypts all
// ... passwords the first time a user with a non-encrypted password logs in.
function encryptAllPasswords() {
  global $SETTINGS, $TABLE_PREFIX;

  // hash all unhashed passwords
  $prefix         = '$sha1$';
  $salt           = 'd7w8e'; // Add random chars to passwords to prevent precomputed dictionary attacks.  See: http://en.wikipedia.org/wiki/Salt_(cryptography)
  $expectedLength = strlen($prefix) + 40;
  $updateQuery    = "UPDATE `{$TABLE_PREFIX}" .accountsTable(). "`
                        SET `password` = CONCAT('$prefix', SHA1(CONCAT(`password`, '$salt')))
                      WHERE `password` NOT LIKE '$prefix%' AND LENGTH(`password`) != $expectedLength";
  mysql_query($updateQuery) or die("MySQL Error: ". mysql_error(). "\n");
}


// Store user's username and passwordHash in persistent cookie in their browser.
// Usage: loginCookie_set($username, $passwordHash);
//    ... loginCookie_set($username, getPasswordDigest($plaintextPassword));
function loginCookie_set($username, $passwordHash) {

  // encode login data
  $loginData = array();
  $loginData['username']     = $username;
  $loginData['passwordHash'] = $passwordHash;
  $loginData['lastAccess']   = time();
  $loginData['randNumber']   = defined('IS_CMS_ADMIN') ? _getRandomNumberSeed() : ''; // only set for admin pages
  $encodedLoginData          = strrev(base64_encode(json_encode($loginData)));

  // set login cookie
  setPrefixedCookie(loginCookie_name(), $encodedLoginData, 2146176000);  // save cookie until 2038, expiry is enforced by settings and loginCookie_get()
}

// Load login cookie from users browser.  Note, if login has "expired" then
// ... $sessionExpired will be true and username and passwordHash will be blank.
// Usage: list($sessionExpired, $username, $passwordHash) = loginCookie_get();
function loginCookie_get() {

  // get login data
  $loginData              = array();
  $cookieLoginDataEncoded = getPrefixedCookie( loginCookie_name() );

  // Flash Cookie Bug Fix - Flash sometimes sends no cookies (or cookies from IE when you're using Firefox).
  // ... So we fake it by passing the loginCookie via a POST request. Security: Use POST instead of GET so
  // ... sessions can't be force-created or hijacked with GET urls (and so login data won't get stored in server logs)
  $loginDataEncoded = isFlashUploader() ? @$_POST['_FLASH_COOKIE_BUG_FIX_'] : $cookieLoginDataEncoded;
  
  if ($loginDataEncoded) { $loginData = json_decode(base64_decode(strrev($loginDataEncoded)), true); }

  // check if session has expired
  $sessionExpired = false;
  if ($loginData) {
    // get session expiry in seconds
    $maxSeconds = loginExpirySeconds();

    // clear login username and passwordHash if login_expiry_limit exceeded, and set $hasExpired
    $secondsAgo = time() - $loginData['lastAccess'];
    if ($loginData['lastAccess'] && $secondsAgo > $maxSeconds) {
      $loginData['username']     = '';
      $loginData['passwordHash'] = '';
      $sessionExpired = true;
      loginCookie_remove();
    }
  }

  //
  $username     = $sessionExpired ? '' : (isset($loginData['username']) ? $loginData['username'] : '');
  $passwordHash = $sessionExpired ? '' : (isset($loginData['passwordHash']) ? $loginData['passwordHash'] : '');
  return array($sessionExpired, $username, $passwordHash);
}

//
function loginCookie_remove() {
  removePrefixedCookie( loginCookie_name() );
}

// loginCookie_name()
// to get current encoded login data: $_COOKIE[ loginCookie_name(true) ];
function loginCookie_name($addCookiePrefix = false) {
  $cookieName = 'loginsession';
  if ($addCookiePrefix) { $cookieName = cookiePrefix() . $cookieName; }
  return $cookieName;
}

//
function loginExpirySeconds() {
  // get session expiry in seconds
  $limit      = $GLOBALS['SETTINGS']['advanced']['login_expiry_limit'];
  $unit       = $GLOBALS['SETTINGS']['advanced']['login_expiry_unit'];
  if     ($unit == 'seconds') { $maxSeconds = $limit; }
  elseif ($unit == 'minutes') { $maxSeconds = $limit * 60; }
  elseif ($unit == 'hours')   { $maxSeconds = $limit * 60*60; }
  elseif ($unit == 'days')    { $maxSeconds = $limit * 60*60*24; }
  elseif ($unit == 'months')  { $maxSeconds = $limit * 60*60*24*30.4368; } // average days in month
  else                        { die(__FUNCTION__. ": No login expiry limits defined!"); }

  return $maxSeconds;
}

//eof
