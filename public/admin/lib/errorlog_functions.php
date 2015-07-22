<?php
/*
  NOTES:
    - You can manually create an error log entry with this code and the error will be
      ... NOT be displayed to end user and code execution won't be interrupted:
    
      @trigger_error("Your error message", E_USER_NOTICE);
    
    - This is a good way to capture a snapshot of the global vars and symbol table.
    
    - We can't/don't catch E_PARSE compile time errors that are returned by the parser.
    - List of error types: http://php.net/manual/en/errorfunc.constants.php
*/


// enable error logging
errorlog_enable();

// enable error logging - log error to internal mysql table
function errorlog_enable() {
  
  // error-checking
  if (error_reporting() !== -1) { die(__FUNCTION__ . ": error_reporting() must be set to -1, not " .error_reporting(). "!"); }
   
  // setup handlers
  set_error_handler('_errorlog_catchRuntimeErrors');  
  set_exception_handler('_errorlog_catchUncaughtExceptions');
  register_shutdown_function('_errorlog_catchFatalErrors');
}

// catch runtime errors - called by set_error_handler() above
// argument definitions: http://php.net/manual/en/function.set-error-handler.php
function _errorlog_catchRuntimeErrors($errno, $errstr, $errfile, $errline, $errcontext) {  
  _errorlog_alreadySeenError($errfile, $errline); // track that this error was seen so we don't report it again in _errorlog_catchFatalErrors()
  $is_E_USER_TYPE = in_array($errno, array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE, 16384));  // E_USER_* errors are called explicitly, so we'll assume if they use @error-suppression they still want to be logged - 16384 = E_USER_DEPRECATED as of PHP v5.3.0
  if (error_reporting() === 0 && !$is_E_USER_TYPE) {  // ignore '@' error control operator except for E_USER_
    return false;  // continue standard PHP execution (includes: error handling and set $php_errormsg)
  } 

  $logType = 'runtime'; 
  $logData = array(
    'logType'     => 'runtime',
    'errno'       => $errno,
    'errstr'      => $errstr,
    'errfile'     => $errfile,
    'errline'     => $errline,
    'errcontext'  => $errcontext,
  );
  _errorlog_logErrorRecord($logType, $logData);

  //
  return false; // return false to continue with standard PHP error handling and set $php_errormsg - NOTE: @suppressed errors are still suppressed
}


// catch fatal errors - called by register_shutdown_function() above
function _errorlog_catchFatalErrors() {
  $error = error_get_last();
  if ($error === null) { return; } // no error
  if (_errorlog_alreadySeenError($error['file'], $error['line'])) { return; } // error already processed (or ignored for @hidden warnings)

  $logType = 'fatal'; 
  $logData = array(
    'logType'     => 'fatal',
    'errno'       => $error['type'],     // eg: 8   - from: http://php.net/manual/en/errorfunc.constants.php
    'errstr'      => $error['message'],  // eg: Undefined variable: a
    'errfile'     => $error['file'],     // eg: C:\WWW\index.php
    'errline'     => $error['line'],     // eg: 2
  );
  _errorlog_logErrorRecord($logType, $logData);
    
  // halt script execution
  exit;
}


// catch uncaught exceptions - called by set_error_handler() above
function _errorlog_catchUncaughtExceptions($exceptionObj) {
  $logType = 'exception'; 
  $logData = (array) $exceptionObj; // http://php.net/manual/en/class.exception.php
  
  $logData = array(
    'logType'     => 'exception',
    'errno'       => 'UNCAUGHT_EXCEPTION',       
    'errstr'      => $exceptionObj->getMessage(),  // method reference: http://php.net/manual/en/language.exceptions.extending.php
    'errfile'     => $exceptionObj->getFile(),
    'errline'     => $exceptionObj->getLine(),
    'exceptionObj' => (array) $exceptionObj,
  );
  _errorlog_logErrorRecord($logType, $logData);
  
  // PHP will not continue or show any errors if we're catching exceptions, so show errors ourselves if it's enabled:
  if (ini_get('display_errors')) { 
    $error  = "Fatal Error: Uncaught exception '".get_class($exceptionObj)."'";
    $error .= " with message '".$exceptionObj->getMessage()."'";
    $error .= " in ".$exceptionObj->getFile(). " on line " .$exceptionObj->getLine();
    print $error;
  }
  
  // halt script execution after uncaught exceptions
  exit;
}

