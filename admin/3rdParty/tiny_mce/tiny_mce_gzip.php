<?php
/**
 * tiny_mce_gzip.php
 *
 * Copyright 2010, Moxiecode Systems AB
 * Released under LGPL License.
 *
 * License: http://tinymce.moxiecode.com/license
 * Contributing: http://tinymce.moxiecode.com/contributing
 */

// set this to true if the WYSIWYG isn't appearing
$GLOBALS['TINYMCE_DISABLE_COMPRESSION'] = false; 

 
// START MODIFICATIONS
// ----------------------------------------------------------------------------
//
// - Changed cache_dir to be ../../data/
//
// - added modify times of all included scripts ($allFilesModifiedTimes) to md5() so that /data/ cache file gets updated when sources change
//
// - prefixed 'tiny_mce_cache.' to cache file name for transparency
//
// - Copy some compatability functions from cms: 
if (!function_exists('jsEncode')) { 
  function jsEncode($str) {
      return addcslashes($str,"\\\'\"&\n\r<>");
  }
}
  
  // just like htmlspec ialchars() but encodes ' as well and doesn't double encode <br /> (to make encoding textboxes with auto-formatting easy)

if (!function_exists('htmlencode')) { 
  function htmlencode($string, $encodeBr = false) { // added in v2.15
    $encoded = call_user_func_array('htmlspe'.'cialchars', array($string, ENT_QUOTES, 'UTF-8')); // encode & " ' < > and use call_user_func_array to bypass invalid keywords scanner in script builder
    if (!$encodeBr) {
      $encoded = preg_replace("|&lt;br\s*/?&gt;|i", "<br />", $encoded); // don't double encode <br/> tags (to make encoding textboxes with auto-formatting easy)
    }
    return $encoded;
  }
}
//
// - NOTE: We're loading tinymce with the direct method here: http://www.tinymce.com/wiki.php/Compressors:PHP
// ----------------------------------------------------------------------------
  function TinyMCE_Compressor_renderTag($options) { TinyMCE_Compressor::renderTag($options); } // alias function for old PHP4 support (used in old wysiwyg_custom.php files) // v2.51
// END MODIFICATIONS

// Handle incoming request if it's a script call
if (TinyMCE_Compressor::getParam("js")) {

  // Check for accidentally added whitespace or other output (by end users) - extra linebreaks at the end of library or plugin files
  // ... can cause ajax calls to fail (whitespace is interpreted as error message and returned in 'blank' popups) or gzip output to
  // ... become corrupted. Note that server behaviour will vary based on output_buffering another other settings (search "output" in phpinfo)
  if (headers_sent($headerSentFile, $headersSentLine)) {  // check if output was sent anyways (such as if it exceeded output_buffer bytes)
    $error  = "WYSIWYG Error: Unexpected output was sent by the following file:\n";
    $error .= htmlencode(@$headerSentFile). " (on line " . htmlencode(@$headersSentLine). ").\n";
    $error .= "Developers: Check for accidentally added whitespace or other characters.\n";
    $error  = "alert('" .jsencode($error). "');\n";
    die($error);
  }

  // Turn off any existing compression or buffering set by the web server configuration (we do compression manually below)
  ini_set('zlib.output_compression', 0);    // disable compression headers
  while (@ob_end_clean()); // disable any and all output buffers of anything added by init.php, plugins, or libraries, etc (We're not expecting anything here)

  // Default settings
  $tinyMCECompressor = new TinyMCE_Compressor(array(
  /*
   * Add any site-specific defaults here that you may wish to implement. For example:
   *
   *   "languages" => "en",
   *  "cache_dir" => realpath(dirname(__FILE__) . "/../../_cache"),
   *  "files"     => "somescript,anotherscript",
   *  "expires"   => "1m",
   */
  ));

  // Handle request, compress and stream to client
  $tinyMCECompressor->handleRequest();
}

/**
 * This class combines and compresses the TinyMCE core, plugins, themes and
 * language packs into one disk cached gzipped request. It improves the loading speed of TinyMCE dramatically but
 * still provides dynamic initialization.
 *
 * Example of direct usage:
 * require_once("../jscripts/tiny_mce/tiny_mce_gzip.php");
 *
 * // Renders script tag with compressed scripts
 * TinyMCE_Compressor::renderTag(array(
 *    "url" => "../jscripts/tiny_mce/tiny_mce_gzip.php",
 *    "plugins" => "pagebreak,style",
 *    "themes" => "advanced",
 *    "languages" => "en"
 * ));
 */
class TinyMCE_Compressor {
	private $files, $settings;
	private static $defaultSettings = array(
    "plugins"    => "",
    "themes"     => "",
    "languages"  => "",
    "disk_cache" => true,
    "expires"    => "30d",
    "cache_dir"  => '', // set below in __construct
    "compress"   => '', // set below in __construct
    "suffix"     => "",
    "files"      => "",
    "source"     => false,
	);

