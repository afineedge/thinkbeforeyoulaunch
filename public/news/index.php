<?php include "../includes/cms.php";

  // load record from 'homepage_content'
  list($homepage_contentRecords, $homepage_contentMetaData) = getRecords(array(
    'tableName'   => 'homepage_content',
    'where'       => '', // load first record
    'loadUploads' => true,
    'allowSearch' => false,
    'limit'       => '1',
  ));
  $homepage_contentRecord = @$homepage_contentRecords[0]; // get first record
  if (!$homepage_contentRecord) { dieWith404("Record not found!"); } // show error message if no record found

  // load records from 'articles'
  list($articlesRecords, $articlesMetaData) = getRecords(array(
    'tableName'   => 'articles',
    'loadUploads' => true,
    'allowSearch' => true,
  ));
  $articlesRecord = @$articlesRecords[0]; // get first record

  // load record from 'contact_info'
  list($contact_infoRecords, $contact_infoMetaData) = getRecords(array(
    'tableName'   => 'contact_info',
    'where'       => '', // load first record
    'loadUploads' => true,
    'allowSearch' => false,
    'limit'       => '1',
  ));
  $contact_infoRecord = @$contact_infoRecords[0]; // get first record
  if (!$contact_infoRecord) { dieWith404("Record not found!"); } // show error message if no record found

  foreach ($homepage_contentRecord['open_graph_image'] as $index => $upload){
  	$open_graph_image = htmlencode($upload['urlPath']);
  }


	// FORM CODE

	$errorsAndAlerts = "";
	$success = "";


	if (@$_REQUEST['contact']) {
	  //set error messages
	    if (!@$_REQUEST['name'])  { $errorsAndAlerts .= "<li>Please enter your name.</li>"; }
	    if (!@$_REQUEST['email'])  { $errorsAndAlerts .= "<li>Please enter your email address.</li>"; }
	    elseif(!isValidEmail(@$_REQUEST['email']))  { $errorsAndAlerts .= "<li>Please enter a valid email address.</li>"; }
	    if (!@$_REQUEST['comment'])  { $errorsAndAlerts .= "<li>Please enter your comment.</li>"; }

	  // IF NO ERRORS, SUBMIT FORM
	  if (!@$errorsAndAlerts) { 
	  
	    // turn off strict mysql error checking for: STRICT_ALL_TABLES
	    mysqlStrictMode(false); // disable Mysql strict errors for when a field isn't defined below (can be caused when fields are added later)
	  
	    // add record
	    mysql_query("INSERT INTO `{$TABLE_PREFIX}contact_form_submissions` SET
	              name       = '".mysql_real_escape_string( $_REQUEST['name'] )."',
	              email_address        = '".mysql_real_escape_string( $_REQUEST['email'] )."',
	              comment        = '".mysql_real_escape_string( $_REQUEST['comment'] )."',

	              createdDate      = NOW(),
	              updatedDate      = NOW(),
	              createdByUserNum = '0',
	              updatedByUserNum = '0'")
	    or die("MySQL Error Creating Record:<br/>\n". htmlspecialchars(mysql_error()) . "\n");
	    $recordNum = mysql_insert_id();

	      	  // email everyone who wants to know
	          // $emailHeaders = emailTemplate_loadFromDB(array(
	          //   'template_id'  => 'CMS-CONTACT-US',
	          //   'placeholders' => array(
	          //       'user.name'    => $_REQUEST['name'],
	          //       'user.email'        => $_REQUEST['email'],
	          //       'user.comment'     => $_REQUEST['comment'],
	          //       'yyyy-mm-dd'        => date("Y-m-d"),
	          //       'time'              => date("H:i"),
	          //   ),
	          // ));
	          // $mailErrors = sendMessage($emailHeaders);
	          // if ($mailErrors) { die("Mail Error: $mailErrors"); }
	  

	    // go to confirmation page
	    $success = 'true';
	  
	  }// End of form processing.
	} // End of form IF.

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="initial-scale=1, maximum-scale=1, minimal-ui">

<meta property="og:title" content="<?php echo htmlencode($articlesRecord['title']) ?>" />
<meta property="og:site_name" content="<?php echo htmlencode($articlesRecord['title']) ?>" />
<meta property="og:image" content="<?php echo $open_graph_image; ?>" />
<meta property="og:description" content="<?php echo htmlencode($articlesRecord['short_description']) ?>" />
<meta property="og:url" content="http://www.thinkbeforeyoulaunch.com/" />

<!-- Update your html tag to include the itemscope and itemtype attributes. -->
<html itemscope itemtype="http://schema.org/Organization">

<!-- Add the following three tags inside head. -->
<meta itemprop="name" content="<?php echo htmlencode($articlesRecord['title']) ?>">
<meta itemprop="description" content="<?php echo htmlencode($articlesRecord['short_description']) ?>">
<meta itemprop="image" content="<?php echo $open_graph_image; ?>">

<title><?php echo htmlencode($articlesRecord['title']) ?></title>
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<!-- Greensock -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/1.16.1/TweenMax.min.js"></script>
<!-- Google Web Fonts -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,800,600' rel='stylesheet' type='text/css'>
<!-- Styles -->
<link rel="stylesheet" href="../css/styles.css" />
</head>
<body>
	<div id="header">
		<div class="container">
			<div id="logo">
				<!-- Generator: Adobe Illustrator 18.1.1, SVG Export Plug-In  -->
				<svg version="1.1"
					 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/"
					 x="0px" y="0px" viewBox="0 0 608.3 236.8" xml:space="preserve">
				<defs>
				</defs>
				<g>
					<path fill="#ECC868" d="M217,67.6h-11.6V30.4h-10.5V19.9h32.6v10.5H217V67.6z"/>
					<path fill="#ECC868" d="M271.7,67.6H260V48.1h-13.5v19.5h-11.7V19.9h11.7v17.7H260V19.9h11.7V67.6z"/>
					<path fill="#ECC868" d="M282.1,67.6V19.9h11.7v47.7H282.1z"/>
					<path fill="#ECC868" d="M345.2,67.6H330L314.3,34H314c0.4,5.3,0.6,9.3,0.6,12.1v21.5h-10.3V19.9h15.2L335.1,53h0.2
						c-0.3-4.8-0.4-8.7-0.4-11.6V19.9h10.3V67.6z"/>
					<path fill="#ECC868" d="M392.4,67.6h-13.1l-8.5-18.2l-3.4,2.3v16h-11.7V19.9h11.7v20.7c0.6-1.3,1.8-3.3,3.6-6.1l9-14.6h12.7
						l-13.5,21.4L392.4,67.6z"/>
					<path fill="#FFFFFF" d="M198.1,94.7h15c5.8,0,10.2,1,13,2.9c2.8,1.9,4.2,4.9,4.2,9c0,2.7-0.6,5-1.9,6.9c-1.2,1.9-2.9,3.1-4.9,3.7
						v0.3c2.7,0.8,4.6,2.1,5.8,3.9s1.8,4.2,1.8,7.1c0,4.3-1.5,7.7-4.4,10.2c-2.9,2.5-6.9,3.7-12,3.7h-16.7V94.7z M209.7,113h3.5
						c1.7,0,3-0.4,3.9-1.1c0.9-0.8,1.4-1.9,1.4-3.4c0-2.7-1.8-4-5.5-4h-3.3V113z M209.7,122.4v10h4.1c3.6,0,5.4-1.7,5.4-5.1
						c0-1.6-0.5-2.8-1.5-3.7s-2.4-1.3-4.2-1.3H209.7z"/>
					<path fill="#FFFFFF" d="M265.3,142.4h-25.5V94.7h25.5V105h-13.9v7.5h12.9v10.3h-12.9v9h13.9V142.4z"/>
					<path fill="#FFFFFF" d="M285.5,142.4h-11.4V94.7h25.4V105h-14v9.1h12.9v10.3h-12.9V142.4z"/>
					<path fill="#FFFFFF" d="M347.9,118.5c0,8-1.8,14.1-5.3,18.3c-3.5,4.2-8.7,6.3-15.6,6.3c-6.7,0-11.9-2.1-15.5-6.3
						c-3.6-4.2-5.4-10.3-5.4-18.3c0-7.9,1.8-14,5.4-18.2c3.6-4.2,8.8-6.3,15.6-6.3c6.8,0,12,2.1,15.5,6.2
						C346.1,104.3,347.9,110.4,347.9,118.5z M318.3,118.5c0,9.2,2.9,13.8,8.7,13.8c2.9,0,5.1-1.1,6.5-3.4c1.4-2.2,2.1-5.7,2.1-10.5
						c0-4.8-0.7-8.3-2.2-10.6c-1.4-2.3-3.6-3.4-6.4-3.4C321.3,104.5,318.3,109.1,318.3,118.5z"/>
					<path fill="#FFFFFF" d="M368.5,125v17.4h-11.6V94.7h14.1c11.7,0,17.5,4.7,17.5,14.1c0,5.5-2.4,9.8-7.3,12.8l12.5,20.8h-13.2
						l-9.1-17.4H368.5z M368.5,115.3h2.2c4.1,0,6.1-2,6.1-6c0-3.3-2-4.9-6-4.9h-2.3V115.3z"/>
					<path fill="#FFFFFF" d="M424.3,142.4h-25.5V94.7h25.5V105h-13.9v7.5h12.9v10.3h-12.9v9h13.9V142.4z"/>
					<path fill="#FFFFFF" d="M213.4,187.1l7.4-17.7h12.6l-14.1,29.1v18.6h-11.7v-18.2l-14.1-29.5h12.6L213.4,187.1z"/>
					<path fill="#FFFFFF" d="M279.4,193.2c0,8-1.8,14.1-5.3,18.3c-3.5,4.2-8.7,6.3-15.6,6.3c-6.7,0-11.9-2.1-15.5-6.3
						c-3.6-4.2-5.4-10.3-5.4-18.3c0-7.9,1.8-14,5.4-18.2c3.6-4.2,8.8-6.3,15.6-6.3c6.8,0,12,2.1,15.5,6.2
						C277.7,179.1,279.4,185.2,279.4,193.2z M249.9,193.2c0,9.2,2.9,13.8,8.7,13.8c2.9,0,5.1-1.1,6.5-3.4c1.4-2.2,2.1-5.7,2.1-10.5
						c0-4.8-0.7-8.3-2.2-10.6c-1.4-2.3-3.6-3.4-6.4-3.4C252.8,179.3,249.9,183.9,249.9,193.2z"/>
					<path fill="#FFFFFF" d="M324.9,169.5v28.7c0,6.2-1.6,11.1-4.8,14.5c-3.2,3.4-7.8,5.1-13.8,5.1c-5.9,0-10.4-1.7-13.5-5
						c-3.1-3.3-4.7-8.1-4.7-14.4v-29h11.7v28c0,3.4,0.6,5.8,1.7,7.3c1.1,1.5,2.8,2.3,5,2.3c2.4,0,4.1-0.8,5.2-2.3c1.1-1.5,1.6-4,1.6-7.4
						v-27.9H324.9z"/>
					<path fill="#ECC868" d="M352,217.2v-47.7h11.6v37.3h16.5v10.4H352z"/>
					<path fill="#ECC868" d="M414.6,217.2l-2.1-8.9h-14l-2.2,8.9h-12.8l14-47.9h15.5l14.2,47.9H414.6z M410,197.7l-1.9-7.8
						c-0.4-1.7-1-4-1.6-6.8c-0.6-2.8-1-4.7-1.2-5.9c-0.2,1.1-0.5,2.9-1,5.5c-0.5,2.5-1.7,7.6-3.5,15H410z"/>
					<path fill="#ECC868" d="M469.6,169.5v28.7c0,6.2-1.6,11.1-4.8,14.5c-3.2,3.4-7.8,5.1-13.8,5.1c-5.9,0-10.4-1.7-13.5-5
						c-3.1-3.3-4.7-8.1-4.7-14.4v-29h11.7v28c0,3.4,0.6,5.8,1.7,7.3c1.1,1.5,2.8,2.3,5,2.3c2.4,0,4.1-0.8,5.2-2.3c1.1-1.5,1.6-4,1.6-7.4
						v-27.9H469.6z"/>
					<path fill="#ECC868" d="M520.8,217.2h-15.2l-15.7-33.6h-0.3c0.4,5.3,0.6,9.3,0.6,12.1v21.5h-10.3v-47.7H495l15.6,33.2h0.2
						c-0.3-4.8-0.4-8.7-0.4-11.6v-21.6h10.3V217.2z"/>
					<path fill="#ECC868" d="M550.4,179.3c-2.8,0-4.9,1.3-6.5,3.8c-1.5,2.5-2.3,6-2.3,10.4c0,9.2,3.1,13.8,9.4,13.8
						c1.9,0,3.7-0.3,5.5-0.9s3.6-1.3,5.4-2.1v10.9c-3.6,1.8-7.6,2.6-12.2,2.6c-6.5,0-11.5-2.1-14.9-6.3c-3.5-4.2-5.2-10.2-5.2-18.1
						c0-4.9,0.8-9.3,2.5-13c1.7-3.7,4.1-6.6,7.2-8.6c3.1-2,6.8-3,11.1-3c4.6,0,9.1,1.1,13.3,3.4l-3.6,10.1c-1.6-0.8-3.2-1.5-4.8-2.1
						C553.9,179.6,552.2,179.3,550.4,179.3z"/>
					<path fill="#ECC868" d="M608.3,217.2h-11.7v-19.5h-13.5v19.5h-11.7v-47.7h11.7v17.7h13.5v-17.7h11.7V217.2z"/>
				</g>
				<g>
					<g>
						<path fill="#FFFFFF" d="M0,88.9c0.4-2.1,0.7-4.1,1-6.2c1.9-14.7,6.8-28.2,15-40.5C30,20.9,49.7,7.6,74.4,1.4c2-0.5,4-0.9,6-1.2
							c3.5-0.6,6.2,0.6,7.5,3.4c1.4,2.9,1.1,6.2-1.3,8.2c-1.1,0.9-2.7,1.5-4.1,1.8c-16,2.9-30.2,9.6-42.1,20.7
							C23.4,50,14.5,69.7,13.9,93c-0.1,4,0.3,8,0.5,12c0.1,3-1.1,5.2-3.8,6.5c-2.4,1.2-6,0.9-7.6-1.3c-1.3-1.7-1.7-4.1-2.3-6.2
							c-0.4-1.1-0.4-2.2-0.6-3.3C0,96.8,0,92.9,0,88.9z"/>
						<path fill="#FFFFFF" d="M26.4,95.8c0.4-20.8,7.4-37.8,21.6-51.5C58.1,34.5,70.4,28.7,84.1,26c2.4-0.4,4.8-0.7,6.9,1.1
							c2.2,2,3,4.5,2.3,7.3c-0.7,2.9-2.8,4.3-5.6,4.8c-17,3.2-30.5,11.7-39.5,26.7c-6.7,11.1-8.9,23.1-7.6,35.9c0.4,4-2,7.1-5.6,7.5
							c-4.4,0.5-7.3-1.7-7.9-5.9C26.7,100.6,26.5,97.7,26.4,95.8z"/>
						<path fill="#FFFFFF" d="M91,51.5c3.8,0,6.7,2.6,7.1,6.4c0.4,3.6-2,6.6-5.7,7.3c-8.1,1.4-15,4.9-19.9,11.5
							c-4.6,6.2-6.7,13.2-5.9,21c0.2,1.4,0.2,2.9-0.1,4.3c-0.7,3.1-3.6,4.9-7.2,4.7c-3.2-0.2-5.7-2.3-6.2-5.4
							C49.4,79.8,64,57.7,85.3,52.7C87.2,52.2,89.1,51.9,91,51.5z"/>
						<path fill="#FFFFFF" d="M109.6,68.3c0.4-4.3,1.6-8.2,4.2-11.5c4.7-6.2,13.4-7.2,19.4-2.3c7.9,6.4,8.2,20.6,0.5,27.3
							c-7.4,6.4-18.2,3.8-22-5.5C110.7,73.8,110.3,71,109.6,68.3z"/>
						<path fill="#FFFFFF" d="M161,128.1c-1.1-8.3-2.5-16.6-5.2-24.6c-1.5-4.5-4-8-8.6-9.5c-3.2-1-6.6-2.1-10-2.3
							c-8.4-0.4-16.9-0.7-25.4-0.4c-3.9,0.1-7.9,1.4-11.7,2.5c-3.3,1-5.2,3.4-5.9,7c-1.5,7.9-3.4,15.8-5,23.8c-0.7,3.6-1.4,7.1-1.6,10.8
							c-0.2,3.8,1.6,5.5,5.3,5.8c2.7,0.2,5.4,0.3,8.1,0.2c1.6,0,2.1,0.4,2.2,2.1c0.3,13.6,0.6,27.2,0.9,40.7c0.4,17.5,0.7,35,1.1,52.6
							c3.9,0,7.9,0,11.8,0c1.2-16.2,2.4-32.5,3.6-48.7c0.4-5.2,0.9-10.5,1.1-15.7c0.1-1.9,1.1-2.9,2.5-3c1.6-0.1,1.9,1.4,2,2.8
							c1.2,14.4,2.3,28.8,3.6,43.2c0.6,7.1,1.4,14.3,2.1,21.4c3.8,0,7.6,0,11.4,0c-0.1-0.9-0.2-1.8-0.2-2.6c0.1-10.4,0.4-20.7,0.5-31.1
							c0.2-13.1,0.3-26.1,0.5-39.2c0.1-6.8,0.3-13.6,0.4-20.4c0-1.7,0.7-2.1,2.2-2.1c3.2,0.1,6.4,0,9.6,0c3.3,0,5.4-1.9,5.4-5.2
							C161.7,133.5,161.4,130.8,161,128.1z M137.8,144.6c-0.4,0.9-2.1,1.6-3.2,1.6c-6.7,0-13.4,0-20.1-0.3c-1,0-2.8-0.6-2.9-1.1
							c-0.3-1.5,0-3.2,0.4-4.8c0.2-0.6,1.1-1.3,1.8-1.5c2.7-0.8,2.9-3,3.2-5.2c0.3-1.6-0.5-2.4-2.2-2.5c-3.4-0.1-3.4-0.2-3.4-3.6
							c0-1.4,0-2.9,0-4.4c0.1-2.5,0.8-3.2,3.3-3.3c2.8,0,5.5,0,8.3,0c-0.1-2-0.1-3.6-0.4-5.1c-0.1-0.9-0.4-1.8-0.9-2.5
							c-1.3-1.8-1.4-4.4-0.1-5.8c1.4-1.5,4.2-1.6,5.8-0.3c1.5,1.4,1.6,3.8,0.4,5.8c-0.6,1-0.9,2.2-1.1,3.3c-0.2,1.3-0.2,2.7-0.4,4.6
							c1.2,0,2.6,0,4,0c1.9,0,3.8,0.1,5.7,0.3c1.4,0.1,2,0.9,2,2.4c-0.1,1.6,0,3.2,0,4.8c0,2.9-0.7,3.5-3.5,3.5c-2.9,0-2.6,0-2.3,2.9
							c0.2,2.6,1.4,3.8,3.5,5C137.8,139.6,138.9,142.5,137.8,144.6z"/>
					</g>
				</g>
				</svg>
			</div>
			<div id="navigation-wrapper" class="clearfix">
				<div id="navigation-button">
					<!-- Generator: Adobe Illustrator 18.1.1, SVG Export Plug-In  -->
					<svg version="1.1"
						 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/"
						 x="0px" y="0px" viewBox="0 0 123 90" xml:space="preserve">
					<defs>
					</defs>
					<rect x="0" y="0" fill="#FFFFFF" width="123" height="16.7"/>
					<rect x="0" y="36.7" fill="#FFFFFF" width="123" height="16.7"/>
					<rect x="0" y="73.3" fill="#FFFFFF" width="123" height="16.7"/>
					</svg>

				</div>
				<div id="follow">
					<a href="<?php echo htmlencode($contact_infoRecord['facebook_url']) ?>" target="_blank">
						<!-- Generator: Adobe Illustrator 18.1.1, SVG Export Plug-In  -->
						<svg version="1.1"
							 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/"
							 x="0px" y="0px" viewBox="0 0 39.7 39.7" xml:space="preserve">
						<defs>
						</defs>
						<g>
							<path d="M19.9,0C8.9,0,0,8.9,0,19.9c0,11,8.9,19.9,19.9,19.9c11,0,19.9-8.9,19.9-19.9C39.7,8.9,30.8,0,19.9,0L19.9,0z M24.8,20.6
								h-3.2v11.5h-4.8V20.6h-2.3v-4.1h2.3v-2.6c0-1.9,0.9-4.8,4.8-4.8l3.5,0v4h-2.6c-0.4,0-1,0.2-1,1.1v2.4h3.6L24.8,20.6z M24.8,20.6"/>
						</g>
						</svg>
						Connect With Us <span class="no-mobile">on Facebook</span>
					</a>
				</div>
				<div id="navigation">
					<ul>
						<li><a href="../#main-image">Home</a></li>
						<li><a href="../#news-and-multimedia">News &amp; Media</a></li>
						<li><a href="../#organizations">Organizations</a></li>
						<li><a href="../#about-blurb">About Us</a></li>
						<li><a href="#contact">Contact Us</a></li>
						<li>
							<a href="#" id="download-btn">
								<div class="accent-bg">Download Infographic</div>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div id="news-header">
		<div class="container">
			<div id="news-photo">
				<?php $imgFlag = ''; ?>
				<?php foreach ($articlesRecord['main_image'] as $index => $upload): ?>
					<?php $imgFlag = 'img'; ?>
					<img src="<?php echo htmlencode($upload['urlPath']) ?>" />
				<?php endforeach; ?>
				<div id="news-photo-copy" class="<?php echo $imgFlag; ?>">
					<div id="news-photo-headline"><?php echo htmlencode($articlesRecord['title']) ?></div>
					<div id="news-photo-date"><?php echo date("F jS, Y", strtotime($articlesRecord['date'])) ?></div>
				</div>
			</div>
		</div>
	</div>
	<div id="news-content">
		<div class="container">
			<?php echo $articlesRecord['content'] ?>
		</div>
	</div>
	<div id="news-comments">
		<div class="container">
			<div id="disqus_thread"></div>
			<script type="text/javascript">
			    /* * * CONFIGURATION VARIABLES * * */
			    var disqus_shortname = 'thinkbeforeyoulaunch';
			    
			    /* * * DON'T EDIT BELOW THIS LINE * * */
			    (function() {
			        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
			        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
			        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
			    })();
			</script>
			<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
		</div>
	</div>
	<?php include "../includes/footer.php"; ?>
</body>
</html>