// return true if error matches the last one processed
// Background: Code that supresses errors with @ still causes set_error_handler() to be called, but we can
// ... detect that scenario by checking if error_reporting() === 0, but when catching fatal errors with
// ... register_shutdown_function() error_reporting() can't be used to detect previous use of @, so we check
// ... errors reported there were previously seen (and ignored) by _errorlog_catchRuntimeErrors().
function _errorlog_alreadySeenError($filePath, $lineNum) {
  static $lastErrorString = ''; 
  $thisErrorString        = "$filePath:$lineNum";
  $alreadySeenError       = ($thisErrorString == $lastErrorString);
  
  // debug
  // print "AlreadySeenError: $alreadySeenError, ($thisErrorString == $lastErrorString)<br/>\n";
  
  // update last seen
  $lastErrorString        = $thisErrorString;  // update last seen error - do this last
  
  //
  return $alreadySeenError;
}


// log errors
// max errors in log: 1000 (oldest records are removed when record count hits 1100)
// max errors to log per page: 25 (further errors won't be logged)
function _errorlog_logErrorRecord($logType, $logData) {

  // limit errors logged per session (to prevent infinite loops from logging infinite errors)
  $maxErrorsPerPage = 25;
  $maxErrorsReached = false;
  static $totalErrorsLogged = 0;
  $totalErrorsLogged++;
  if ($totalErrorsLogged > ($maxErrorsPerPage+1)) { return; } // ignore any errors after max error limit
  if ($totalErrorsLogged > $maxErrorsPerPage) { $maxErrorsReached = true; }
  
  // get summary of CMS user data
  $CMS_USER = getCurrentUserFromCMS();
  $subsetFields = array();
  foreach (array('num','username') as $field) {
    if (isset($CMS_USER[$field])) { $subsetFields[$field] = $CMS_USER[$field]; }
  }
  $subsetFields['_tableName'] = 'accounts'; 
  $cms_user_summary = print_r($subsetFields, true);
  
  // get summary of WEB user data  
  $WEB_USER = getCurrentUser();
  $subsetFields = array();
  foreach (array('num','username') as $field) {
    if (isset($WEB_USER[$field])) { $subsetFields[$field] = $WEB_USER[$field]; }
  }
  $subsetFields['_tableName'] = accountsTable(); 
  $web_user_summary = print_r($subsetFields, true);
    
  // create error message
  if ($maxErrorsReached)        { $errorMessage = t(sprintf("Max error limit reached! Only the first %s errors per page will be logged.", $maxErrorsPerPage)); }
  else { 
    if (isset($logData['errno'])) { $errorName = _errorLog_erronoToConstantName($logData['errno']); } // eg: E_WARNING
    else                          { $errorName = 'UNKNOWN_ERROR'; }
    $errorMessage = "$errorName: " . (isset($logData['errstr']) ? $logData['errstr'] : '');
  }

  
  // create $logDataSummary without 
  $logDataSummary = $logData;
  if (array_key_exists('errcontext', $logData)) {
    $logDataSummary['errcontext'] = "*** in symbol table field above ***";
  }
  
  //  create log record data
  $colsToValues = array(
    'dateLogged='      => 'NOW()',
    'updatedDate='     => 'NOW()',  // set this so we can detect if users modify error log records from within the CMS
    'updatedByuserNum' => '0',      // set this so we can detect if users modify error log records from within the CMS
    
    'error'           => $errorMessage,
    'url'             => thisPageUrl(),
    'filepath'        => isset($logData['errfile']) ? $logData['errfile'] : '', // $logData['errfile'],
    'line_num'        => isset($logData['errline']) ? $logData['errline'] : '', // $logData['errline'],
    'user_cms'        => isset($CMS_USER['num']) ? $cms_user_summary : '',
    'user_web'        => isset($WEB_USER['num']) ? $web_user_summary : '',
    'http_user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '', // $_SERVER['HTTP_USER_AGENT'],
    'remote_addr'     => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '',
    
    'request_vars'    => print_r($_REQUEST, true),
    'get_vars'        => print_r($_GET, true),
    'post_vars'       => print_r($_POST, true),
    'cookie_vars'     => print_r($_COOKIE, true),
    'session_vars'    => isset($_SESSION) ? print_r($_SESSION, true)  : '',
    'server_vars'     => print_r($_SERVER, true),

    'symbol_table'    => isset($logData['errcontext']) ? print_r($logData['errcontext'], true) : '', // var_export can't handle recursions and 'errcontext' sometimes lists $GLOBAL which lists $GLOBAL and so on.
    'raw_log_data'    => print_r($logDataSummary, true),
    
    'email_sent'      => 0,
  );
  
  // insert record
  $newRecordNum = mysql_insert('_error_log', utf8_force($colsToValues, true));
  
  // remove old log records
  $maxRecords = 900;
  $buffer     = 100; // only erase records when we're this many over (to avoid erasing records every time)
  if (mysql_count('_error_log') > ($maxRecords + $buffer)) {
    $oldestRecordToSave_query = "SELECT * FROM `{$GLOBALS['TABLE_PREFIX']}_error_log` ORDER BY `num` DESC LIMIT 1 OFFSET " .($maxRecords-1);
    $oldestRecordToSave = mysql_get_query($oldestRecordToSave_query);
    if (!empty($oldestRecordToSave['num'])) {
      mysql_delete('_error_log', null, "num < {$oldestRecordToSave['num']}"); 
    }
  }
  
  // send email update
  if ($GLOBALS['SETTINGS']['advanced']['phpEmailErrors']) { 
    register_shutdown_function('_errorlog_sendEmailAlert');
  }

}

