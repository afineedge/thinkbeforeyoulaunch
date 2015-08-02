<?php include "header.php" ?>

<?php // Security: Form action is set to the program url here so admin.php/path-info/ name/value pairs can't be passed through malicious urls  ?>
<form method="post" action="<?php echo parse_url(thisPageUrl(), PHP_URL_PATH); ?>" <?php disableAutocomplete(); ?>>
<input type="hidden" name="action" value="loginSubmit" />
<input type="hidden" name="redirectUrl" value="<?php echo htmlencode( @$_REQUEST['redirectUrl'] ? $_REQUEST['redirectUrl'] : thisPageUrl(null, true) )?>" />
<?php echo security_getHiddenCsrfTokenField(); ?>
<?php disableAutocomplete('form-headers'); ?>

<div class="content-box">
  <div class="content-box-header"><h3><?php et('Login') ?></h3></div>
  <div class="content-box-content login-content">
    <div class="tab-content default-tab" align="center">

<?php ob_start(); // start caching output ?>
        <p>
          <span class="label"><?php et('Username') ?></span>
          <input class="text-input" type="text" name="username" id="username" value="<?php echo htmlencode(@$_REQUEST['username']) ?>" tabindex="1" <?php disableAutocomplete(); ?>/>
        </p>
        <script type="text/javascript">document.getElementById('username').focus();</script>

        <p>
          <span class="label"><?php et('Password') ?></span>
          <input class="text-input" type="password" name="password" value="<?php echo htmlencode(@$_REQUEST['password']) ?>" tabindex="2" <?php disableAutocomplete(); ?>/>
        </p>

        <p>
          <input class="button" type="submit" name="login" value="<?php et('Login') ?>" tabindex="4" />
        </p>

        <p>
          <a href="?menu=forgotPassword"><?php et('Forgot your password?'); ?></a>
        </p>
<?php
  $content = ob_get_clean(); // get cached output
  $content = applyFilters('login_content', $content);
  echo $content;
?>


      <div class="clear"></div>

    </div> <!-- End .tab-content -->
  </div> <!-- End .content-box-content -->
</div> <!-- End .content-box -->

</form>

<?php showFooter(); ?>
