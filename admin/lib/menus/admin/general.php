<?php

// calculate disk space
$thisDir    = dirname(__FILE__);
$totalBytes = @disk_total_space($thisDir);
$freeBytes  = @disk_free_space($thisDir);

// get ulimit limits
list($maxCpuSeconds, $memoryLimitKbytes, $maxProcessLimit, $ulimitOutput) = getUlimitValues('soft');
if     ($maxCpuSeconds == '')          { $maxCpuSeconds_formatted = t('none'); }
elseif ($maxCpuSeconds == 'unlimited') { $maxCpuSeconds_formatted = t('unlimited'); }
else                                   { $maxCpuSeconds_formatted = "$maxCpuSeconds " . t('seconds'); }
if     ($memoryLimitKbytes == '')          { $memoryLimit_formatted = t('none'); }
elseif ($memoryLimitKbytes == 'unlimited') { $memoryLimit_formatted = t('unlimited'); }
else                                       { $memoryLimit_formatted = formatBytes($memoryLimitKbytes*1024); }
$ulimitLink = "?menu=admin&amp;action=ulimit"; 
  
  // Show Upcoming Version Warning
  $currentPhpVersion   = phpversion();
  $currentMySqlVersion = preg_replace("/[^0-9\.]/", '', mysql_get_server_info());
 
  if     (time() > strtotime('2016-06-20')) { $nextPhpRequired = '5.6'; } // PHP 5.5 Security Support ends on 20 Jun 2016: http://php.net/supported-versions.php 
  elseif (time() > strtotime('2015-09-14')) { $nextPhpRequired = '5.5'; } // PHP 5.4 Security Support ends on 14 Sep 2015: http://php.net/supported-versions.php 
  else                                      { $nextPhpRequired = '5.4'; } // Default to minimum version required, PHP v5.4

  $nextMySqlRequired   = '5.5'; // to support utf8mb4 : http://dev.mysql.com/doc/refman/5.5/en/charset-unicode-utf8mb4.html
  $isPhpUnsupported    = version_compare($currentPhpVersion, $nextPhpRequired) < 0;
  $isMySqlUnsupported  = version_compare($currentMySqlVersion, $nextMySqlRequired) < 0;
  
  if ($isPhpUnsupported || $isMySqlUnsupported) {
    ?>
    <div style='color: #C00; border: solid 2px #C00; padding: 8px; background: #FFF; font-size: 14px; line-height: 1.3'>
      <b>Security Notice:</b>
      You are currently running old and unsupported server software that <b>no longer receives security updates</b>. 
      To avoid being exposed to unpatched security vulnerabilities and to ensure compatibility with future CMS releases, please upgrade at your earliest convenience.<br/>
      
      <div style="padding: 5px 5px 5px 25px;">
        <?php if ($isPhpUnsupported): ?>
          <li>Upgrade to <b>PHP v<?php echo $nextPhpRequired ?></b> or newer (Your server is running PHP v<?php echo $currentPhpVersion ?>)
        <?php endif ?>
        <?php if ($isMySqlUnsupported): ?>
          <li>Upgrade to <b>MySQL v<?php echo $nextMySqlRequired ?></b> or newer (Your server is running MySQL v<?php echo $currentMySqlVersion ?>)
        <?php endif ?>        
      </div>
      More information:
      <a href="http://php.net/supported-versions.php" target="_blank">PHP Supported Versions</a>,
      <a href="http://en.wikipedia.org/wiki/MySQL#Versions" target="_blank">MySQL Supported Versions</a>      
    </div><br/>
    <?php
  }

              
?>

<form method="post" action="?" autocomplete="off">
<input type="hidden" name="menu" value="admin" />
<input type="hidden" name="_defaultAction" value="adminSave" />
<?php echo security_getHiddenCsrfTokenField(); ?>