//
// list of constants: // http://php.net/manual/en/errorfunc.constants.php
function _errorLog_erronoToConstantName($errno) {
 
  static $numsToNames;
  
  // create index of nums to names
  if (!$numsToNames) {
    foreach (get_defined_constants() as $name => $num) {  
      if (preg_match("/^E_/", $name)) { $numsToNames[$num] = $name; }
    }
  }
  
  //
  if (array_key_exists($errno, $numsToNames)) { return $numsToNames[$errno]; }
  else                                        { return $errno; }
}

// Send an email after the script has finished executing
// register this function to run with: register_shutdown_function('_errorlog_sendEmailAlert');
function _errorlog_sendEmailAlert() {
  if (!$GLOBALS['SETTINGS']['advanced']['phpEmailErrors']) { return; } 
  
  // once run function once per page-view
  static $alreadySent = false;
  if ($alreadySent) { return; }
  $alreadySent = true;
  
  // check if email sent in last hour
  $sentInLastHour = mysql_count('_error_log', " `dateLogged` > (NOW() - INTERVAL 1 HOUR) AND email_sent = 1");

  // send hourly alert
  if (!$sentInLastHour) { 
  
    // send email
    $secondsAgo = time() - $GLOBALS['SETTINGS']['bgtasks_lastEmail'];
    if ($secondsAgo >= (60*60)) { // don't email more than once an hour

      // get date format
      if     ($GLOBALS['SETTINGS']['dateFormat'] == 'dmy') { $dateFormat  = "jS M, Y - h:i:s A"; }
      elseif ($GLOBALS['SETTINGS']['dateFormat'] == 'mdy') { $dateFormat  = "M jS, Y - h:i:s A"; }
      else                                                 { $dateFormat  = "M jS, Y - h:i:s A"; }
    
      // load latest error list
      $latestErrors     = mysql_select('_error_log', "`dateLogged` > (NOW() - INTERVAL 1 HOUR) ORDER BY `dateLogged` DESC LIMIT 25");
      $latestErrorsList = ''; 
      foreach ($latestErrors as $thisError) {
        $latestErrorsList .= date($dateFormat, strtotime($thisError['dateLogged']))."\n";
        $latestErrorsList .= $thisError['error']."\n";
        $latestErrorsList .= $thisError['filepath']." (line ".$thisError['line_num'].")\n";
        $latestErrorsList .= $thisError['url']."\n\n";
      }
  
      // set email_sent flag for ALL records
      mysql_update('_error_log', null, 'TRUE', array('email_sent' => 1));
    
      // send email message
      $placeholders = array(
        'error.hostname'         => parse_url($GLOBALS['SETTINGS']['adminUrl'], PHP_URL_HOST),
        'error.latestErrorsList' => nl2br(htmlencode($latestErrorsList)),
        'error.errorLogUrl'      => realUrl("?menu=_error_log", $GLOBALS['SETTINGS']['adminUrl']),
      );
      $errors  = sendMessage(emailTemplate_loadFromDB(array(
        'template_id'  => 'CMS-ERRORLOG-ALERT',
        'placeholders' => $placeholders,
      )));
      
      // log/display email sending errors
      if ($errors) {
        trigger_error("Unable to send error notification email from " .__FUNCTION__ . ": $errors", E_USER_NOTICE);
        die(__FUNCTION__. ": $errors"); 
      }
      
    }
  }
  
}

//eof