  /**
   * Constructs a new compressor instance.
   *
   * @param Array $settings Name/value array with non-default settings for the compressor instance.
   */
	public function __construct($settings = array()) {
    self::$defaultSettings['cache_dir'] = realpath(dirname(__FILE__) . "/../../data/");
    self::$defaultSettings['compress']  = array_key_exists('compress', $_GET) ? $_GET['compress'] : true;
    if ($GLOBALS['TINYMCE_DISABLE_COMPRESSION']) { self::$defaultSettings['compress'] = false; } 

    $this->settings = array_merge(self::$defaultSettings, $settings);

    if (empty($this->settings["cache_dir"]))
      $this->settings["cache_dir"] = dirname(__FILE__);
  }

  /**
   * Adds a file to the concatenation/compression process.
   *
   * @param String $path Path to the file to include in the compressed package/output.
   */
	public function &addFile($file) {
    $this->files .= ($this->files ? "," : "") . $file;

    return $this;
  }

  /**
   * Handles the incoming HTTP request and sends back a compressed script depending on settings and client support.
   */
	public function handleRequest() {
    $files = array();
    $supportsGzip = false;
    $expiresOffset = $this->parseTime($this->settings["expires"]);
    $tinymceDir = dirname(__FILE__);

    // Override settings with querystring params
		$plugins = self::getParam("plugins");
    if ($plugins)
      $this->settings["plugins"] = $plugins;
    $plugins = explode(',', $this->settings["plugins"]);

		$themes = self::getParam("themes");
    if ($themes)
      $this->settings["themes"] = $themes;
    $themes = explode(',', $this->settings["themes"]);

		$languages = self::getParam("languages");
    if ($languages)
      $this->settings["languages"] = $languages;
    $languages = explode(',', $this->settings["languages"]);

		$tagFiles = self::getParam("files");
    if ($tagFiles)
      $this->settings["files"] = $tagFiles;

		$diskCache = self::getParam("diskcache");
    if ($diskCache)
      $this->settings["disk_cache"] = ($diskCache === "true");

		$src = self::getParam("src");
    if ($src)
      $this->settings["source"] = ($src === "true");

    // Add core
    $files[] = "tiny_mce";
    foreach ($languages as $language)
      $files[] = "langs/$language";

    // Add plugins
    foreach ($plugins as $plugin) {
      $files[] = "plugins/$plugin/editor_plugin";

      foreach ($languages as $language)
        $files[] = "plugins/$plugin/langs/$language";
    }

    // Add themes
    foreach ($themes as $theme) {
      $files[] = "themes/$theme/editor_template";

      foreach ($languages as $language)
        $files[] = "themes/$theme/langs/$language";
    }

    // Add any specified files.
    $allFiles = array_merge($files, explode(',', $this->settings['files']));

    // Also hash file dates
    $allFilesModifiedTimes = '';

    // Process source files
    for ($i = 0; $i < count($allFiles); $i++) {
      $file = $allFiles[$i];

      if ($this->settings["source"] && file_exists($file . "_src.js")) {
        $file .= "_src.js";
      } else if (file_exists(dirname(__FILE__). "/$file.js"))  {
        $file .= ".js";
      } else {
        $file = "";
      }

      if ($file) {
        $allFilesModifiedTimes .= ',' . filemtime(dirname(__FILE__)."/$file");
      }

      $allFiles[$i] = $file;
    }

    // Generate hash for all files
    $hash = md5(implode('', $allFiles) . $allFilesModifiedTimes . $tinymceDir);

    // Check if it supports gzip
    $zlibOn = ini_get('zlib.output_compression') || (ini_set('zlib.output_compression', 0) === false);
    $encodings = (isset($_SERVER['HTTP_ACCEPT_ENCODING'])) ? strtolower($_SERVER['HTTP_ACCEPT_ENCODING']) : "";
    $encoding = preg_match( '/\b(x-gzip|gzip)\b/', $encodings, $match) ? $match[1] : "";

    // Is northon antivirus header
    if (isset($_SERVER['---------------']))
      $encoding = "x-gzip";

    $supportsGzip = $this->settings['compress'] && !empty($encoding) && !$zlibOn && function_exists('gzencode')
                    && @gzencode('test'); // test gzencode works (any usage returns 'stream error' on some [misconfigured?] servers)

    // Set cache file name
    $cacheFile = $this->settings["cache_dir"] . "/tiny_mce_cache." . $hash . ($supportsGzip ? ".gz" : ".js");

     // Set headers
    header("Content-type: text/javascript");
    header("Vary: Accept-Encoding");  // Handle proxies
    header("Expires: " . gmdate("D, d M Y H:i:s", time() + $expiresOffset) . " GMT");
    header("Cache-Control: public, max-age=" . $expiresOffset);

    if ($supportsGzip)
      header("Content-Encoding: " . $encoding);

    // Use cached file
    if ($this->settings['disk_cache'] && file_exists($cacheFile)) {
      readfile($cacheFile);
      return;
    }

    // Set base URL for where tinymce is loaded from
    $buffer = "var tinyMCEPreInit={base:'" . dirname($_SERVER["SCRIPT_NAME"]) . "',suffix:''};";

    // Load all tinymce script files into buffer
    foreach ($allFiles as $file) {
      if ($file) {
        $fileContents = $this->getFileContents($tinymceDir . "/" . $file);
        $buffer .= "// $file\n$fileContents\n\n";
      }
    }

    // Mark all themes, plugins and languages as done
    $buffer .= 'tinymce.each("' . implode(',', $files) . '".split(","),function(f){tinymce.ScriptLoader.markDone(tinyMCE.baseURL+"/"+f+".js");});';

    // Compress data
    if ($supportsGzip)
      $buffer = gzencode($buffer, 9, FORCE_GZIP);

    // Write cached file
    if ($this->settings["disk_cache"]) {
//      die("DEBUG: Write to cache '$cacheFile'!");
      @file_put_contents($cacheFile, $buffer);
    }

    // Stream contents to client
    echo $buffer;
  }


/**
 * Renders a script tag that loads the TinyMCE script.
 *
 * @param Array $settings Name/value array with settings for the script tag.
 * @param Bool  $return   The script tag is return instead of being output if true
 * @return String the tag is returned if $return is true
 */
public static function renderTag($tagSettings, $return = false) {
  $settings = array_merge(self::$defaultSettings, $tagSettings);
  
  if (empty($settings["cache_dir"]))
    $settings["cache_dir"] = dirname(__FILE__);

  $scriptSrc = $settings["url"] . "?js=1";

  // Add plugins
  if (isset($settings["plugins"]))
    $scriptSrc .= "&plugins=" . (is_array($settings["plugins"]) ? implode(',', $settings["plugins"]) : $settings["plugins"]);

  // Add themes
  if (isset($settings["themes"]))
    $scriptSrc .= "&themes=" . (is_array($settings["themes"]) ? implode(',', $settings["themes"]) : $settings["themes"]);

  // Add languages
  if (isset($settings["languages"]))
    $scriptSrc .= "&languages=" . (is_array($settings["languages"]) ? implode(',', $settings["languages"]) : $settings["languages"]);

  // Add disk_cache
  if (isset($settings["disk_cache"]))
    $scriptSrc .= "&diskcache=" . ($settings["disk_cache"] === true ? "true" : "false");

  // Add any explicitly specified files if the default settings have been overriden by the tag ones
  /*
   * Specifying tag files will override (rather than merge with) any site-specific ones set in the
   * TinyMCE_Compressor object creation.  Note that since the parameter parser limits content to alphanumeric
   * only base filenames can be specified.  The file extension is assumed to be ".js" and the directory is
   * the TinyMCE root directory.  A typical use of this is to include a script which initiates the TinyMCE object.
   */
  if (isset($tagSettings["files"]))
    $scriptSrc .= "&files=" .(is_array($settings["files"]) ? implode(',', $settings["files"]) : $settings["files"]);

  // Add src flag
  if (isset($settings["source"]))
    $scriptSrc .= "&src=" . ($settings["source"] === true ? "true" : "false");

  $scriptTag = '<script type="text/javascript" src="' . htmlspecialchars($scriptSrc) . '"></script>';

  if ($return) {
    return $scriptTag;
  } else {
    echo $scriptTag;
  }
}

/**
 * Returns a sanitized query string parameter.
 *
 * @param String $name Name of the query string param to get.
 * @param String $default Default value if the query string item shouldn't exist.
 * @return String Sanitized query string parameter value.
 */
	public static function getParam($name, $default = "") {
  if (!isset($_GET[$name]))
    return $default;

  return preg_replace("/[^0-9a-z\-_,]+/i", "", $_GET[$name]); // Sanatize for security, remove anything but 0-9,a-z,-_,
}


  /**
   * Parses the specified time format into seconds. Supports formats like 10h, 10d, 10m.
   *
   * @param String $time Time format to convert into seconds.
   * @return Int Number of seconds for the specified format.
   */
	private function parseTime($time) {
    $multipel = 1;

    // Hours
    if (strpos($time, "h") > 0)
      $multipel = 3600;

    // Days
    if (strpos($time, "d") > 0)
      $multipel = 86400;

    // Months
    if (strpos($time, "m") > 0)
      $multipel = 2592000;

    // Trim string
    return intval($time) * $multipel;
  }

  /**
   * Returns the contents of the script file if it exists and removes the UTF-8 BOM header if it exists.
   *
   * @param String $file File to load.
   * @return String File contents or empty string if it doesn't exist.
   */
	private function getFileContents($file) {
    $content = file_get_contents($file);

    // Remove UTF-8 BOM
    if (substr($content, 0, 3) === pack("CCC", 0xef, 0xbb, 0xbf))
      $content = substr($content, 3);

    return $content;
  }
}

//eof