<div class="content-box">

  <div class="content-box-header">
    <div style="float:right;">
      <input class="button" type="submit" name="action=adminSave" value="<?php et('Save') ?>" />
      <input class="button" type="submit" name="action=general" value="<?php et('Cancel') ?>" />
    </div>

    <h3>
      <?php et('Admin') ?> &gt;
      <a href="?menu=admin&amp;action=general"><?php et('General Settings') ?></a>
    </h3>

    <div class="clear"></div>
  </div> <!-- End .content-box-header -->


  <div class="content-box-content">

    <table cellspacing="0" width="100%" class="bottomBorder">
      <tr>
        <td width="200"><?php et('Program Name / Titlebar');?> &nbsp;</td>
        <td><input class="text-input wide-input" type="text" name="programName" value="<?php echo htmlencode($SETTINGS['programName']) ?>" size="45" /></td>
      </tr>
      <tr>
        <td><?php et('Header Image URL');?> &nbsp;</td>
        <td><input class="text-input wide-input" type="text" name="headerImageUrl" value="<?php echo htmlencode($SETTINGS['headerImageUrl']) ?>" size="45" /></td>
      </tr>
      <tr>
        <td><?php et('Footer HTML');?> &nbsp;</td>
        <td><input class="text-input wide-input" type="text" name="footerHTML" value="<?php echo htmlencode($SETTINGS['footerHTML']) ?>" size="45" /></td>
      </tr>
      <tr>
        <td><?php et('Color / Theme');?> &nbsp;</td>
        <td>
          <?php $cssFiles = array('blue','green','red'); ?>
          <?php // load css files file names - do this here so errors are visible and not hidden in select tags
            $cssFiles     = array();
            $cssDir       = "{$GLOBALS['CMS_ASSETS_DIR']}/3rdParty/SimplaAdmin/css/";
            $excludeFiles = array('reset.css','style.css','invalid.css','ie.css');
            foreach (scandir($cssDir) as $filename) {
              if (!preg_match("/\.css$/", $filename)) { continue; }
              if (in_array($filename, $excludeFiles)) { continue; }
              $cssFiles[] = $filename;
            }
          ?>

          <select name="cssTheme">
          <option value=''>&lt;select&gt;</option>

          <?php foreach ($cssFiles as $filename): ?>
            <option value='<?php echo $filename ?>' <?php selectedIf($SETTINGS['cssTheme'], $filename); ?>><?php echo htmlencode($filename) ?></option>
          <?php endforeach ?>

          </select>
           &nbsp;<?php print sprintf(t('You can add CSS themes in %s'), basename(CMS_ASSETS_DIR) . '/3rdParty/SimplaAdmin/css/'); ?>
        </td>
      </tr>

      <tr><td colspan="2">&nbsp;</td></tr>

      <tr>
        <td width="200"><?php et('License Company Name');?> &nbsp;</td>
        <td><input class="text-input medium-input setAttr-spellcheck-false" type="text" name="licenseCompanyName" value="<?php echo htmlencode($SETTINGS['licenseCompanyName']) ?>" size="45" /></td>
      </tr>
      <tr>
        <td><?php et('License Domain Name');?> &nbsp;</td>
        <td><input class="text-input medium-input setAttr-spellcheck-false" type="text" name="licenseDomainName" value="<?php echo htmlencode($SETTINGS['licenseDomainName']) ?>" size="45" /></td>
      </tr>
      <tr>
        <td><?php et('License Product ID');?> &nbsp;</td>
        <td>
            <input class="text-input small-input setAttr-spellcheck-false" type="text" name="licenseProductId" size="23"
                   value="<?php echo inDemoMode() ? 'XXXX-XXXX-XXXX-XXXX' : htmlencode($SETTINGS['licenseProductId']) ?>"
                   style="<?php echo inDemoMode() ? 'color: #999999' : '' ?>" />
            &nbsp; <a href="?menu=license"><?php echo t('license agreement'); ?> &gt;&gt;</a>
        </td>
      </tr>

      <tr><td colspan="2">&nbsp;</td></tr>

      <tr>
        <td><?php et('Vendor');?> &nbsp;</td>
        <td>
          <a href="<?php echo $SETTINGS['vendorUrl'] ?>"><?php echo htmlencode($SETTINGS['vendorName']) ?></a>
          <?php if (allowSublicensing()): ?>&nbsp;(<a href="?menu=admin&amp;action=vendor">private label</a>)<?php endif ?>
        </td>
      </tr>
      <tr><td colspan="2">&nbsp;</td></tr>
      <tr>
        <td><?php et('Program Version'); ?> &nbsp;</td>
        <td><?php echo htmlencode($APP['version']) ?> (Build <?php echo htmlencode($APP['build']) ?>)</td>
      </tr>
      <tr>
        <td colspan='2'>
          <div class='content-box content-box-divider'>
            <div class='content-box-header'><h3><?php eht("Directories & URLs"); ?></h3></div>
          </div>
        </td>
      </tr>

      <tr>
        <td width="200"><?php et('Program Directory');?> &nbsp;</td>
        <td><input class="text-input wide-input" style="border: none;" readonly="readonly" type="text" name="null" value="<?php echo htmlencode($GLOBALS['PROGRAM_DIR']) ?>/" size="60" /></td>
      </tr>
      <tr>
        <td width="200"><?php et('Program Url');?> &nbsp;</td>
        <td>
          <input class="text-input wide-input" type="text" name="adminUrl" value="<?php echo htmlencode(@$SETTINGS['adminUrl']) ?>" size="60" />
        </td>
      </tr>
      <tr>
        <td width="200"><?php et('Website Root Directory');?> &nbsp;</td>
        <td><input class="text-input wide-input" type="text" name="webRootDir" value="<?php echo htmlencode(@$SETTINGS['webRootDir']) ?>" size="60" /></td>
      </tr>

      <tr><td colspan="2">&nbsp;</td></tr>
      <tr><td colspan="2">&nbsp;</td></tr>

      <tr>
        <td width="200"><?php et('Upload Directory');?> &nbsp;</td>
        <td>
          <input class="text-input wide-input" type="text" name="uploadDir" id="uploadDir" value="<?php echo htmlencode($SETTINGS['uploadDir']) ?>" size="60" onkeyup="updateUploadPathPreviews('dir', this.value, 0)" onchange="updateUploadPathPreviews('dir', this.value, 0)" />
          <div style="line-height: 1.3">
            <?php et('Preview:'); ?> <span id="uploadDirPreview"><?php echo htmlencode(getUploadPathPreview('dir', $SETTINGS['uploadDir'], false, false)); ?></span><br/>
            Example: uploads or ../uploads (relative to program directory)<br/>
          </div><br/>
        </td>
      </tr>
      <tr>
        <td><?php et('Upload Folder URL');?></td>
        <td>
          <input class="text-input wide-input" type="text" name="uploadUrl" id="uploadUrl" value="<?php echo htmlencode($SETTINGS['uploadUrl']) ?>" size="60"  onkeyup="updateUploadPathPreviews('url', this.value, 0)" onchange="updateUploadPathPreviews('url', this.value, 0)" />
          <div style="line-height: 1.3">
            <?php et('Preview:'); ?> <span id="uploadUrlPreview"><?php echo htmlencode(getUploadPathPreview('url', $SETTINGS['uploadUrl'], false, false)); ?></span><br/>
            Example: uploads or ../uploads (relative to current URL)<br/>
          </div><br/>
        </td>
      </tr>
      <tr>
        <td><?php et("Server Upload Settings"); ?></td>
        <td>
          <div id="serverUploadLimits" style="padding: 5px 0px;"><div style="border: solid 1px #999; padding: 10px; background-color: #EEE">

          <table width="100%">
            <tr>
              <td valign="top" style="padding: 0px 10px 0px 0px">
                <b><?php et("Upload settings"); ?></b><br/>
                <table cellspacing="0">           
                  <tr><td><a href="http://php.net/manual/en/ini.core.php#ini.file-uploads" target="_blank">file_uploads</a>: &nbsp;</td><td><?php echo ini_get('file_uploads') ? t('enabled') : t('disabled'); ?></td></tr>
                  <tr><td><a href="http://php.net/manual/en/ini.core.php#ini.max-file-uploads" target="_blank">max_file_uploads</a>: &nbsp;</td><td><?php echo ini_get('max_file_uploads') ?></td></tr>
                </table>
              </td>
              <td valign="top" style="padding: 0px 10px 0px 0px">
                <b><?php et("Upload time limits"); ?></b><br/>
                <table cellspacing="0">           
                  <tr><td><a href="http://php.net/manual/en/info.configuration.php#ini.max-input-time" target="_blank">max_input_time</a>: &nbsp;</td><td><?php echo ini_get('max_input_time') ?></td></tr>
                  <tr><td><a href="http://php.net/manual/en/info.configuration.php#ini.max-execution-time" target="_blank">max_execution_time</a>: &nbsp;</td><td><?php echo ini_get('max_execution_time') ?></td></tr>
                  <tr><td><a href="<?php echo $ulimitLink ?>" target="_blank">ulimit max cpu seconds</a>: &nbsp;</td><td><?php echo $maxCpuSeconds_formatted; ?></td></tr>
                </table>
              </td>
              <td rowspan="2" valign="top" style="padding: 0px 10px 0px 0px">
                <b><?php et("File size limits") ?></b><br/>
                <table cellspacing="0">           
                 <tr><td><a href="http://php.net/manual/en/function.disk-free-space.php" target="_blank">free disk space</a>: &nbsp;</td><td><?php echo $freeBytes ? formatBytes($freeBytes, 0) : t("Unavailable");  ?></td></tr>
                 <tr><td><a href="http://php.net/manual/en/ini.core.php#ini.post-max-size" target="_blank">post_max_size</a>: &nbsp;</td><td><?php echo ini_get('post_max_size') ?></td></tr>
                 <tr><td><a href="http://php.net/manual/en/ini.core.php#ini.upload-max-filesize" target="_blank">upload_max_filesize</a>: &nbsp;</td><td><?php echo ini_get('upload_max_filesize') ?></td></tr>
                 <tr><td><a href="http://php.net/manual/en/ini.core.php#ini.memory-limit" target="_blank">memory_limit</a>: &nbsp;</td><td><?php echo ini_get('memory_limit') ?></td></tr>
                  <tr><td><a href="<?php echo $ulimitLink ?>" target="_blank">ulimit memory limit</a>: &nbsp;</td><td><?php echo $memoryLimit_formatted; ?></td></tr>
                </table>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <a href="http://php.net/manual/en/ini.core.php#ini.upload-tmp-dir" target="_blank">upload_tmp_dir</a>: <span style="position: absolute; "><?php echo ini_get('upload_tmp_dir'); ?></span><br/><br/>
                <a href="http://www.php.net/manual/en/features.file-upload.php" target="_blank"><?php et('How to configure PHP uploads')?></a>
                (<?php et('for server admins')?>)<br/>
             <td>
            </tr>
          </table>

          </div></div>
        </td>
      </tr>

      <tr><td colspan="2">&nbsp;</td></tr>
      <tr><td colspan="2">&nbsp;</td></tr>



      <tr>
        <td width="200" id="websitePrefixUrl"><?php echo("Website Prefix URL (optional)"); ?></td>
        <td>
          <input class="text-input small-input" type="text" name="webPrefixUrl" value="<?php echo htmlencode($SETTINGS['webPrefixUrl']) ?>" size="60" />
          <?php eht("eg: /~username or /development/client-name"); ?><br/>
          If your development server uses a different URL prefix than your live server you can specify it here.
          This prefix will be automatically added to Viewer URLs and can be displayed with &lt;?php echo PREFIX_URL ?&gt; for other urls.
          This will allow you to easily move files between a development and live server, even if they have different URL prefixes.
        </td>
      </tr>

      <tr><td colspan="2">&nbsp;</td></tr>
      <tr><td colspan="2">&nbsp;</td></tr>

      <tr>
        <td width="200"><?php et('Help (?) URL') ?></td>
        <td><input class="text-input wide-input" type="text" name="helpUrl" value="<?php echo htmlencode($SETTINGS['helpUrl']) ?>" size="60" /></td>
      </tr>
      <tr>
        <td width="200"><?php et("'View Website' URL")?></td>
        <td><input class="text-input wide-input" type="text" name="websiteUrl" value="<?php echo htmlencode($SETTINGS['websiteUrl']) ?>" size="60" /></td>
      </tr>

      <tr>
        <td colspan='2'>
          <a name="email"></a>
          <div class='content-box content-box-divider'>
            <div class='content-box-header'><h3><?php eht("Email Settings"); ?></h3></div>
          </div>
        </td>
      </tr>

    <tr>
      <td width="200"><?php et('Admin Email') ?></td>
      <td><input class="text-input wide-input" type="text" name="adminEmail" value="<?php echo htmlencode(@$SETTINGS['adminEmail']) ?>" size="60" /></td>
    </tr>
    <tr>
      <td width="200">&nbsp;</td>
      <td>
        <?php et('This should be a valid email address that is checked for email.')?>
        <?php et('This email is used as the "From:" address on password reminder emails.')?>
      </td>
    </tr>


    <tr><td colspan="2">&nbsp;</td></tr>

    <tr>
      <td width="200"><?php et("Outgoing Mail"); ?></td>
      <td height="22">
        <?php $value = coalesce(@$SETTINGS['advanced']['outgoingMail'], 'sendOnly'); // set default ?>
        <label>
          <input type="radio" name="outgoingMail" value="sendOnly"   <?php checkedIf($value, 'sendOnly'); ?>   />
          <?php eht("Send Only - Send mail without keeping a copy (default)"); ?>
        </label><br/>
        <label>
          <input type="radio" name="outgoingMail" value="sendAndLog" <?php checkedIf($value, 'sendAndLog'); ?> />
          <?php printf(t("Send &amp; Log - Send mail and save copies under <a href='%s'>Outgoing Mail</a>"), "?menu=_outgoing_mail"); ?>
        </label><br/>
        <label>
          <input type="radio" name="outgoingMail" value="logOnly"    <?php checkedIf($value, 'logOnly'); ?>    />
          <?php eht("Log Only - Log messages but don't send them (debug mode)"); ?>
        </label><br/>
      </td>
    </tr>

    <tr><td colspan="2">&nbsp;</td></tr>

    <tr>
      <td><?php et('How to send mail');?> &nbsp;</td>
      <td>
        <?php
          $mathodNamesToLabels = array();
          $mathodNamesToLabels['php']       = t("Use PHP's built-in mail() function (default)");
          $mathodNamesToLabels['unsecured'] = t("SMTP Server - Unsecured connection");
          $mathodNamesToLabels['ssl']       = t("SMTP Server - Secured connection using SSL");
          $mathodNamesToLabels['tls']       = t("SMTP Server - Secured connection using TLS");
          $selectOptions = getSelectOptions(@$SETTINGS['advanced']['smtp_method'], array_keys($mathodNamesToLabels), array_values($mathodNamesToLabels), false);
        ?>
        <select name="smtp_method"><?php echo $selectOptions; ?></select>
      </td>
    </tr>

    <tr>
      <td><?php eht('SMTP Hostname & Port'); ?> &nbsp;</td>
      <td>
        <input class="text-input medium-input setAttr-spellcheck-false" style="width: 250px !important" type="text" name="smtp_hostname" value="<?php echo htmlencode(@$SETTINGS['advanced']['smtp_hostname']) ?>"  />
        &nbsp;:&nbsp;
        <input class="text-input small-input setAttr-spellcheck-false" style="width: 50px !important" maxlength="5" type="text" name="smtp_port" value="<?php echo htmlencode(@$SETTINGS['advanced']['smtp_port']) ?>"  />
        <?php et('Default:'); ?> <?php echo htmlencode(get_cfg_var('SMTP') .':'. get_cfg_var('smtp_port')); ?><br/>
      </td>
    </tr>
    <tr>
      <td><?php et('SMTP Username'); ?> &nbsp;</td>
      <td><input class="text-input medium-input setAttr-spellcheck-false" type="text" name="smtp_username" value="<?php echo htmlencode(@$SETTINGS['advanced']['smtp_username']) ?>"  /></td>
    </tr>
    <tr>
      <td><?php et('SMTP Password'); ?> &nbsp;</td>
      <td>
        <input class="text-input medium-input setAttr-spellcheck-false" type="text" name="smtp_password" value="<?php echo htmlencode(@$SETTINGS['advanced']['smtp_password']) ?>"  /><br/>
        Tip: To test mail settings send yourself an email with the <a href="?menu=forgotPassword">Password Reset</a> form.
      </td>
    </tr>

    <?php /* not yet implemented
    <tr>
      <td width="200">Bulk Mail Limits</td>
      <td style="line-height: 1.5em">
        If required by your server or host, you can limit on how fast mail is sent here.<br/>
        Note that these settings only apply to "bulk mail" messages such as newsletters, etc.<br/>

        <input type='text' name='pending' value='1' class='text-input' style='padding: 1px 6px; ma!rgin: 0px; width: 48px; text-align: center' size='5' maxlength='5' />
        Max messages to send per hour (leave blank for no limit)<br/>

        <input type='text' name='pending' value='1' class='text-input' style='padding: 1px 6px; m!argin: 0px; width: 48px; text-align: center' size='5' maxlength='5' />
        Seconds to wait between sending messages (leave blank for no delay)<br/>
      </td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    */ ?>


      <tr>
        <td colspan='2'>
          <div class='content-box content-box-divider'>
            <div class='content-box-header'><h3><?php eht("Regional Settings"); ?></h3></div>
          </div>
        </td>
      </tr>



    <tr>
      <td width="200"><?php et('Timezone Name') ?></td>
      <td>
        <?php $timeZoneOptions = getTimeZoneOptions($SETTINGS['timezone']); ?>
        <select name="timezone" id="timezone" onchange="updateDatePreviews();">
          <?php echo $timeZoneOptions; ?>
        </select>
      </td>
    </tr>

    <tr>
      <td><?php et('Local Time')?> &nbsp;</td>
      <td height="22">
        <span id="localDate"><?php
         $offsetSeconds = date("Z");
         $offsetString  = convertSecondsToTimezoneOffset($offsetSeconds);
         $localDate = date("D, M j, Y - g:i:s A") . " ($offsetString)";
         echo $localDate;

        ?></span>
      </td>
    </tr>
    <tr>
      <td><?php et('MySQL Time')?> &nbsp;</td>
      <td height="22">
        <span id="mysqlDate">
        <?php
          list($mySqlDate, $mySqlOffset) = mysql_get_query("SELECT NOW(), @@session.time_zone", true);
          echo date("D, M j, Y - g:i:s A", strtotime($mySqlDate)) . " ($mySqlOffset)";
        ?>
        </span>
      </td>
    </tr>

    <tr><td colspan="2">&nbsp;</td></tr>
    <?php if (!@$SETTINGS['advanced']['hideLanguageSettings']): ?>
    <tr>
      <td><?php et('Program Language') ?>&nbsp;</td>
      <td>
        <?php // load language file names - do this here so errors are visible and not hidden in select tags
          $programLange   = array(); // key = filename without ext, value = selected boolean
          $programLangDir = "{$GLOBALS['PROGRAM_DIR']}/lib/languages/";
          foreach (scandir($programLangDir) as $filename) {
            @list($basename, $ext) = explode(".", $filename, 2);
            if ($ext != 'php') { continue; }
            if (preg_match("/^_/", $basename)) { continue; } // skip internal scripts
            $programLangs[$basename] = 1;
          }
        ?>

        <select name="language" id="language"><?php // 2.50 the ID is used for direct a-name links ?>
        <option value=''>&lt;select&gt;</option>
        <option value='' <?php selectedIf($SETTINGS['language'], ''); ?>>default</option>
          <?php
            foreach (array_keys($programLangs) as $lang) {
              $selectedAttr = $lang == $SETTINGS['language'] ? 'selected="selected"' : '';
              print "<option value=\"$lang\" $selectedAttr>$lang</option>\n";
            }
          ?>
        </select>
        <?php print sprintf(t('Languages are in %s'),'/lib/languages/ or /plugins/.../languages/') ?>
      </td>
    </tr>

    <tr>
      <td><?php et('WYSIWYG Language')?>&nbsp;</td>
      <td>
        <?php // load language file names - do this here so errors are visible and not hidden in select tags
          $wysiwygLangs   = array(); // key = filename without ext, value = selected boolean
          $wysiwygLangDir = "{$GLOBALS['CMS_ASSETS_DIR']}/3rdParty/tiny_mce/langs/";
          foreach (scandir($wysiwygLangDir) as $filename) {
            @list($basename, $ext) = explode(".", $filename, 2);
            if ($ext != 'js') { continue; }
            $wysiwygLangs[$basename] = 1;
          }
        ?>

        <select name="wysiwygLang">
        <option value="en">&lt;select&gt;</option>
          <?php
            foreach (array_keys($wysiwygLangs) as $lang) {
              $selectedAttr = $lang == $SETTINGS['wysiwyg']['wysiwygLang'] ? 'selected="selected"' : '';
              print "<option value=\"$lang\" $selectedAttr>$lang</option>\n";
            }
          ?>
        </select>
        <a href="http://tinymce.moxiecode.com/download_i18n.php" target="_BLANK"><?php eht("Download more languages..."); ?></a>
      </td>
    </tr>
    <tr>
      <td width="200"><?php et("Developer Mode"); ?></td>
      <td height="22">
        <input type="hidden" name="languageDeveloperMode" value="0"/>
        <label>
          <input type="checkbox" name="languageDeveloperMode" value="1" <?php checkedIf($SETTINGS['advanced']['languageDeveloperMode'], '1') ?> />
          <?php et("Automatically add new language strings to language files") ?>
        </label>
      </td>
    </tr>
    <?php endif ?>

    <tr><td colspan="2">&nbsp;</td></tr>
    <tr>
      <td><?php et('Date Field Format');?> &nbsp;</td>
      <td>
        <select name="dateFormat">
        <option value=''>&lt;select&gt;</option>
        <option value='' <?php selectedIf($SETTINGS['dateFormat'], '') ?>>default</option>
        <option value="dmy" <?php selectedIf($SETTINGS['dateFormat'], 'dmy') ?>>Day Month Year</option>
        <option value="mdy" <?php selectedIf($SETTINGS['dateFormat'], 'mdy') ?>>Month Day Year</option>
        </select>
      </td>
    </tr>
    
      <tr>
        <td colspan='2'>
          <div class='content-box content-box-divider'>
            <div class='content-box-header'><h3><?php eht("Advanced Settings"); ?></h3></div>
          </div>
        </td>
      </tr>



    <tr>
      <td><?php et('Image Resizing Quality')?></td>
      <td height="22">
        <select name="imageResizeQuality">
        <option value="65"  <?php selectedIf($SETTINGS['advanced']['imageResizeQuality'], '65'); ?>><?php et('Minimum - Smallest file size, some quality loss')?></option>
        <option value="80"  <?php selectedIf($SETTINGS['advanced']['imageResizeQuality'], '80'); ?>><?php et('Normal - Good balance of quality and file size')?></option>
        <option value="90"  <?php selectedIf($SETTINGS['advanced']['imageResizeQuality'], '90'); ?>><?php et('High - Larger file size, high quality')?></option>
        <option value="100" <?php selectedIf($SETTINGS['advanced']['imageResizeQuality'], '100'); ?>><?php et('Maximum - Very large file size, best quality')?></option>
        </select>
      </td>
    </tr>
    <tr>
      <td width="200"><?php et('WYSIWYG Options') ?></td>
      <td height="22" valign="top">

        <input type="hidden" name="includeDomainInLinks" value="0"/>
        <input type="checkbox"  id="includeDomainInLinks" name="includeDomainInLinks" value="1" <?php checkedIf($SETTINGS['wysiwyg']['includeDomainInLinks'], '1') ?> />
        <label for="includeDomainInLinks"><?php et('Save full URL for local links and images (for viewers on other domains)')?></label>
      </td>
    </tr>
    <tr>
      <td width="200"><?php et('Code Generator')?></td>
      <td height="22">

        <input type="hidden" name="codeGeneratorExpertMode" value="0"/>
        <input type="checkbox"  id="codeGeneratorExpertMode" name="codeGeneratorExpertMode" value="1" <?php checkedIf(@$SETTINGS['advanced']['codeGeneratorExpertMode'], '1') ?> />
        <label for="codeGeneratorExpertMode"><?php et('Expert mode - don\'t show instructions or extra html in Code Generator output')?></label><br/>
      </td>
    </tr>
    <tr>
      <td width="200"><?php et('File Uploads')?></td>
      <td height="22">

        <input type="hidden" name="disableFlashUploader" value="0"/>
        <input type="checkbox"  id="disableFlashUploader" name="disableFlashUploader" value="1" <?php checkedIf(@$SETTINGS['advanced']['disableFlashUploader'], '1') ?> />
        <label for="disableFlashUploader"><?php et('Disable Flash Uploader - attach one file at a time (doesn\'t require flash)')?></label>
        - <a href="http://helpx.adobe.com/flash-player.html" target="_blank"><?php et("Check if Flash is installed"); ?></a><br/>
      </td>
    </tr>
    <tr>
      <td width="200"><?php et('Menu Options') ?></td>
      <td height="22">

        <input type="hidden" name="showExpandedMenu" value="0"/>
        <input type="checkbox"  id="showExpandedMenu" name="showExpandedMenu" value="1" <?php checkedIf($SETTINGS['advanced']['showExpandedMenu'], '1') ?> />
        <label for="showExpandedMenu"><?php et("Always show expanded menu (don't hide unselected menu groups)")?></label><br/>
      </td>
    </tr>

    <?php if (array_key_exists('showExpandedMenu', $CURRENT_USER)): ?>
    <tr>
      <td width="200">&nbsp;</td>
      <td height="22">
        (<b><?php et('Updated') ?>:</b> <?php et("This option is now being ignored and being set on a per user basis with the 'showExpandedMenu' field in")?> <a href="?menu=accounts"><?php et('User Accounts')?></a>.<br/>
      </td>
    </tr>
    <?php endif ?>

    <tr>
      <td width="200"><?php et('Use Datepicker') ?></td>
      <td height="22">

        <input type="hidden" name="useDatepicker" value="0"/>
        <label>
          <input type="checkbox" name="useDatepicker" value="1" <?php checkedIf($SETTINGS['advanced']['useDatepicker'], '1') ?> />
          <?php et("Display datepicker icon and popup calendar beside date fields") ?>
        </label>
      </td>
    </tr>

    <tr><td colspan="2">&nbsp;</td></tr>

    <tr>
      <td width="200"><?php echo("session.save_path") ?></td>
      <td><input class="text-input wide-input" type="text" name="session_save_path" value="<?php echo htmlencode(@$SETTINGS['advanced']['session_save_path']) ?>" size="60" /></td>
    </tr>
    <tr>
      <td width="200">&nbsp;</td>
      <td>
        <?php et("If your server is expiring login sessions too quickly set this to a new directory outside of your web root or leave blank for default value of:"); ?> <?php echo htmlencode(get_cfg_var('session.save_path')); ?><br/><br/></td>
    </tr>

    <tr>
      <td width="200"><?php echo("session.cookie_domain") ?></td>
      <td><input class="text-input wide-input" type="text" name="session_cookie_domain" value="<?php echo htmlencode(@$SETTINGS['advanced']['session_cookie_domain']) ?>" size="60" /></td>
    </tr>
    <tr>
      <td width="200">&nbsp;</td>
      <td><?php et("To support multiple subdomains set to parent domain (eg: example.com), or leave blank to default to current domain."); ?><br/><br/></td>
    </tr>


    
    
      <tr>
        <td colspan='2'>
          <div class='content-box content-box-divider'>
            <div class='content-box-header'><h3><?php eht("Backup & Restore"); ?></h3></div>
          </div>
        </td>
      </tr>
    <tr>
      <td width="200"><?php et('Database Backup') ?></td>
      <td>
        <?php print sprintf(t('Create a backup file in %s of'),'/data/backups/') ?>
        <select name="backupTable" id="backupTable">
        <option value=''><?php et('all database tables'); ?></option>
        <?php
          $schemaTables = getSchemaTables();
          sort($schemaTables);
          echo getSelectOptions(@$_REQUEST['backupTable'], $schemaTables);
        ?>
        </select>
        <input class="button" type="button" name="null" value="<?php eht('Backup'); ?>" onclick="return redirectWithPost('?', {menu:'admin', action:'backup', 'backupTable':$('#backupTable').val(), '_CSRFToken': $('[name=_CSRFToken]').val()});" /><br/>

      </td>
    </tr>
    <tr>
      <td width="200"><?php et('Database Restore') ?></td>
      <td>
        <?php $options = getBackupFiles_asOptions(); ?>
        <select name="restore" id="restore"><?php echo $options ?></select>
        <input class="button" type="button" name="null" value="<?php eht('Restore'); ?>" onclick="confirmRestoreDatabase()" /><br/>

      </td>
    </tr>


     <tr><td colspan="2">&nbsp;</td></tr>


      <tr>
        <td colspan='2'>
          <a name="background-tasks"></a>
          <div class='content-box content-box-divider'>
            <div class='content-box-header'><h3><a href="?menu=admin&action=general#background-tasks"><?php eht("Background Tasks"); ?></a></h3></div>
          </div>
        </td>
      </tr>

        <tr>
          <td width="200"><?php eht('Overview & Setup'); ?></td>
          <td height="22" style="line-height: 125%">
            <?php echo nl2br(t("Background tasks allow programs to run in the background at specific times for tasks such as maintenance, email alerts, etc.\n".
                              "You don't need to enable this feature unless you have a plugin that requires it.")); ?><br/><br/>
            <?php et("To setup Background Tasks, add a server cronjob or 'scheduled task' to execute the following command every minute:"); ?><br/>
            <pre>php -q <?php echo absPath($GLOBALS['PROGRAM_DIR'] ."/cron.php"); ?></pre><br/>
          </td>
        </tr>
        <tr>
          <td width="200"><?php eht("Status"); ?></td>
          <td height="22" style="line-height: 150%">
            <?php
              $prettyDate   = prettyDate($SETTINGS['bgtasks_lastRun']);
              $dateString   = $SETTINGS['bgtasks_lastRun'] ? date("D, M j, Y - g:i:s A", $SETTINGS['bgtasks_lastRun']) : $prettyDate;

              $logCount  = mysql_count('_cron_log');
              $failCount = mysql_count('_cron_log', array('completed' => '0'));
            ?>

            <?php et('Last Run'); ?>:
            <span style='text-decoration: underline' title='<?php echo $dateString; ?>'><?php echo htmlencode($prettyDate); ?></span>
            - <a href="cron.php"><?php eht("run now >>"); ?></a><br/>

            <?php et("Email Alerts: If tasks fail an email alert will be sent to admin (max once an hour)."); ?><br/>

            <?php et("Log Summary: "); ?>
            <a href="?menu=_cron_log&completed_match=&showAdvancedSearch=1&_ignoreSavedSearch=1"><?php echo $logCount ?> <?php et("entries"); ?></a>,
            <a href="?menu=_cron_log&completed_match=0&showAdvancedSearch=1&_ignoreSavedSearch=1"><?php echo $failCount ?> <?php et("errors"); ?></a>
            - <a href="#" onclick="return redirectWithPost('?', {menu:'admin', action:'bgtasksLogsClear', '_CSRFToken': $('[name=_CSRFToken]').val()});"><?php et("clear all"); ?></a><br/>
          </td>
        </tr>


     <tr><td colspan="2">&nbsp;</td></tr>


        <tr>
          <td width="200">
            <?php et('Recent Activity'); ?>
          </td>
          <td height="22">

            <table cellspacing="0" class="data">
              <thead>
                <tr style="text-align: left;">
                  <th><?php et('Date'); ?></th>
                  <th><?php et('Activity'); ?></th>
                  <th><?php et('Summary'); ?></th>
                  <th><?php et('Completed'); ?></th>
                </tr>
              </thead>

            <?php
              $recentRecords = mysql_select('_cron_log', "true ORDER BY num DESC LIMIT 5");
              if ($recentRecords):
            ?>
              <?php foreach ($recentRecords as $record): ?>
                <tr class="listRow <?php echo (@++$cronLogCounter) % 2 ? 'listRowOdd' : 'listRowEven' ?>">
                  <td><?php echo htmlencode($record['createdDate']); ?></td>
                  <td>
                    <a href="?menu=_cron_log&amp;action=edit&amp;num=<?php echo $record['num'] ?>"><?php echo htmlencode($record['activity']); ?></a><br/>
                    <?php /* <small><?php echo htmlencode($record['runtime']); ?> seconds</small> */ ?>
                  </td>
                  <td><?php echo htmlencode($record['summary']); ?></td>
                  <td><?php echo $record['completed'] ? t('Yes') : t('No'); ?></td>
                </tr>
              <?php endforeach ?>
            <div align="center" style="padding-top: 5px"><a href="?menu=_cron_log"><?php eht("Background Tasks Log >>"); ?></a></div><br/>
            <?php else: ?>
              <tr>
                <td colspan="4"><?php et('None'); ?></th>
              </tr>
            <?php endif ?>
            </table>
          </td>
        </tr>


     <tr><td colspan="2">&nbsp;</td></tr>


        <tr>
          <td width="200">
            <?php et('Scheduled Tasks'); ?>
          </td>
          <td height="22">

            <table cellspacing="0" class="data">
              <thead>
                <tr style="text-align: left;">
                  <th><?php et('Function'); ?></th>
                  <th><?php et('Activity'); ?></th>
                  <th><?php et('Last Run'); ?></th>
                  <th><?php et('Frequency'); ?> (<a href="http://en.wikipedia.org/wiki/Cron#CRON_expression" target="_blank">?</a>)</th>
                </tr>
              </thead>

              <?php
                $cronRecords = getCronList();
                if ($cronRecords):
              ?>

              <?php foreach ($cronRecords as $record): ?>
                <tr class="listRow <?php echo (@++$cronTaskCounter) % 2 ? 'listRowOdd' : 'listRowEven' ?>">
                  <td><?php echo htmlencode($record['function']); ?></td>
                  <td><?php echo htmlencode($record['activity']); ?></td>
                  <td><?php
                      $latestLog = mysql_get('_cron_log', null, ' function = "' .mysql_escape($record['function']). '" ORDER BY num DESC');
                      echo prettyDate( $latestLog['createdDate'] );
                    ?></td>
                  <td><?php echo htmlencode($record['expression']); ?></td>
                </tr>
              <?php endforeach ?>
            <?php else: ?>
              <tr>
                <td colspan="4"><?php et('None'); ?></th>
              </tr>
            <?php endif ?>
            </table>

          </td>
        </tr>

    

      <tr>
        <td colspan='2'>
          <div class='content-box content-box-divider'>
            <div class='content-box-header'><h3><?php eht("Security Settings"); ?></h3></div>
          </div>
        </td>
      </tr>
    
    <tr>
      <td width="200"><?php et("Login Timeouts"); ?></td>
      <td>
        <?php et("Automatically expire login sessions after"); ?>
        <input type="text" name="login_expiry_limit" value="<?php echo htmlencode(@$SETTINGS['advanced']['login_expiry_limit']) ?>" size="4" maxlength="4" class="text-input" style="width: 3em; text-align: center">
        <?php $htmlOptions = getSelectOptions(@$SETTINGS['advanced']['login_expiry_unit'], array('minutes','hours','days','months'), array(t('minutes'),t('hours'),t('days'),t('months'))); ?>
        <select name="login_expiry_unit"><?php echo $htmlOptions ?></select><br/>
      </td>
    </tr>    

    <tr><td colspan="2">&nbsp;</td></tr>

    <tr>
      <td width="200"><?php et('Hide PHP Errors') ?></td>
      <td height="22">

        <input type="hidden" name="phpHideErrors" value="0"/>
        <label>
          <input type="checkbox" name="phpHideErrors" value="1" <?php checkedIf($SETTINGS['advanced']['phpHideErrors'], '1') ?> />
          <?php et("Hide all PHP errors and warnings (still logged to <a href='?menu=_error_log'>error log</a>)") ?>
        </label>
      </td>
    </tr>
    
    <tr>
      <td width="200"><?php et('Email PHP Errors') ?></td>
      <td height="22">

        <input type="hidden" name="phpEmailErrors" value="0"/>
        <label>
          <input type="checkbox" name="phpEmailErrors" value="1" <?php checkedIf($SETTINGS['advanced']['phpEmailErrors'], '1') ?> />
          <?php et("When <a href='?menu=_error_log'>php errors</a> are detected send admin a <a href='?menu=_email_templates'>notification email</a>") ?>
        </label>
      </td>
    </tr>

    <tr>
      <td width="200"><?php et('Check Referer') ?></td>
      <td height="22">

        <input type="hidden" name="checkReferer" value="0"/>
        <label>
          <input type="checkbox" name="checkReferer" value="1" <?php checkedIf($SETTINGS['advanced']['checkReferer'], '1') ?> />
          <?php et("Warn on external referers/links and require internal referer to submit data to CMS.") ?>
        </label>
      </td>
    </tr>

    <tr>
      <td width="200"><?php et('Disable Autocomplete') ?></td>
      <td height="22">

        <input type="hidden" name="disableAutocomplete" value="0"/>
        <label>
          <input type="checkbox" name="disableAutocomplete" value="1" <?php checkedIf($SETTINGS['advanced']['disableAutocomplete'], '1') ?> />
          <?php et("Attempt to disable autocomplete functionality in browsers to prevent storing of usernames and passwords.") ?>
        </label>
      </td>
    </tr>


    <tr>
      <td width="200"><?php et('Require HTTPS') ?></td>
      <td height="22">

        <input type="hidden" name="requireHTTPS" value="0"/>
        <label>
          <input type="checkbox" name="requireHTTPS" value="1" <?php checkedIf($SETTINGS['advanced']['requireHTTPS'], '1') ?> />
          <?php et("Only allow users to login via secure HTTPS connections") ?>
        </label>
      </td>
    </tr>



    <tr>
      <td width="200"><?php et("Restrict IP Access"); ?></td>
      <td height="22">
        <input type="hidden" name="restrictByIP" value="0"/>
        <label>
          <input type="checkbox" name="restrictByIP" value="1" <?php checkedIf($SETTINGS['advanced']['restrictByIP'], '1') ?> />
          <?php echo sprintf("Only allow users to login from these IP addresses.  eg: 1.2.3.4, 4.4.4.4 (Your IP is: %s)", $_SERVER['REMOTE_ADDR']); ?>
        </label>
        <div style="padding-left: 25px">
          <input class="text-input wide-input" type="text" name="restrictByIP_allowed" value="<?php echo htmlencode(@$SETTINGS['advanced']['restrictByIP_allowed']) ?>" size="30" />
        </div>
      </td>
    </tr>



    <tr><td colspan="2">&nbsp;</td></tr>

    <?php
      $tips = array();
      $errorLogCount = mysql_count('_error_log'); 
      if (!isHTTPS())                                       { $tips[] = t("Use a secure https:// url to access this program.  You are currently using an insecure connection."); }
      if (!$SETTINGS['advanced']['requireHTTPS'])           { $tips[] = t("Enable 'Require HTTPS' above to disallow insecure connections."); }
      if (ini_get('display_errors'))                        { $tips[] = t("Hide PHP Errors (for production and live web servers)."); }
      if (!$SETTINGS['advanced']['phpEmailErrors'])         { $tips[] = t("Enable 'Email PHP Errors' to be notified of PHP errors on website."); }
      if (ini_get('expose_php'))                            { $tips[] = t(sprintf("%s is currently enabled, disable it in php.ini.", '<a href="http://www.php.net/manual/en/ini.core.php#ini.expose-php">expose_php</a>')); }
      if ($errorLogCount)                                   { $tips[] = t("There are PHP errors in the <a href='?menu=_error_log'>error log</a>.  Review them and then clear the error log."); }
      if (loginExpirySeconds() > (60*30))                   { $tips[] = t("Set login timeout to 30 minutes or less."); }
      if (!array_key_exists('CMSB_MOD_SECURITY2', $_SERVER)) { // mod_security2 reports false positives that are excluded for scripts named admin.php, so don't recommend this setting for hosts mod_security2 hosts
        if (basename($_SERVER['SCRIPT_NAME']) == 'admin.php') { $tips[] = t(sprintf("Rename admin.php to something unique such as admin_%s.php", substr(sha1(uniqid(null, true)), 0, 20) )); }
      }
      $oldFilesAndDirs = array(); // ask user to remove outdated files
      $oldFilesAndDirs[] = '/3rdParty/thickbox';
      $oldFilesAndDirs[] = '/3rdParty/tiny_mce/tiny_mce_gzip.js';
      $oldFilesAndDirs[] = '/css';
      $oldFilesAndDirs[] = '/images';
      $oldFilesAndDirs[] = '/js';
      $oldFilesAndDirs[] = '/lib/compat';
      $oldFilesAndDirs[] = '/lib/images/loadingBar.gif';
      $oldFilesAndDirs[] = '/lib/jquery.js';
      $oldFilesAndDirs[] = '/lib/jquery.tablednd.js';
      $oldFilesAndDirs[] = '/lib/jquery1.2.js';
      $oldFilesAndDirs[] = '/lib/jquery1.3.2.js';
      $oldFilesAndDirs[] = '/lib/jqueryForm.js';
      $oldFilesAndDirs[] = '/lib/jqueryInterfaceSortables.js';
      $oldFilesAndDirs[] = '/lib/jqueryThickbox.js';
      $oldFilesAndDirs[] = '/lib/tinyMCE';
      $oldFilesAndDirs[] = '/lib/viewer_turboCache.php';
      $oldFilesAndDirs[] = '/lib/website_functions.php';
      $oldFilesAndDirs[] = '/lib/website_functions2.js';
      $oldFilesAndDirs[] = '/lib/website_functions2.php';
      $oldFilesAndDirs[] = '/lib/website_functions_notes.txt';
      $oldFilesAndDirs[] = '/tinyMCE';
      $oldFilesAndDirs[] = '/tinymce3';
      $oldFilesAndDirs[] = '/style.css';
      $oldFilesAndDirs[] = '/style_ie6.css';
      foreach ($oldFilesAndDirs as $relativePath) { 
        if     (is_dir(SCRIPT_DIR.'/'.$relativePath))        { $tips[] = t(sprintf("Remove old folder: %s", SCRIPT_DIR . $relativePath )); }
        elseif (is_file(SCRIPT_DIR.'/'.$relativePath))       { $tips[] = t(sprintf("Remove old file: %s", SCRIPT_DIR . $relativePath )); }
      }
  
    ?>

    <tr>
      <td width="200"><b><?php et("Security Tips"); ?></b></td>
      <td height="22">
        <div style="line-height: 1.5em">
          <?php
          
            if ($tips) { 
              echo "<div style='color: #C00;'>"; 
              echo "  <b>" .t('These tips are custom generated and apply to the current server and connection:'). "</b>";
              foreach ($tips as $tip) { print "<li>$tip</li>\n"; }
              echo "</div>"; 
            }
            
            if (!$tips) {
              print t('None');
            }
          ?>
        
        </div>
      </td>
    </tr>

    <tr><td colspan="2">&nbsp;</td></tr>




      <tr>
        <td colspan='2'>
          <div class='content-box content-box-divider'>
            <div class='content-box-header'><h3><?php eht("Server Info"); ?></h3></div>
          </div>
        </td>
      </tr>



     <tr>
      <td width="192"><?php et('Operating System') ?>&nbsp;</td>
      <td>
        <?php
          $server  = @php_uname('s'); // Operating system name, eg: 
          $release = @php_uname('r'); // Release name,          eg: 
          //$version = @php_uname('v'); // Version info (varies), 
          $machine = @php_uname('m'); // Machine type. eg. i386, x86_64 
          
          print "$server $release ($machine)";
          print "\n<!-- `ls /etc/*-release` returns: \n" . @`ls /etc/*-release`. "\n-->\n"; 
          print "\n<!-- `cat /etc/*-release` returns: \n" . @`cat /etc/*-release`. "\n-->\n"; 
        ?>
        
        <!--
          php_uname('s'): <?php echo @php_uname('s'); ?> --- Operating system name. eg. Windows NT, Linux, FreeBSD.
          php_uname('n'): <?php echo @php_uname('n'); ?> --- Host name. eg. localhost.example.com.
          php_uname('r'): <?php echo @php_uname('r'); ?> --- Release name. eg. 5.1, 2.6.18-164.11.1.el5, 5.1.2-RELEASE.
          php_uname('v'): <?php echo @php_uname('v'); ?> --- Version information. Varies a lot between operating systems, eg: build 2600 (Windows XP Professional Service Pack 3), #1 SMP Wed Dec 17 11:42:39 EST 2008 i686
          php_uname('m'): <?php echo @php_uname('m'); ?> --- Machine type. eg. i386, x86_64 
        -->
      </td>
     </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
     <tr>
      <td width="192"><?php et('Web Server') ?>&nbsp;</td>
      <td><?php echo array_shift( @explode(' ', $_SERVER['SERVER_SOFTWARE']) ); ?></td>
     </tr>

    <tr><td colspan="2">&nbsp;</td></tr>
    <tr>
      <td width="192"><?php et('PHP Version')?>&nbsp;</td>
      <td>
        PHP v<?php echo phpversion() ?> - <a href="?menu=admin&amp;action=phpinfo">phpinfo &gt;&gt;</a><br/>
        <?php
          $disabledFunctions = str_replace(',', ', ', ini_get('disable_functions'));
          $suhosinDisabled   = str_replace(',', ', ', ini_get('suhosin.executor.func.blacklist'));
          if ($suhosinDisabled) { $disabledFunctions .= " - " . t("Suhosin disabled") . ": $suhosinDisabled"; }
        ?>
          
        <div style="padding: 5px 20px 0px; line-height: 1.5em">
          <li><a href="?menu=_error_log"><?php echo t('View PHP Error log'); ?> &gt;&gt;</a></li>
          <li><?php echo t('PHP is running as user'); ?>: <?php echo htmlencode(get_current_user()); ?></li>
          <li><?php echo t('PHP disabled functions'); ?>: <?php echo coalesce($disabledFunctions, t('none')); ?>          
          <li>php.ini path: <?php echo get_cfg_var('cfg_file_path'); ?><br/>
          <?php // future, show additional .php files load with? php_ini_scanned_files, or php_ini_loaded_file ?>

<?php // SUHOSIN DETECTION 
  // get phpinfo() content
  ob_start(); @phpinfo(INFO_GENERAL); $phpinfo_general = ob_get_contents(); ob_end_clean();
  ob_start(); @phpinfo(INFO_MODULES); $phpinfo_modules = ob_get_contents(); ob_end_clean();
  $phpinfo_general      = preg_replace("/&nbsp;/i", " ", $phpinfo_general);   
  $phpinfo_modules_text = strip_tags($phpinfo_modules);
  
  // suhosin detection
  $suhosin_in_phpinfo_general = (preg_match("/(Suhosin( Patch)? [\d\.]+)/i", $phpinfo_general, $matches) ? $matches[0] : '');
  $suhosin_in_phpinfo_modules = (preg_match("/(Suhosin.*?[0-9][\d\.]+)/i", $phpinfo_modules_text, $matches) ? $matches[0] : '');
  $suhosin_ini                = @ini_get_all('suhosin');
  $suhosin_ini_get_all_count  = $suhosin_ini ? count($suhosin_ini) : 0;
  $suhosin_funcs_as_csv       = @implode(', ', get_extension_funcs('suhosin'));
  $suhosin_extension_loaded   = extension_loaded('suhosin');   // http://stackoverflow.com/questions/3383916/how-to-check-whether-suhosin-is-installed
  $suhosin_patch_constant     = @constant("SUHOSIN_PATCH");    // http://stackoverflow.com/questions/3383916/how-to-check-whether-suhosin-is-installed
  // future: Check for Suhosin easter egg image: any_php_file.php?=SUHO8567F54-D428-14d2-A769-00DA302A5F18
  $suhosin_detected           = $suhosin_in_phpinfo_general || $suhosin_in_phpinfo_modules || $suhosin_ini_get_all_count || $suhosin_extension_loaded || $suhosin_patch_constant;
  $suhosin_detected_version  = coalesce($suhosin_in_phpinfo_general, $suhosin_in_phpinfo_modules, t('Yes'));

  // show detection status
  print "<li>Suhosin Detected: "; 
  if ($suhosin_detected) { print "<span style='color: #C00;'>$suhosin_detected_version</span>"; }
  else                   { et("No"); }
  print "<br/>\n"; 
  
  // print suhosin debug data
  print "\n\n<!--  Suhosin Detection Details (for debugging):\n"; 
  print "phpinfo(INFO_GENERAL) found string: $suhosin_in_phpinfo_general\n";
  print "phpinfo(INFO_MODULES) found string: $suhosin_in_phpinfo_modules\n";
  print "ini_get_all('suhosin'): $suhosin_ini_get_all_count values\n";
  print "get_extension_funcs('suhosin'): $suhosin_funcs_as_csv\n";
  print "extension_loaded('suhosin'): $suhosin_extension_loaded\n"; 
  print "defined('SUHOSIN_PATCH'): " . defined('SUHOSIN_PATCH') . "\n"; 
  print "constant('SUHOSIN_PATCH'): $suhosin_patch_constant\n";
  print "-->\n\n"; 
?>

        </div>

      </td>
    </tr>
    <tr>


    <tr><td colspan="2">&nbsp;</td></tr>
     <tr>
      <td width="192"><?php et('Database Server') ?>&nbsp;</td>
      <td>
        <?php print sprintf(t('MySQL v%s'),preg_replace("/[^0-9\.]/", '', mysql_get_server_info())); ?>
        <?php
          list($maxConnections, $maxUserConnections) = mysql_get_query("SELECT @@max_connections, @@max_user_connections", true); // returns the session value if it exists and the global value otherwise
          if ($maxUserConnections && $maxUserConnections < $maxConnections) { $maxConnections = $maxUserConnections; }
          echo " (" . t('Max Connections') . ": $maxConnections)";
        ?>
      </td>
     </tr>
    <tr>
      <td width="192">&nbsp;</td>
      <td style="padding: 5px 20px 0px; line-height: 1.5em">
        <li><?php echo t('Hostname'); ?>: <?php echo inDemoMode() ? 'demo' : htmlencode($SETTINGS['mysql']['hostname']) ?> -
        <?php echo t('Database'); ?>: <?php echo inDemoMode() ? 'demo' : htmlencode($SETTINGS['mysql']['database']) ?> -
        <?php echo t('Username'); ?>: <?php echo inDemoMode() ? 'demo' : htmlencode($SETTINGS['mysql']['username']) ?> -
        <?php echo t('Table Prefix'); ?>: <?php echo htmlencode($TABLE_PREFIX) ?><br/>

        <li><?php printf(t('To change %1$s settings edit %2$s'), 'MySQL', '/data/'.SETTINGS_FILENAME); ?>

     </td>
    </tr>



    <tr>
      <td colspan="2">
        <br/>
      </td>
    </tr>

     <tr>
      <td><?php et('Disk Space')?>&nbsp;</td>
      <td><?php
        if ($totalBytes) {
          printf(t('Free: %1$s, Total: %2$s'), formatBytes($freeBytes), formatBytes($totalBytes));
        }
        else {  // for servers that return 0 and "Warning: Value too large for defined data type" on big ints
          et("Unavailable");
        }
      ?></td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
     <tr>
      <td><?php et('Server Resource Limits') ?>&nbsp;</td>
      <td>
      <?php
        if ($maxCpuSeconds || $memoryLimitKbytes || $maxProcessLimit) {
          print "CPU Time: $maxCpuSeconds_formatted, Memory Limit: $memoryLimit_formatted, Processes: $maxProcessLimit - <a href='$ulimitLink'>ulimit &gt;&gt;</a>";
        }
        else {
          et("Unavailable");
        }
       ?>
      </td>
    </tr>
<?php /*
    <tr><td colspan="2">&nbsp;</td></tr>
     <tr>
      <td><?php et('Outgoing Mail Server IP') ?>&nbsp;</td>
      <td><?php
        $smtp = ini_get('SMTP');
        if (!$smtp) { $smtp = $_SERVER['SERVER_ADDR']; }
        if (!$smtp) { $smtp = $_SERVER['HTTP_HOST'];   }
        $smtp_ip = @gethostbyname($smtp);
        if ($smtp_ip)                         { $smtp = $smtp_ip;    }
        if (!$smtp || $smtp == '127.0.0.1')   { $smtp = '(unknown)'; }
        ?>
        <input type="text" readonly="readonly" value="<?php echo $smtp ?>" onclick="this.focus(); this.select();" />
        -
        <a href="http://www.google.com/search?q=blacklist+ip+check" target="_blank">check blacklists &gt;&gt;</a>
      </td>
    </tr>
     <tr><td colspan="2">&nbsp;</td></tr>
     <tr>
      <td>Max Concurrent Users&nbsp;</td>
      <td>
      <?php
        if ($maxProcessLimit && $maxConnections) {
          print min($maxProcessLimit, $maxConnections);
          print " - Based on Max MySQL Connections and Max Processes (other limits may affect total as well)<br/>\n";
        }
        else {
          et("Unavailable");
        }
       ?>
      </td>
    </tr>
*/ ?>


  </table>
  <br/>

  <div style="float:right">
     <input class="button" type="submit" name="action=adminSave" value="<?php et('Save') ?>" />
     <input class="button" type="submit" name="action=general" value="<?php et('Cancel') ?>" />
  </div>
  <div class="clear"></div>

  </div>
</div>


<script type="text/javascript"><!--

//
function updateDatePreviews() {
  var url = "?menu=admin&action=updateDate";
  url    += "&timezone=" + escape( $('#timezone').val() );

  $.ajax({
    url: url,
    dataType: 'json',
    error:   function(XMLHttpRequest, textStatus, errorThrown){
      alert("There was an error sending the request! (" +XMLHttpRequest['status']+" "+XMLHttpRequest['statusText'] + ")\n" + errorThrown);
    },
    success: function(json){
      var error = json[2];
      if (error) { return alert(error); }
      $('#localDate').html(json[0]);
      $('#mysqlDate').html(json[1]);
      //$('#localDate, #mysqlDate').attr('style', 'background-color: #FFFFCC');
    }
  });
}

//
function confirmRestoreDatabase() {
  var backupFile = $('#restore').val();

  // error checking
  if (backupFile == '') { return alert('<?php et('No backup file selected!')?>'); }

  // request confirmation
  if (!confirm("<?php et('Restore data from this backup file?')?>\n" +backupFile+ "\n\n<?php et('WARNING: BACKUP DATA WILL OVERWRITE EXISTING DATA!')?>")) { return; }

  //
  redirectWithPost('?', {
    'menu':       'admin',
    'action':     'restore',
    'file':       backupFile,
    '_CSRFToken': $('[name=_CSRFToken]').val()
  });
  
}

//--></script>

</form>
