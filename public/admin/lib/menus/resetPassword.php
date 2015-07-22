
<form method="post" action="?" <?php disableAutocomplete(); ?>>
<input type="hidden" name="menu"       value="resetPassword" />
<input type="hidden" name="userNum"    value="<?php echo htmlencode(@$_REQUEST['userNum']); ?>" />
<input type="hidden" name="resetCode"  value="<?php echo htmlencode(@$_REQUEST['resetCode']); ?>" />
<input type="hidden" name="username"   value="<?php echo htmlencode( $GLOBALS['user']['username'] ); ?>" /><?php // display by login form after resetting password ?>
<input type="hidden" name="submitForm" value="1" />
<?php echo security_getHiddenCsrfTokenField(); ?>

<div class="content-box">
  <div class="content-box-header"><h3><?php et('Reset your password') ?></h3></div>
  <div class="content-box-content login-content">
    <div class="tab-content default-tab" align="center">

        <?php if (@$_REQUEST['submitForm'] && !alert()): ?>
          <br/><br/><br/>
          <?php et("Thanks, we've updated your password!") ?><br/><br/>
          <a href="?"><?php et('&lt;&lt; Back to Login Page') ?></a>
          <br/><br/><br/><br/>
        <?php else: ?>

<br/>
          <table border="1" cellspacing="0" cellpadding="0">
            <tr>
              <td><?php et('Username') ?></td>
              <td style="padding: 10px 0px"><?php echo htmlencode( $GLOBALS['user']['username'] ); ?></td>
            </tr>
            <tr>
              <td><?php et('New Password') ?></td>
              <td><input class="text-input" type="password" name="password"  value="<?php echo htmlencode(@$_REQUEST['password']) ?>" <?php disableAutocomplete(); ?>/></td>
            </tr>
            <tr>
              <td><?php et('New Password (again)') ?> &nbsp;</td>
              <td><input class="text-input" type="password" name="password:again"  value="<?php echo htmlencode(@$_REQUEST['password:again']) ?>" <?php disableAutocomplete(); ?>/></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><input class="button" type="submit" name="send" value="<?php et('Update') ?>" /></td>
            </tr>
          </table>

          <div class="clear"></div>

          <p style="float: left; margin-top: 20px">
            <a href="?"><?php et('&lt;&lt; Back to Login Page') ?></a>
          </p>

        <?php endif ?>

      <div class="clear"></div>

    </div> <!-- End .tab-content -->
  </div> <!-- End .content-box-content -->
</div> <!-- End .content-box -->

</form>

