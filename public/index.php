<?php include "includes/cms.php";

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

  // load records from 'news_categories'
  list($news_categoriesRecords, $news_categoriesMetaData) = getRecords(array(
    'tableName'   => 'news_categories',
    'loadUploads' => true,
    'allowSearch' => false,
  ));

  // load records from 'articles'
  list($articlesRecords, $articlesMetaData) = getRecords(array(
    'tableName'   => 'articles',
    'loadUploads' => true,
    'allowSearch' => false,
  ));

  // load records from 'photo_and_video_links'
  list($photo_and_video_linksRecords, $photo_and_video_linksMetaData) = getRecords(array(
    'tableName'   => 'photo_and_video_links',
    'loadUploads' => true,
    'allowSearch' => false,
  ));

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

  // load records from 'organization_listings'
  list($organization_listingsRecords, $organization_listingsMetaData) = getRecords(array(
    'tableName'   => 'organization_listings',
    'loadUploads' => true,
    'allowSearch' => false,
  ));

  foreach ($homepage_contentRecord['open_graph_image'] as $index => $upload){
  	$open_graph_image = htmlencode($upload['urlPath']);
  }

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="initial-scale=1, maximum-scale=1, minimal-ui">

<meta property="og:title" content="<?php echo htmlencode($homepage_contentRecord['title_tag']) ?>" />
<meta property="og:site_name" content="<?php echo htmlencode($homepage_contentRecord['title_tag']) ?>" />
<meta property="og:image" content="<?php echo $open_graph_image; ?>" />
<meta property="og:description" content="<?php echo htmlencode($homepage_contentRecord['description_tag']) ?>" />
<meta property="og:url" content="http://www.thinkbeforeyoulaunch.com/" />

<!-- Update your html tag to include the itemscope and itemtype attributes. -->
<html itemscope itemtype="http://schema.org/Organization">

<!-- Add the following three tags inside head. -->
<meta itemprop="name" content="<?php echo htmlencode($homepage_contentRecord['title_tag']) ?>">
<meta itemprop="description" content="<?php echo htmlencode($homepage_contentRecord['description_tag']) ?>">
<meta itemprop="image" content="<?php echo $open_graph_image; ?>">

<title><?php echo htmlencode($homepage_contentRecord['title_tag']) ?></title>
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<!-- Greensock -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/1.16.1/TweenMax.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/1.17.0/utils/Draggable.min.js"></script>
<script src="js/ThrowPropsPlugin.min.js"></script>
<script src="libs/magnific-popup/jquery.magnific-popup.min.js"></script>
<!-- Google Web Fonts -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,800,600' rel='stylesheet' type='text/css'>
<link href='libs/magnific-popup/magnific-popup.css' rel='stylesheet' type='text/css'>
<!-- Styles -->
<link rel="stylesheet" href="css/styles.css" />
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
						<li><a href="#main-image">Home</a></li>
						<li><a href="#news-and-multimedia">News &amp; Media</a></li>
						<li><a href="#organizations">Organizations</a></li>
						<li><a href="#about-blurb">About Us</a></li>
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
	<div id="main-image">
		<div class="container">
			<div id="hero-drone">
				<?php
					foreach ($homepage_contentRecord['drone_image'] as $index => $upload){
						$drone_image = htmlencode($upload['urlPath']);
					}
				?>
				<br />
				<img src="<?php echo $drone_image ?>" />
			</div>
			<div id="main-text" class="clearfix">
				<div id="main-headline"><?php echo $homepage_contentRecord['headline'] ?></div>
				<div id="main-subhead">
					<div id="main-subhead-left">
						<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" viewBox="0 0 14 24" xml:space="preserve"><polygon points="14,24 14,0 0,0 "/></svg>
						<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" viewBox="0 0 14 24" xml:space="preserve"><polygon points="14,0 14,24 0,24 "/></svg>
					</div>
					<div id="main-subhead-center">
						<?php echo strip_tags($homepage_contentRecord['subhead'], '<em><em/><strong><strong/>'); ?>
					</div>
					<div id="main-subhead-right">
						<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" viewBox="0 0 14 24" xml:space="preserve"><polygon points="0,24 0,0 14,0 "/></svg>
						<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" viewBox="0 0 14 24" xml:space="preserve"><polygon points="0,0 0,24 14,24 "/></svg>
					</div>
				</div>
			</div>
			<div id="main-scroll-indicator">
				<a href="#about-blurb">
					<?php echo htmlencode($homepage_contentRecord['scroll_indicator']) ?>
					<svg version="1.1"
						 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" x="0px" y="0px" viewBox="0 0 177 105.3" xml:space="preserve">
					<defs>
					<filter id="drop-shadow">
						<feGaussianBlur in="SourceAlpha" stdDeviation="4"/>
						<feOffset dx="14" dy="14" result="offsetblur"/>
						<feFlood flood-color="rgba(0,0,0,0.4)"/>
						<feComposite in2="offsetblur" operator="in"/>
						<feMerge>
							<feMergeNode/>
							<feMergeNode in="SourceGraphic"/>
						</feMerge>
					</filter>
					</defs>
					<polygon fill="#FFFFFF" points="88.5,66.7 0,0 0,38.7 88.5,105.3 177,38.7 177,0 " filter="url(#drop-shadow)"/>
					</svg>
				</a>
			</div>
		</div>
	</div>
	<div id="about-blurb">
		<div class="container">
			<h3><?php echo htmlencode($homepage_contentRecord['mission_headline']) ?></h3>
			<?php echo $homepage_contentRecord['mission_content']; ?>
		</div>
	</div>
	<div id="news-and-multimedia">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<h3><?php echo htmlencode($homepage_contentRecord['news_headline']) ?></h3>
					<div class="news">
						<div class="page clearfix">
							<?php $newsCounter = 0; ?>
							<?php foreach ($articlesRecords as $record): ?>
								<?php if ($newsCounter > 2){
									continue;
								} else {
									$newsCounter++;
									if (@$record['link_to_article']){
										$newsLink = $record['article_url'] . '" target="_blank';
									} else {
										$newsLink = 'news/?num=' . htmlencode($record['num']);
									}
								} ?>
								<a href="<?php echo $newsLink ?>" class="entry clearfix">
									<?php if (@$record['thumbnail']): ?>
										<?php foreach ($record['thumbnail'] as $index => $upload): ?>
											<img src="<?php echo htmlencode($upload['urlPath']) ?>" />
										<?php endforeach; ?>
									<?php endif; ?>
									<div class="headline"><?php echo htmlencode($record['title']) ?></div>
									<div class="subhead"><?php echo date("F jS, Y", strtotime($record['date'])) ?></div>
								</a>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="view-more" id="news-view-more">More News</div>
				</div>
				<div class="col-md-12 col-sm-12">
					<h3><?php echo htmlencode($homepage_contentRecord['photos_headline']) ?></h3>
					<div class="media">
						<div class="page clearfix">
							<?php 
								function getVimeoInfo($id, $info = 'thumbnail_medium') {
									if (!function_exists('curl_init')) die('CURL is not installed!');
									$ch = curl_init();
									curl_setopt($ch, CURLOPT_URL, "http://vimeo.com/api/v2/video/$id.php");
									curl_setopt($ch, CURLOPT_HEADER, 0);
									curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
									curl_setopt($ch, CURLOPT_TIMEOUT, 10);
									$output = unserialize(curl_exec($ch));
									$output = $output[0][$info];
									curl_close($ch);
									return $output;
								}
							?>
							<?php foreach ($photo_and_video_linksRecords as $record): ?>
								<?php

									if (@$record['photo_upload']){
										foreach ($record['photo_upload'] as $index => $upload):
											$imgLocation = $upload['urlPath'];
											$imgUrl = $upload['urlPath'];
											$imgType = '';
											$imgTitle = $record['title'];
										endforeach;
									} else if (@$record['photo_url']){
										$imgLocation = $record['photo_url'];
										$imgUrl = $record['photo_url'];
										$imgType = '';
										$imgTitle = $record['title'];
									} else if (@$record['youtube_video_id']){
										$imgLocation = 'http://img.youtube.com/vi/' . $record['youtube_video_id'] . '/mqdefault.jpg';
										$imgUrl = 'http://www.youtube.com/?v=' . $record['youtube_video_id'];
										$imgType = ' mfp-iframe"';
										$imgTitle = '';
									} else if (@$record['vimeo_video_id']){
										$imgLocation = getVimeoInfo($record['vimeo_video_id']);
										$imgUrl = 'http://www.vimeo.com/' . $record['vimeo_video_id'];
										$imgType = ' mfp-iframe"';
										$imgTitle = '';

									} else {
										continue;
									}
								?>
								<div class="media-item">
									<a href="<?php echo $imgUrl; ?>" class="entry<?php echo $imgType; ?>" style="background-image:url('<?php echo $imgLocation; ?>');">
									</a>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="view-more" id="media-view-more">More Media</div>
				</div>
			</div>
		</div>
	</div>
	<div id="animation-invisible">
		<div class="container">
			<div id="animated-drone-invisible-copy">
				<div class="copy">
					<?php
						foreach ($homepage_contentRecord['invisible_drone_icon'] as $index => $upload){
							$invisible_drone_icon = htmlencode($upload['urlPath']);
						}
					?>
					<br />
					<img src="<?php echo $invisible_drone_icon ?>" />
					<?php echo $homepage_contentRecord['invisible_drone_copy']; ?>
				</div>
			</div>
			<div id="animated-drone-invisible">
				<svg version="1.1"
					 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/"
					 x="0px" y="0px" viewBox="0 0 469.9 341.8" enable-background="new 0 0 469.9 341.8"
					 xml:space="preserve" id="animated-drone">
					<defs>
					</defs>
					<g>
						<g>
							<g>
								<ellipse transform="matrix(0.9965 -8.372144e-002 8.372144e-002 0.9965 -6.8147 9.0511)" fill="none" stroke="#FFFFFF" stroke-width="1.75" stroke-miterlimit="10" stroke-dasharray="6.9392,5.9479" cx="104.5" cy="85.8" rx="84.8" ry="52.8"/>
							</g>
							<g>
								<ellipse transform="matrix(0.9965 8.370892e-002 -8.370892e-002 0.9965 5.6785 -23.4465)" fill="none" stroke="#FFFFFF" stroke-width="1.75" stroke-miterlimit="10" stroke-dasharray="7.039,6.0334" cx="282.4" cy="56" rx="80.1" ry="46.7"/>
							</g>
							<g>
								<path fill="none" stroke="#FFFFFF" stroke-width="1.75" stroke-miterlimit="10" stroke-dasharray="7.056,6.048" d="M456.7,217.4
									c-11.8,36.5-65.7,53.4-118.3,36.4c-52.6-16.9-83.4-59.8-71.7-96.3c11.8-36.5,63.5-53.8,116.1-36.9
									C435.3,137.6,468.4,180.9,456.7,217.4z"/>
							</g>
							<g>
								<path fill="none" stroke="#FFFFFF" stroke-width="1.75" stroke-miterlimit="10" stroke-dasharray="7.033,6.0283" d="M253.1,227.6
									c2.5,45.5-45.2,86.7-104.6,89.9c-59.4,3.2-107.1-31.4-109.6-76.9c-2.5-45.5,42.7-86.2,102.1-89.5
									C200.4,147.9,250.6,182.1,253.1,227.6z"/>
							</g>
							<g>
								<g>
									<path fill="none" stroke="#FFFFFF" stroke-width="1.75" stroke-miterlimit="10" stroke-dasharray="7.0062,6.0053" d="
										M380.7,110.9c-13.6-3.7-15.6-2.4-17.4-10.9c-1.6-11.2,13.5-17.2,14.9-34.6c2.6-31.1-39.2-62.1-91.1-64.3
										c-84-3.4-87.4,37.9-98.9,39.7c-7.9,3.9-29.4-14-68.7-16.8C59.3,19.6,0.9,48.3,0.9,87.8c-0.1,60.8,65.1,56,66,73.7
										c1.5,13-46.1,19.7-42.9,85.9c2.7,54.8,58.5,98.9,127.2,93c105-9,98.9-75.2,125.3-82.8c24.6-6.4,31.7,11.6,57.2,18.6
										c59.9,16.4,120.6-8.3,133-53.6C479.1,177.3,440.6,127.3,380.7,110.9z"/>
								</g>
							</g>
							<g>
								<ellipse transform="matrix(0.9965 -8.374017e-002 8.374017e-002 0.9965 -10.1128 19.4419)" fill="none" stroke="#FFFFFF" stroke-width="1.75" stroke-miterlimit="10" stroke-dasharray="7.1704,6.146" cx="226.7" cy="130.3" rx="33.5" ry="20.9"/>
							</g>
						</g>
						<path fill="none" stroke="#FFFFFF" stroke-width="1.75" stroke-miterlimit="10" stroke-dasharray="7,6" d="M141.5,227.2l3.3-11.5
							l30.7-45.1c0,0,9-1,16.3,3.2c0.7,0.4-22.4,46.1-22.4,46.1s-11.1,2.4-16.7,8.8c-4.4,5-40.7,64-40.7,64l-16.8,0.6
							c0,0,26.7-45.8,31.8-53.8C129.8,235.2,138,232.4,141.5,227.2z"/>
						<path fill="none" stroke="#FFFFFF" stroke-width="1.75" stroke-miterlimit="10" stroke-dasharray="7,6" d="M366.5,178.3l12.4-3.8
							l58.3,0.7c0,0,5.8,7.4,6,16.6c0,0.8-54.6,7.4-54.6,7.4s-8.3-8.6-17.2-9.8c-7-0.9-81,1.6-81,1.6l-9.7-14.8c0,0,56.7-3.4,66.8-3.5
							C352.8,172.5,359.8,178.2,366.5,178.3z"/>
						<path fill="none" stroke="#FFFFFF" stroke-width="1.75" stroke-miterlimit="10" stroke-dasharray="7,6" d="M287.2,55.4l9.6-0.6
							l42.1,10.8c0,0,2.9,6.4,1.4,13.1c-0.1,0.6-40.9-4.3-40.9-4.3s-4.5-7.7-10.8-10.1c-4.9-1.9-59-13.1-59-13.1l-4.4-12.4
							c0,0,41.7,7.5,49.1,9.2C278.3,48.8,282.3,54.2,287.2,55.4z"/>
						<path fill="none" stroke="#FFFFFF" stroke-width="1.75" stroke-miterlimit="10" stroke-dasharray="7,6" d="M102.5,84.5l6.4-3.6
							l22.5-24.5c0,0-0.8-5.3-4.5-8.9c-0.3-0.3-24.4,19.8-24.4,19.8s0.3,6.8-2.7,11c-2.4,3.3-32.4,33-32.4,33l2.3,9.8
							c0,0,23.5-22.2,27.6-26.3C99.6,92.4,99.9,87.3,102.5,84.5z"/>
					</g>
				</svg>
			</div>
		</div>
	</div>
	<div class="container">
		<div id="airspace-headline">
			<h3><?php echo htmlencode($homepage_contentRecord['airspace_headline']) ?></h3>
		</div>
	</div>
	<div id="airspace">
		<div id="airspace-items" class="clearfix">
			<div class="airspace-item col-xs-12 col-sm-8 col-md-4">
				<div class="airspace-item-wrapper">
					<div class="airspace-item-content">
						<!-- Generator: Adobe Illustrator 18.1.1, SVG Export Plug-In  -->
						<svg version="1.1"
							 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/"
							 x="0px" y="0px" viewBox="0 0 59 59" xml:space="preserve">
						<defs>
						</defs>
						<polygon fill="#2C3A49" points="21,0 21,21 0,21 0,38 21,38 21,59 38,59 38,38 59,38 59,21 38,21 38,0 "/>
						</svg>
						Police and First Responder Aircraft
					</div>
				</div>
			</div>
			<div class="airspace-item col-xs-12 col-sm-8 col-md-4">
				<div class="airspace-item-wrapper">
					<div class="airspace-item-content">
						<!-- Generator: Adobe Illustrator 18.1.1, SVG Export Plug-In  -->
						<svg version="1.1"
							 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/"
							 x="0px" y="0px" viewBox="0 0 89.5 68.9" xml:space="preserve">
						<defs>
						</defs>
						<path fill="#2C3A49" d="M0,41h19.6c0,0,3.7,0.2,4.2,6.9c1.4,18.5,7.2,20.9,7.2,20.9s-0.8-26.5,7.3-27.3c4.6-0.4,13.3-0.4,13.3-0.4
							L45,37.3V36h-7.6c0,0,4-6.5,0.8-16.7C36.2,12.4,43,7.1,41.3,0c-2.8,5.4-13.7,9.3-13.8,20.7c0,10.5-4.5,16.2-10.5,16.2
							c-9.5,0-10.4-2.6-13.2-1.4C1.1,36.6,0,41,0,41"/>
						<path fill="#2C3A49" d="M78.1,49c0.5-8.5-1.2-13.6-5.3-19.7c10.7-3.2,16.7-9.5,16.7-9.5s-2.5,0-13.7,0c-8.3,0-10.3,1.6-13.2,3.6
							c-2.2,1.5-5.3,2.7-9,2.7c-3.7,0-6.1-1.5-8.1-0.8c-2,0.7-2.8,3.5-2.8,3.5H55c0,0,3.6-0.6,4.5,3.5c0,0,3.5,10.1,9.4,13.4
							c0.9-1.8,1.3-3.9,1.3-3.9S75.3,47.5,78.1,49"/>
						</svg>
						Birds
					</div>
				</div>
			</div>
			<div class="airspace-item col-xs-12 col-sm-8 col-md-4">
				<div class="airspace-item-wrapper">
					<div class="airspace-item-content">
						<!-- Generator: Adobe Illustrator 18.1.1, SVG Export Plug-In  -->
						<svg version="1.1"
							 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/"
							 x="0px" y="0px"viewBox="0 0 54 63.5" xml:space="preserve">
						<defs>
						</defs>
						<path fill="#2C3A49" d="M16.8,63.5c0,0-30.6-4.2-9.2-42.6c2.6,3.7,3.3,7.8,3.3,7.8S22.5,20.9,21.4,0c9.5,3,17.9,14.4,18.1,22.3
							c0,0,2.7-5.1,2.5-8.5c6.7,4.7,15.7,17.9,10.3,35.4c-6.2,14.4-15.7,14.3-15.7,14.3s12.9-15.2-9-30.6c0,0,3.5,11.3-4.1,16.3
							c-3.7-3.7-3.7-8-3.7-8S8.3,51,16.8,63.5"/>
						</svg>
						Aerial Firefighters
					</div>
				</div>
			</div>
			<div class="airspace-item col-xs-12 col-sm-8 col-md-4">
				<div class="airspace-item-wrapper">
					<div class="airspace-item-content">
						<!-- Generator: Adobe Illustrator 18.1.1, SVG Export Plug-In  -->
						<svg version="1.1"
							 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/"
							 x="0px" y="0px" viewBox="0 0 35.7 64.1" xml:space="preserve">
						<defs>
						</defs>
						<path fill="#2C3A49" d="M22.2,12.6c0,3.8-2.4,6.8-5.4,6.8c-3,0-5.4-3-5.4-6.8C11.3,6.2,16.7,0,16.7,0S22.2,5.1,22.2,12.6"/>
						<path fill="#2C3A49" d="M28.8,44.2C25,47,20,46.4,18,43.3c-2-3.1-0.7-8.3,3.6-10.2c6.9-3.1,14-4.3,14-4.3S35.7,39.1,28.8,44.2"/>
						<path fill="#2C3A49" d="M28.5,61.5c-3.6,3.4-8.9,3.4-11.4,0.5c-2.5-2.9-1.8-8.5,2.4-11.1c6.7-4.1,14-6.3,14-6.3S35,55.2,28.5,61.5"
							/>
						<path fill="#2C3A49" d="M5.2,58.5c3.6,3.4,8.9,3.4,11.4,0.5c2.5-2.9,1.8-8.5-2.4-11.1c-6.7-4.1-14-6.3-14-6.3S-1.3,52.3,5.2,58.5"/>
						<path fill="#2C3A49" d="M27.4,29.1c-3.3,2.5-7.8,2-9.5-0.7c-1.8-2.7-0.7-7.3,3.1-9c6-2.8,12.3-3.9,12.3-3.9S33.4,24.5,27.4,29.1"/>
						<path fill="#2C3A49" d="M4.8,41.7c3.1,3,7.8,3,9.9,0.4c2.2-2.5,1.6-7.4-2.1-9.7c-5.9-3.6-12.2-5.5-12.2-5.5S-0.8,36.2,4.8,41.7"/>
						<path fill="#2C3A49" d="M6.4,28c2.7,2.6,6.8,2.6,8.7,0.4c1.9-2.2,1.4-6.5-1.9-8.5C8.1,16.8,2.6,15,2.6,15S1.4,23.2,6.4,28"/>
						</svg>

						Aerial Applicators / Crop Sprayers
					</div>
				</div>
			</div>
			<div class="airspace-item col-xs-12 col-sm-8 col-md-4">
				<div class="airspace-item-wrapper">
					<div class="airspace-item-content">
						<!-- Generator: Adobe Illustrator 18.1.1, SVG Export Plug-In  -->
						<svg version="1.1"
							 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/"
							 x="0px" y="0px" viewBox="0 0 25.8 17.9" xml:space="preserve">
						<defs>
						</defs>
						<g>
							<path d="M8.5,13.6c0.7,1.5,1.8,2.9,3.2,4.3c-2.8-0.4-5.1-2-6.4-4.3L8.5,13.6z M11.6,0.1c-2.6,0.4-4.9,2-6.3,4.2l3.2,0
								C9.2,2.8,10.2,1.4,11.6,0.1L11.6,0.1z M12.6,4.3l0-4.3h0C11.2,1.3,10,2.8,9.2,4.3L12.6,4.3z M5.3,5.7l-0.6,0L4,5.7L4,10.2L1.5,5.6
								l-0.7,0l-0.7,0L0,12l0.6,0l0.6,0l0.1-4.6l2.6,4.6l0.7,0l0.7,0L5.3,5.7z M11.3,6.9l0-0.6l0-0.6l-4.7,0l-0.1,6.4l4.9,0.1l0-0.6l0-0.6
								l-3.5,0l0-1.7l3.1,0l0-0.6l0-0.6l-3.1,0l0-1.4L11.3,6.9z M17.7,10.4l-0.9-4.7l-0.7,0l-0.7,0l-1,4.7l-1-4.7l-1.4,0l1.7,6.4l0.6,0
								l0.6,0l1.1-5l1,5l0.6,0l0.6,0l1.8-6.4l-1.4,0L17.7,10.4z M13.4,0L13.4,0l-0.1,4.3l3.4,0C16,2.8,14.9,1.4,13.4,0L13.4,0z M20.7,4.4
								c-1.3-2.2-3.6-3.8-6.2-4.3c1.3,1.3,2.3,2.8,3,4.3L20.7,4.4z M14,17.9c2.8-0.3,5.1-1.9,6.5-4.2l-3.3,0C16.5,15.2,15.5,16.6,14,17.9
								L14,17.9z M16.5,13.7l-3.3,0l0,4.1C14.6,16.5,15.8,15.1,16.5,13.7L16.5,13.7z M25.4,9.2c-0.3-0.3-0.9-0.5-1.9-0.7
								c-0.6-0.2-1.1-0.3-1.3-0.4C22,8,21.9,7.8,21.9,7.6c0-0.3,0.1-0.5,0.3-0.6c0.2-0.1,0.5-0.2,0.8-0.2c0.4,0,0.7,0.1,1,0.3
								c0.2,0.2,0.4,0.4,0.4,0.7l1.3,0c0-0.6-0.3-1.2-0.7-1.5c-0.4-0.4-1-0.6-1.7-0.6c-0.8,0-1.4,0.2-1.8,0.5c-0.5,0.4-0.7,0.9-0.7,1.5
								c0,0.6,0.2,1,0.5,1.2c0.3,0.3,1,0.5,2,0.8c0.6,0.1,0.9,0.3,1.1,0.4c0.2,0.1,0.3,0.3,0.2,0.5c0,0.2-0.1,0.4-0.4,0.6
								c-0.2,0.1-0.6,0.2-1,0.2c-0.4,0-0.7-0.1-1-0.3c-0.2-0.2-0.4-0.4-0.4-0.8l-1.3,0c0,0.7,0.3,1.2,0.7,1.6c0.5,0.4,1.1,0.6,1.9,0.6
								c0.8,0,1.4-0.2,1.9-0.5c0.5-0.3,0.7-0.8,0.7-1.4C25.8,9.9,25.7,9.5,25.4,9.2L25.4,9.2z M12.5,17.8l0-4.1l-3.3,0
								C10,15.1,11.1,16.5,12.5,17.8L12.5,17.8z M12.5,17.8"/>
						</g>
						</svg>
						News Helicopters
					</div>
				</div>
			</div>
			<div class="airspace-item col-xs-12 col-sm-8 col-md-4">
				<div class="airspace-item-wrapper">
					<div class="airspace-item-content">
						<!-- Generator: Adobe Illustrator 18.1.1, SVG Export Plug-In  -->
						<svg version="1.1"
							 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/"
							 x="0px" y="0px" viewBox="0 0 61 55.8" xml:space="preserve">
						<defs>
						</defs>
						<path fill="#2C3A49" d="M61,42.7v-7.9L34,19.3V4.1C34,1.9,31.4,0,29.5,0S25,1.9,25,4.1v16.3L0,34.8v7.9l25-9v11.7L19,51v4.8
							l10.8-3.6L40,55.8V51l-6-5V33L61,42.7z"/>
						</svg>
						General Aviation Aircraft
					</div>
				</div>
			</div>
		</div>
		<div class="accent-button">Learn More</div>
	</div>
	<div id="damage">
		<div class="container">
			<div id="damage-image">
				<!-- Generator: Adobe Illustrator 18.1.1, SVG Export Plug-In  -->
				<svg version="1.1"
					 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/"
					 x="0px" y="0px" viewBox="0 0 451 446" enable-background="new 0 0 451 446" xml:space="preserve">
				<defs>
				</defs>
				<g>
					<g>
						<g>
							<polygon fill="#FFFFFF" points="210,140.1 210,128.1 110,122.6 110,45.6 168,48.8 168,37.8 110,34.6 110,0 98,0 98,33.9 40,30.7 
								40,41.7 98,44.9 98,121.9 0,116.5 0,128.5 98,133.9 98,206.9 29,203.1 29,215.1 98,218.9 98,446 110,446 110,219.6 181,223.5 
								181,211.5 110,207.6 110,134.6 			"/>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="61,63.9 58,63.7 58,42.7 61,42.9 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="67,51.2 52,50.3 52,47.3 67,48.2 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="67,57.2 52,56.3 52,52.3 67,53.2 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="67,63.2 52,62.3 52,57.3 67,58.2 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="152,68.9 148,68.7 148,47.7 152,47.9 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="158,56.2 142,55.4 142,52.4 158,53.2 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="158,62.2 142,61.4 142,57.4 158,58.2 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="158,68.2 142,67.4 142,62.4 158,63.2 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="52,237.3 49,237.2 49,216.2 52,216.3 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="58,223.7 43,222.8 43,218.8 58,219.7 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="58,228.7 43,227.8 43,224.8 58,225.7 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="58,234.7 43,233.8 43,230.8 58,231.7 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="162,243.5 158,243.2 158,222.2 162,222.5 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="168,229.8 152,228.9 152,224.9 168,225.8 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="168,234.8 152,233.9 152,230.9 168,231.8 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="168,240.8 152,239.9 152,236.9 168,237.8 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="18,150.5 13,150.2 13,129.2 18,129.5 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="24,136.8 8,135.9 8,132.9 24,133.8 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="24,142.8 8,141.9 8,138.9 24,139.8 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="24,147.8 8,146.9 8,144.9 24,145.8 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="195,160.3 191,160.1 191,139.1 195,139.3 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="200,146.6 185,145.7 185,142.7 200,143.6 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="200,152.6 185,151.7 185,148.7 200,149.6 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="200,157.6 185,156.7 185,154.7 200,155.6 				"/>
							</g>
						</g>
						<g>
							<polygon fill="#FFFFFF" points="100.3,246.1 71.8,213.7 77.4,208.8 106,241.1 			"/>
						</g>
						<g>
							<polygon fill="#FFFFFF" points="100.3,161.4 71.8,129 77.4,124.1 106,156.5 			"/>
						</g>
						<g>
							<polygon fill="#FFFFFF" points="100.3,72.9 71.8,40.5 77.4,35.6 106,67.9 			"/>
						</g>
						<g>
							<polygon fill="#FFFFFF" points="108.2,246.5 102.6,240.9 131.1,211.7 136.8,217.3 			"/>
						</g>
						<g>
							<polygon fill="#FFFFFF" points="108.2,161.8 102.6,156.3 131.1,127.1 136.8,132.6 			"/>
						</g>
						<g>
							<polygon fill="#FFFFFF" points="108.2,73.3 102.6,67.8 131.1,38.5 136.8,44.1 			"/>
						</g>
					</g>
					<g>
						<g>
							<polygon fill="#FFFFFF" points="451,246.5 451,238.5 382,234.7 382,181.7 422,183.9 422,175.9 382,173.7 382,150 374,150 
								374,173.3 334,171 334,179 374,181.3 374,234.3 307,230.5 307,238.5 374,242.3 374,292.3 327,289.6 327,297.6 374,300.3 374,446 
								382,446 382,300.7 431,303.4 431,295.4 382,292.7 382,242.7 			"/>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="349,193.9 347,193.8 347,179.8 349,179.9 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="353,185.1 343,184.5 343,182.5 353,183.1 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="353,189.1 343,188.5 343,186.5 353,187.1 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="353,193.1 343,192.5 343,189.5 353,190.1 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="411,197.3 408,197.2 408,183.2 411,183.3 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="415,188.5 404,187.9 404,185.9 415,186.5 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="415,192.5 404,191.9 404,189.9 415,190.5 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="415,196.5 404,195.9 404,192.9 415,193.5 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="343,313.5 340,313.4 340,298.4 343,298.5 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="347,303.8 336,303.1 336,300.1 347,300.8 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="347,306.8 336,306.1 336,304.1 347,304.8 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="347,310.8 336,310.1 336,308.1 347,308.8 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="418,317.7 415,317.5 415,302.5 418,302.7 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="422,307.9 411,307.3 411,304.3 422,304.9 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="422,310.9 411,310.3 411,308.3 422,308.9 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="422,314.9 411,314.3 411,312.3 422,312.9 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="319,253.2 316,253 316,239 319,239.2 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="323,244.4 312,243.8 312,241.8 323,242.4 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="323,248.4 312,247.8 312,245.8 323,246.4 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="323,251.4 312,250.8 312,249.8 323,250.4 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="441,260 438,259.8 438,245.8 441,246 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="444,251.2 434,250.6 434,248.6 444,249.2 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="444,255.2 434,254.6 434,252.6 444,253.2 				"/>
							</g>
						</g>
						<g>
							<g>
								<polygon fill="#FFFFFF" points="444,258.2 434,257.6 434,256.6 444,257.2 				"/>
							</g>
						</g>
						<g>
							<polygon fill="#FFFFFF" points="375.7,319 356.1,296.8 360,293.4 379.6,315.6 			"/>
						</g>
						<g>
							<polygon fill="#FFFFFF" points="375.7,260.9 356.1,238.7 360,235.3 379.6,257.5 			"/>
						</g>
						<g>
							<polygon fill="#FFFFFF" points="375.7,200.1 356.1,177.9 360,174.5 379.6,196.7 			"/>
						</g>
						<g>
							<polygon fill="#FFFFFF" points="381.1,319.3 377.3,315.5 396.9,295.5 400.7,299.3 			"/>
						</g>
						<g>
							<polygon fill="#FFFFFF" points="381.1,261.2 377.3,257.4 396.9,237.3 400.7,241.1 			"/>
						</g>
						<g>
							<polygon fill="#FFFFFF" points="381.1,200.4 377.3,196.6 396.9,176.6 400.7,180.4 			"/>
						</g>
					</g>
					<g>
						<path fill="#FFFFFF" d="M369,205c-14.4,0-29.9-2.8-46.3-8.3c-25.9-8.7-54.1-24.2-83.8-46.1c-50.7-37.3-88.8-80.9-89.2-81.3
							l0.8-0.7c0.4,0.4,38.5,43.9,89.1,81.2c46.6,34.3,113.7,70.3,168.4,46.4l0.4,0.9C396.2,202.3,383,205,369,205z"/>
					</g>
					<g>
						<path fill="#FFFFFF" d="M303.9,200.6c-18.8,0-38.5-3.2-58.9-9.5c-29.6-9.2-60.9-25-92.8-46.9c-54.4-37.4-92.5-80.4-92.9-80.8
							l0.8-0.7c0.4,0.4,38.4,43.3,92.7,80.7c50.1,34.4,124.5,71,195.1,49.9l0.3,1C334.1,198.5,319.3,200.6,303.9,200.6z"/>
					</g>
					<g>
						<path fill="#FFFFFF" d="M401.2,266.3c-13.6,0-28.2-2.1-43.6-6.3c-24.5-6.7-51.2-18.8-79.2-35.9c-47.7-29.1-84.3-63.9-83.8-63.4
							l0.7-0.7c-0.5-0.5,36,34.3,83.6,63.3c43.9,26.8,107.3,54.7,159.8,35.8l0.3,0.9C427.5,264.2,414.8,266.3,401.2,266.3z"/>
					</g>
					<g>
						<path fill="#FFFFFF" d="M276.9,258.2c-19.6,0-40.3-2.6-62.4-7.8c-30.6-7.2-63.6-19.5-97.8-36.4c-58.3-28.8-101-63.6-101.4-63.9
							l0.6-0.8c0.4,0.3,43,35.1,101.2,63.8c53.7,26.5,132.2,54.9,200.8,39.8l0.2,1C305.2,256.8,291.4,258.2,276.9,258.2z"/>
					</g>
					<g>
						<path fill="#FFFFFF" d="M368.9,324.5c-12.7,0-26-1.3-39.8-3.8c-25.9-4.8-53.7-14-82.7-27.4c-49.3-22.9-85.3-50.3-85.7-50.6
							l0.6-0.8c0.4,0.3,36.3,27.7,85.5,50.5c45.4,21,111.6,42.3,169.6,24.3l0.3,1C401.9,322.2,385.9,324.5,368.9,324.5z"/>
					</g>
					<g>
						<path fill="#FFFFFF" d="M283.2,322.3c-13,0.1-26.6-0.9-40.7-3.1c-29.4-4.4-61-13.7-93.9-27.6c-56.1-23.6-98.2-54.7-98.6-55
							l0.6-0.8c0.4,0.3,42.5,31.3,98.5,54.9c51.6,21.7,126.9,43.1,192.3,21.5l0.3,0.9C323.7,319.1,304.2,322.1,283.2,322.3z"/>
					</g>
				</g>
				<g id="damage-drone">
					<path fill="#FFFFFF" d="M266.9,58.4c2.7,9.5,15.8,14.7,28.7,11.3c5.5-1.5,7-5.2,12.3-3.9c5.7,1.6,4.4,15.5,27,17.4
						c14.8,1.2,26.9-8,27.4-19.5c0.7-13.9-9.6-15.3-9.2-18c0.2-3.7,14.3-2.7,14.2-15.5c0-8.3-12.6-14.3-25.6-13.4
						c-8.5,0.6-13.1,4.4-14.8,3.5c-2.5-0.4-3.2-9.1-21.3-8.3c-11.2,0.4-20.2,7-19.6,13.5c0.3,3.7,3.6,4.9,3.2,7.3
						c-0.4,1.8-0.8,1.5-3.8,2.3C272.6,38.4,264.3,48.9,266.9,58.4z M307.5,33.2c-9.5,0.8-17.6-3-18.1-8.4c-0.5-5.4,6.9-10.4,16.4-11.2
						c9.5-0.8,17.6,3,18.1,8.4C324.4,27.4,317,32.4,307.5,33.2z M344.1,40.7c-10.1-0.8-17.8-6.4-17.3-12.5c0.5-6.1,9.1-10.4,19.2-9.5
						c10.1,0.8,17.8,6.4,17.3,12.5C362.8,37.2,354.2,41.5,344.1,40.7z M313,59.4c0.5-9.5,11.4-16.7,24.2-16c12.8,0.7,22.6,9.2,22,18.8
						c-0.5,9.5-10.8,16.8-23.7,16.1C322.8,77.6,312.5,69,313,59.4z M311.5,38.4c0.2-2.4,3.6-4.1,7.6-3.8c4,0.3,7,2.5,6.8,5
						c-0.2,2.4-3.6,4.1-7.6,3.8C314.4,43,311.3,40.8,311.5,38.4z M285,37c11.3-3.6,22.5,0.1,25,7.7c2.5,7.7-4.1,16.7-15.5,20.2
						c-11.3,3.6-23,0-25.5-7.6C266.6,49.6,273.7,40.5,285,37z"/>
					<path fill="#FFFFFF" d="M337.1,59.3l-0.7-2.4l-6.6-9.5c0,0-1.9-0.2-3.5,0.7c-0.1,0.1,4.8,9.7,4.8,9.7s2.4,0.5,3.6,1.8
						c1,1.1,8.8,13.4,8.8,13.4l3.6,0.1c0,0-5.8-9.6-6.9-11.3C339.6,61,337.8,60.4,337.1,59.3z"/>
					<path fill="#FFFFFF" d="M288.5,49.1l-2.7-0.8l-12.6,0.1c0,0-1.3,1.6-1.3,3.5c0,0.2,11.8,1.5,11.8,1.5s1.8-1.8,3.7-2.1
						c1.5-0.2,17.5,0.3,17.5,0.3l2.1-3.1c0,0-12.2-0.7-14.4-0.7C291.5,47.8,290,49.1,288.5,49.1z"/>
					<path fill="#FFFFFF" d="M305.7,23.3l-2.1-0.1l-9.1,2.3c0,0-0.6,1.3-0.3,2.7c0,0.1,8.8-0.9,8.8-0.9s1-1.6,2.3-2.1
						c1.1-0.4,12.7-2.8,12.7-2.8l1-2.6c0,0-9,1.6-10.6,1.9C307.6,21.9,306.7,23,305.7,23.3z"/>
					<path fill="#FFFFFF" d="M345.5,29.4l-1.4-0.8l-4.9-5.1c0,0,0.2-1.1,1-1.9c0.1-0.1,5.3,4.2,5.3,4.2s-0.1,1.4,0.6,2.3
						c0.5,0.7,7,6.9,7,6.9l-0.5,2.1c0,0-5.1-4.7-6-5.5C346.1,31,346.1,29.9,345.5,29.4z"/>
				</g>
				<g>
					<polygon id="lightning1" fill="#eac670" points="316.8,164.0 312.8,164.0 312.8,134.0 302,168.8 307.9,168.8 307.7,200.7 "/>
					<polygon id="lightning2" fill="#eac670" points="300.8,196.0 298.8,196.0 298.8,166.0 286,200.8 291.9,200.8 291.7,232.7 "/>
					<!-- -16, +32 -->
				</g>
				</svg>


			</div>
			<div id="damage-copy">
				<div class="copy">
					<?php
						foreach ($homepage_contentRecord['damage_icon'] as $index => $upload){
							$damage_icon = htmlencode($upload['urlPath']);
						}
					?>
					<br />
					<img src="<?php echo $damage_icon ?>" />
					<br />
					<?php echo $homepage_contentRecord['damage_copy'] ?>
					<div class="more-info">
						<div class="more-info-left">
						<?php echo htmlencode($homepage_contentRecord['damage_learn_more_button_copy']) ?>
						</div>
						<div class="more-info-right">
							<!-- Generator: Adobe Illustrator 18.1.1, SVG Export Plug-In  -->
							<svg version="1.1"
								 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/"
								 x="0px" y="0px" viewBox="0 0 37 37"xml:space="preserve">
							<defs>
							</defs>
							<g>
								<g>
									<defs>
										<line id="SVGID_1_" x1="37" y1="37" x2="0" y2="37"/>
									</defs>
									<clipPath id="SVGID_2_">
										<use xlink:href="#SVGID_1_"  overflow="visible"/>
									</clipPath>
								</g>
							</g>
							<path fill="#050505" d="M31.4,5.4c-7.2-7.2-18.8-7.2-26,0c-7.2,7.2-7.2,18.8,0,26c7.2,7.2,18.8,7.2,26,0
								C38.6,24.2,38.6,12.6,31.4,5.4L31.4,5.4z M20.8,26.4c0,1.3-1.1,2.4-2.4,2.4c-1.3,0-2.4-1.1-2.4-2.4v-9.6c0-1.3,1.1-2.4,2.4-2.4
								c1.3,0,2.4,1.1,2.4,2.4V26.4z M18.4,12.7c-1.4,0-2.3-1-2.3-2.2c0-1.3,0.9-2.2,2.3-2.2c1.4,0,2.3,0.9,2.3,2.2
								C20.7,11.7,19.8,12.7,18.4,12.7L18.4,12.7z M18.4,12.7"/>
							</svg>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="check-yourself">
		<div class="container">
			<div id="check-yourself-copy">
				<div class="copy">
					<div class="arrow-section">
						<h3><?php echo htmlencode($homepage_contentRecord['checkbox_section_arrow_headline']) ?></h3>
						<div class="arrow-copy"><?php echo htmlencode($homepage_contentRecord['checkbox_section_arrow_copy']) ?></div>
						<div class="right-triangle"></div>
					</div>
					<div class="check-item">
						<div class="check-mark">
							<!-- Generator: Adobe Illustrator 18.1.1, SVG Export Plug-In  -->
							<svg version="1.1"
								 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/"
								 x="0px" y="0px" viewBox="0 0 132.7 137.6" xml:space="preserve">
							<defs>
							</defs>
							<path d="M132.5,3.1c-0.4,0.5-22.7,28.2-33.3,42.8c-14,19.4-27.5,39.1-40.8,59c-4.5,6.7-10.5,4.9-16.4,5.2c-4.7,0.2-5.7-3.5-6.9-6.7
								c-2.9-7.9-5.9-15.8-8.3-23.9c-2.2-7.4,7.2-16.6,14.6-14.4c1.6,0.5,3.2,2.4,4,4c1.4,2.8,2,6,3.3,8.8c0.8,1.9,2.3,3.4,3.5,5.1
								c1.5-1.4,3.3-2.6,4.4-4.2C65.4,66.1,73.6,53,82.6,40.4c8.1-11.3,16.5-22.5,25.8-32.9c3.3-3.7,12.2-7.2,14.2-7.4S126.9,0,130,0
								C133.1,0,132.9,2.6,132.5,3.1z"/>
							<path d="M114.1,32.2l-5.1,6.8c7.3,9.5,11.6,21.3,11.6,34.2c0,31.1-25.2,56.2-56.2,56.2S8.2,104.2,8.2,73.1s25.2-56.2,56.2-56.2
								c9.7,0,18.8,2.4,26.7,6.7l5-6.6c-9.4-5.3-20.2-8.3-31.7-8.3C28.8,8.7,0,37.6,0,73.1s28.8,64.4,64.4,64.4s64.4-28.8,64.4-64.4
								C128.8,57.6,123.3,43.3,114.1,32.2z"/>
							</svg>
						</div>
						<div class="check-copy">
							Check to see if you are outside of 5 miles from any airport/airfield
						</div>
					</div>
					<div class="check-item">
						<div class="check-mark">
							<!-- Generator: Adobe Illustrator 18.1.1, SVG Export Plug-In  -->
							<svg version="1.1"
								 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/"
								 x="0px" y="0px" viewBox="0 0 132.7 137.6" xml:space="preserve">
							<defs>
							</defs>
							<path d="M132.5,3.1c-0.4,0.5-22.7,28.2-33.3,42.8c-14,19.4-27.5,39.1-40.8,59c-4.5,6.7-10.5,4.9-16.4,5.2c-4.7,0.2-5.7-3.5-6.9-6.7
								c-2.9-7.9-5.9-15.8-8.3-23.9c-2.2-7.4,7.2-16.6,14.6-14.4c1.6,0.5,3.2,2.4,4,4c1.4,2.8,2,6,3.3,8.8c0.8,1.9,2.3,3.4,3.5,5.1
								c1.5-1.4,3.3-2.6,4.4-4.2C65.4,66.1,73.6,53,82.6,40.4c8.1-11.3,16.5-22.5,25.8-32.9c3.3-3.7,12.2-7.2,14.2-7.4S126.9,0,130,0
								C133.1,0,132.9,2.6,132.5,3.1z"/>
							<path d="M114.1,32.2l-5.1,6.8c7.3,9.5,11.6,21.3,11.6,34.2c0,31.1-25.2,56.2-56.2,56.2S8.2,104.2,8.2,73.1s25.2-56.2,56.2-56.2
								c9.7,0,18.8,2.4,26.7,6.7l5-6.6c-9.4-5.3-20.2-8.3-31.7-8.3C28.8,8.7,0,37.6,0,73.1s28.8,64.4,64.4,64.4s64.4-28.8,64.4-64.4
								C128.8,57.6,123.3,43.3,114.1,32.2z"/>
							</svg>
						</div>
						<div class="check-copy">
							Remain below 400 ft above ground level 
						</div>
					</div>
					<div class="check-item">
						<div class="check-mark">
							<!-- Generator: Adobe Illustrator 18.1.1, SVG Export Plug-In  -->
							<svg version="1.1"
								 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/"
								 x="0px" y="0px" viewBox="0 0 132.7 137.6" xml:space="preserve">
							<defs>
							</defs>
							<path d="M132.5,3.1c-0.4,0.5-22.7,28.2-33.3,42.8c-14,19.4-27.5,39.1-40.8,59c-4.5,6.7-10.5,4.9-16.4,5.2c-4.7,0.2-5.7-3.5-6.9-6.7
								c-2.9-7.9-5.9-15.8-8.3-23.9c-2.2-7.4,7.2-16.6,14.6-14.4c1.6,0.5,3.2,2.4,4,4c1.4,2.8,2,6,3.3,8.8c0.8,1.9,2.3,3.4,3.5,5.1
								c1.5-1.4,3.3-2.6,4.4-4.2C65.4,66.1,73.6,53,82.6,40.4c8.1-11.3,16.5-22.5,25.8-32.9c3.3-3.7,12.2-7.2,14.2-7.4S126.9,0,130,0
								C133.1,0,132.9,2.6,132.5,3.1z"/>
							<path d="M114.1,32.2l-5.1,6.8c7.3,9.5,11.6,21.3,11.6,34.2c0,31.1-25.2,56.2-56.2,56.2S8.2,104.2,8.2,73.1s25.2-56.2,56.2-56.2
								c9.7,0,18.8,2.4,26.7,6.7l5-6.6c-9.4-5.3-20.2-8.3-31.7-8.3C28.8,8.7,0,37.6,0,73.1s28.8,64.4,64.4,64.4s64.4-28.8,64.4-64.4
								C128.8,57.6,123.3,43.3,114.1,32.2z"/>
							</svg>
						</div>
						<div class="check-copy">
							 Keep your aircraft in sight at all times 
						</div>
					</div>
					<div class="check-item">
						<div class="check-mark">
							<!-- Generator: Adobe Illustrator 18.1.1, SVG Export Plug-In  -->
							<svg version="1.1"
								 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/"
								 x="0px" y="0px" viewBox="0 0 132.7 137.6" xml:space="preserve">
							<defs>
							</defs>
							<path d="M132.5,3.1c-0.4,0.5-22.7,28.2-33.3,42.8c-14,19.4-27.5,39.1-40.8,59c-4.5,6.7-10.5,4.9-16.4,5.2c-4.7,0.2-5.7-3.5-6.9-6.7
								c-2.9-7.9-5.9-15.8-8.3-23.9c-2.2-7.4,7.2-16.6,14.6-14.4c1.6,0.5,3.2,2.4,4,4c1.4,2.8,2,6,3.3,8.8c0.8,1.9,2.3,3.4,3.5,5.1
								c1.5-1.4,3.3-2.6,4.4-4.2C65.4,66.1,73.6,53,82.6,40.4c8.1-11.3,16.5-22.5,25.8-32.9c3.3-3.7,12.2-7.2,14.2-7.4S126.9,0,130,0
								C133.1,0,132.9,2.6,132.5,3.1z"/>
							<path d="M114.1,32.2l-5.1,6.8c7.3,9.5,11.6,21.3,11.6,34.2c0,31.1-25.2,56.2-56.2,56.2S8.2,104.2,8.2,73.1s25.2-56.2,56.2-56.2
								c9.7,0,18.8,2.4,26.7,6.7l5-6.6c-9.4-5.3-20.2-8.3-31.7-8.3C28.8,8.7,0,37.6,0,73.1s28.8,64.4,64.4,64.4s64.4-28.8,64.4-64.4
								C128.8,57.6,123.3,43.3,114.1,32.2z"/>
							</svg>
						</div>
						<div class="check-copy">
							Stay clear of temporary flight restrictions and any media interest areas (including fires, crime scenes, and sporting events)
						</div>
					</div>
					<div class="check-item">
						<div class="check-mark">
							<!-- Generator: Adobe Illustrator 18.1.1, SVG Export Plug-In  -->
							<svg version="1.1"
								 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/"
								 x="0px" y="0px" viewBox="0 0 132.7 137.6" xml:space="preserve">
							<defs>
							</defs>
							<path d="M132.5,3.1c-0.4,0.5-22.7,28.2-33.3,42.8c-14,19.4-27.5,39.1-40.8,59c-4.5,6.7-10.5,4.9-16.4,5.2c-4.7,0.2-5.7-3.5-6.9-6.7
								c-2.9-7.9-5.9-15.8-8.3-23.9c-2.2-7.4,7.2-16.6,14.6-14.4c1.6,0.5,3.2,2.4,4,4c1.4,2.8,2,6,3.3,8.8c0.8,1.9,2.3,3.4,3.5,5.1
								c1.5-1.4,3.3-2.6,4.4-4.2C65.4,66.1,73.6,53,82.6,40.4c8.1-11.3,16.5-22.5,25.8-32.9c3.3-3.7,12.2-7.2,14.2-7.4S126.9,0,130,0
								C133.1,0,132.9,2.6,132.5,3.1z"/>
							<path d="M114.1,32.2l-5.1,6.8c7.3,9.5,11.6,21.3,11.6,34.2c0,31.1-25.2,56.2-56.2,56.2S8.2,104.2,8.2,73.1s25.2-56.2,56.2-56.2
								c9.7,0,18.8,2.4,26.7,6.7l5-6.6c-9.4-5.3-20.2-8.3-31.7-8.3C28.8,8.7,0,37.6,0,73.1s28.8,64.4,64.4,64.4s64.4-28.8,64.4-64.4
								C128.8,57.6,123.3,43.3,114.1,32.2z"/>
							</svg>
						</div>
						<div class="check-copy">
							Check to see if you are outside of 5 miles from any airport/airfield.
						</div>
					</div>
				</div>
			</div>
			<div id="check-yourself-image-wrapper">
				<!-- Generator: Adobe Illustrator 18.1.1, SVG Export Plug-In  -->
				<svg version="1.1"
					 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/"
					 x="0px" y="0px" width="370px" height="541px" viewBox="0 0 370 541" enable-background="new 0 0 370 541" xml:space="preserve" id="check-yourself-image">
				<defs>
				</defs>
				<g>
					<g>
						<path fill="#FFFFFF" d="M240,540.9c-80,0-160,0-240,0c0-103.3,0-206.6,0-310c0.4,2.6,0.6,5.2,1.3,7.6c1.5,4.8,2.4,10.2,5.3,14.1
							c3.8,5,11.9,5.6,17.4,2.9c6.2-3,9-8,8.7-14.9c-0.4-9.1-1.3-18.3-1.1-27.4c1.4-53.1,21.7-98,60.5-134
							c27.1-25.2,59.3-40.7,95.9-47.1c3.3-0.6,6.9-1.9,9.4-4c5.4-4.5,6.3-12,3-18.7c-3.2-6.4-9.3-9.2-17.2-7.8
							c-4.6,0.8-9.2,1.7-13.7,2.8C113.3,18.4,68.4,48.8,36.3,97.5c-18.5,28.1-29.7,59-34.1,92.3c-0.6,4.7-1.5,9.4-2.2,14.1
							C0,136,0,68,0,0c123.3,0,246.6,0,370,0c0,180.3,0,360.6,0,540.9c-14.3,0-28.7,0-43,0c-0.2-2-0.5-4-0.5-5.9
							c0.3-23.6,0.8-47.3,1.1-70.9c0.4-29.8,0.7-59.6,1.2-89.4c0.2-15.5,0.7-31,0.8-46.4c0-3.9,1.5-4.8,5-4.7c7.3,0.2,14.7,0.1,22,0.1
							c7.6,0,12.4-4.4,12.2-11.9c-0.1-6.1-0.9-12.3-1.6-18.4c-2.5-19-5.7-37.8-11.9-56.1c-3.4-10.3-9.2-18.2-19.7-21.6
							c-7.4-2.3-15.1-4.9-22.7-5.3c-19.2-1-38.5-1.6-57.8-1c-8.9,0.3-17.9,3.1-26.6,5.7c-7.5,2.3-11.8,7.8-13.4,15.9
							c-3.5,18.1-7.8,36.1-11.4,54.2c-1.6,8.1-3.2,16.3-3.6,24.6c-0.4,8.6,3.6,12.6,12.1,13.3c6.1,0.5,12.3,0.6,18.4,0.5
							c3.7-0.1,4.9,0.9,5,4.7c0.6,31,1.4,61.9,2.1,92.9C238.4,461.1,239.2,501,240,540.9z M60.1,219.7c0.4,4.3,0.8,10.9,1.5,17.5
							c1.1,9.7,7.7,14.6,17.9,13.5c8.4-0.9,13.7-8,12.8-17c-2.9-29.2,2.2-56.7,17.4-81.9c20.5-34.2,51.3-53.5,90.1-60.8
							c6.5-1.2,11.1-4.6,12.8-11c1.7-6.5-0.1-12.2-5.2-16.7c-4.6-4.2-10.3-3.6-15.7-2.6c-31.4,6.1-59.4,19.3-82.5,41.7
							C76.8,133.7,60.9,172.3,60.1,219.7z M207.5,118.6c-4.4,0.9-8.8,1.7-13.1,2.7c-48.5,11.6-81.7,61.8-73.3,111
							c1.2,7.1,6.8,12,14.1,12.3c8.3,0.4,14.8-3.7,16.4-10.8c0.7-3.2,0.6-6.7,0.2-9.9c-1.9-17.7,2.9-33.7,13.4-47.8
							c11.3-15.2,27-23.2,45.4-26.3c8.6-1.5,13.9-8.3,13-16.6C222.8,124.6,216.2,118.7,207.5,118.6z M249.9,157
							c1.6,6.1,2.4,12.4,4.8,18.1c8.8,21.2,33.3,27.2,50.2,12.5c17.5-15.2,17-47.7-1.1-62.2c-13.8-11.1-33.5-8.8-44.3,5.3
							C253.7,138.4,250.9,147.1,249.9,157z"/>
						<path id="wave-big" d="M0,204c0.8-4.7,1.6-9.4,2.2-14.1c4.4-33.4,15.5-64.2,34.1-92.3c32.1-48.7,77-79.1,133.3-93.2c4.5-1.1,9.1-2,13.7-2.8
							c7.9-1.4,14.1,1.4,17.2,7.8c3.3,6.7,2.4,14.2-3,18.7c-2.5,2.1-6.1,3.5-9.4,4c-36.5,6.5-68.8,22-95.9,47.1
							c-38.8,36-59.2,80.9-60.5,134c-0.2,9.1,0.6,18.3,1.1,27.4c0.3,6.9-2.6,11.9-8.7,14.9c-5.5,2.7-13.6,2.1-17.4-2.9
							c-2.9-3.8-3.8-9.3-5.3-14.1c-0.8-2.4-0.9-5.1-1.3-7.6C0,222,0,213,0,204z"/>
						<path fill="#FFFFFF" d="M267,540.9c2.7-37,5.5-73.9,8.2-110.9c0.9-11.9,2.1-23.9,2.5-35.8c0.2-4.4,2.5-6.5,5.7-6.8
							c3.7-0.3,4.3,3.2,4.6,6.4c2.7,32.8,5.3,65.6,8.1,98.4c1.4,16.2,3.2,32.4,4.8,48.6C289.6,540.9,278.3,540.9,267,540.9z"/>
						<path id="wave-md" d="M60.1,219.7c0.9-47.4,16.8-86.1,49.2-117.5c23.1-22.4,51.1-35.6,82.5-41.7c5.4-1,11-1.6,15.7,2.6c5,4.6,6.8,10.3,5.2,16.7
							c-1.7,6.5-6.3,9.8-12.8,11c-38.8,7.3-69.6,26.7-90.1,60.8c-15.2,25.2-20.4,52.7-17.4,81.9c0.9,9.1-4.5,16.2-12.8,17
							c-10.1,1.1-16.7-3.8-17.9-13.5C60.8,230.6,60.4,224,60.1,219.7z"/>
						<path id="wave-sm" d="M207.5,118.6c8.7,0.1,15.2,6,16.1,14.7c0.8,8.3-4.5,15.1-13,16.6c-18.4,3.1-34.1,11.2-45.4,26.3
							c-10.5,14.1-15.3,30-13.4,47.8c0.4,3.3,0.5,6.7-0.2,9.9c-1.6,7.1-8.1,11.2-16.4,10.8c-7.3-0.4-12.9-5.2-14.1-12.3
							c-8.4-49.2,24.8-99.5,73.3-111C198.8,120.3,203.1,119.5,207.5,118.6z"/>
						<path d="M249.9,157c0.9-9.9,3.7-18.6,9.6-26.3c10.8-14.1,30.5-16.5,44.3-5.3c18,14.5,18.6,47,1.1,62.2
							c-16.9,14.6-41.5,8.7-50.2-12.5C252.4,169.5,251.5,163.1,249.9,157z"/>
						<path d="M367.1,293.3c-2.5-19-5.7-37.8-11.9-56.1c-3.4-10.3-9.2-18.2-19.7-21.6c-7.4-2.3-15.1-4.9-22.7-5.3
							c-19.2-1-38.5-1.6-57.8-1c-8.9,0.3-17.9,3.1-26.6,5.7c-7.5,2.3-11.8,7.8-13.4,15.9c-3.5,18.1-7.8,36.1-11.4,54.2
							c-1.6,8.1-3.2,16.3-3.6,24.6c-0.4,8.6,3.6,12.6,12.1,13.3c6.1,0.5,12.3,0.6,18.4,0.5c3.7-0.1,4.9,0.9,5,4.7
							c0.6,31,1.4,61.9,2.1,92.9c0.9,39.9,1.6,79.9,2.4,119.9c9,0,18,0,27,0c2.7-37,5.5-74,8.2-111c0.9-11.9,2.1-23.9,2.5-35.8
							c0.2-4.4,2.5-6.5,5.7-6.8c3.7-0.3,4.3,3.2,4.6,6.4c2.7,32.8,5.3,65.7,8.1,98.5c1.4,16.2,3.2,32.7,4.8,48.7c8.7,0,17.3,0,26,0
							c-0.2-2-0.5-4-0.5-6c0.3-23.6,0.8-47.3,1.1-70.9c0.4-29.8,0.7-59.6,1.2-89.4c0.2-15.5,0.7-31,0.8-46.4c0-3.9,1.5-4.8,5-4.7
							c7.3,0.2,14.7,0.1,22,0.1c7.6,0,12.4-4.4,12.2-11.9C368.6,305.6,367.9,299.4,367.1,293.3z M314.1,331c-1,2-4.7,3.7-7.2,3.7
							c-15.3,0.1-30.6-0.1-45.9-0.6c-2.3-0.1-6.4-1.4-6.6-2.6c-0.6-3.5,0-7.4,0.9-10.9c0.4-1.4,2.4-3,4-3.5c6.1-1.8,6.5-6.9,7.2-11.8
							c0.6-3.6-1.1-5.5-5-5.7c-7.8-0.3-7.8-0.4-7.8-8.1c0-3.3-0.1-6.7,0-10c0.2-5.8,1.8-7.4,7.6-7.5c6.3-0.1,12.6,0,19,0
							c-0.3-4.5-0.3-8.2-0.8-11.7c-0.3-2-1-4.1-2.1-5.6c-3-4.1-3.3-10-0.2-13.2c3.3-3.4,9.6-3.7,13.2-0.6c3.5,3.1,3.7,8.6,0.9,13.2
							c-1.4,2.2-2,5-2.5,7.6c-0.5,3-0.5,6.2-0.8,10.4c2.8,0,6-0.1,9.1,0c4.3,0.1,8.6,0.2,12.9,0.6c3.1,0.3,4.6,2.1,4.5,5.4
							c-0.2,3.7,0,7.3,0,11c-0.1,6.5-1.6,7.9-8,7.9c-6.7,0-5.9,0-5.3,6.6c0.5,5.9,3.2,8.7,7.9,11.3C314.1,319.6,316.6,326.1,314.1,331z"
							/>
					</g>
				</g>
				</svg>
			</div>
		</div>
	</div>
	<div id="prepared">
		<div class="container">
			<div id="prepared-headline">
				<h3><?php echo $homepage_contentRecord['infographic_download_headline'] ?></h3>
				<div class="accent-button"><a href="/_img/TBYL-infographic.pdf" target="_blank"><?php echo htmlencode($homepage_contentRecord['infographic_download_button_copy']) ?></a></div>
			</div>
		</div>
	</div>
	<div id="share">
		<div class="container">
			<div id="share-headline">
				<h3><?php echo htmlencode($homepage_contentRecord['share_headline']) ?></h3>
				<?php echo htmlencode($homepage_contentRecord['share_subhead']) ?>
				<div id="share-buttons">
					<div class="share-button">
						<a href="https://www.facebook.com/sharer/sharer.php?u=http://www.thinkbeforeyoulaunch.com/"onclick="window.open(this.href, 'mywin',
'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;">
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
						</a>
					</div>
					<div class="share-button">
						<a href="https://twitter.com/home?status=http://thinkbeforeyoulaunch.org/" onclick="window.open(this.href, 'mywin',
'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;">
							<!-- Generator: Adobe Illustrator 18.1.1, SVG Export Plug-In  -->
							<svg version="1.1"
								 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/"
								 x="0px" y="0px" viewBox="0 0 39.7 39.7" xml:space="preserve">
							<defs>
							</defs>
							<g>
								<path d="M19.9,0C8.9,0,0,8.9,0,19.9c0,11,8.9,19.9,19.9,19.9c11,0,19.9-8.9,19.9-19.9C39.7,8.9,30.8,0,19.9,0L19.9,0z M28.7,15.3
									c0,0.2,0,0.4,0,0.6c0,6-4.6,13-13,13c-2.6,0-5-0.8-7-2.1c0.4,0,0.7,0.1,1.1,0.1c2.1,0,4.1-0.7,5.7-2c-2,0-3.7-1.4-4.3-3.2
									c0.3,0.1,0.6,0.1,0.9,0.1c0.4,0,0.8-0.1,1.2-0.2c-2.1-0.4-3.7-2.3-3.7-4.5c0,0,0,0,0-0.1c0.6,0.3,1.3,0.5,2.1,0.6
									c-1.2-0.8-2-2.2-2-3.8c0-0.8,0.2-1.6,0.6-2.3c2.3,2.8,5.6,4.6,9.4,4.8c-0.1-0.3-0.1-0.7-0.1-1c0-2.5,2-4.6,4.6-4.6
									c1.3,0,2.5,0.6,3.3,1.4c1-0.2,2-0.6,2.9-1.1c-0.3,1.1-1.1,2-2,2.5c0.9-0.1,1.8-0.4,2.6-0.7C30.4,13.9,29.6,14.7,28.7,15.3
									L28.7,15.3z M28.7,15.3"/>
							</g>
							</svg>
						</a>
					</div>
					<div class="share-button">
						<a href="https://plus.google.com/share?url=http://thinkbeforeyoulaunch.org/" onclick="window.open(this.href, 'mywin',
'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;">
							<svg version="1.1"
								 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/"
								 x="0px" y="0px" viewBox="0 0 39.7 39.7" xml:space="preserve">
							<defs>
							</defs>
							<g>
								<path d="M17.2,23.2c-0.1-0.1-0.3-0.2-0.4-0.3c-0.4-0.1-0.8-0.2-1.3-0.2h-0.1c-2,0-3.8,1.2-3.8,2.6c0,1.5,1.5,2.7,3.4,2.7
									c2.5,0,3.8-0.9,3.8-2.6c0-0.2,0-0.3-0.1-0.5C18.7,24.2,18.1,23.8,17.2,23.2L17.2,23.2z M17.2,23.2"/>
								<path d="M15.8,17.9L15.8,17.9c0.5,0,0.9-0.2,1.2-0.6c0.5-0.6,0.7-1.5,0.6-2.5c-0.2-1.8-1.5-3.2-2.8-3.2l-0.1,0
									c-0.5,0-0.9,0.2-1.2,0.6c-0.5,0.6-0.7,1.4-0.6,2.4C13.2,16.3,14.5,17.8,15.8,17.9L15.8,17.9z M15.8,17.9"/>
								<path d="M19.9,0C8.9,0,0,8.9,0,19.9c0,11,8.9,19.9,19.9,19.9c11,0,19.9-8.9,19.9-19.9C39.7,8.9,30.8,0,19.9,0L19.9,0z M17.6,29.5
									c-0.8,0.2-1.6,0.3-2.4,0.3c-0.9,0-1.9-0.1-2.7-0.3c-1.6-0.4-2.9-1.2-3.4-2.2c-0.2-0.4-0.4-0.9-0.4-1.4c0-0.5,0.1-1,0.4-1.5
									c0.9-1.9,3.3-3.2,5.9-3.2H15c-0.2-0.4-0.3-0.8-0.3-1.2c0-0.2,0-0.4,0.1-0.6c-2.8-0.1-4.8-2.1-4.8-4.7c0-1.9,1.5-3.7,3.7-4.5
									c0.6-0.2,1.3-0.3,1.9-0.3h5.9c0.2,0,0.4,0.1,0.4,0.3c0.1,0.2,0,0.4-0.2,0.5l-1.3,1c-0.1,0.1-0.2,0.1-0.3,0.1h-0.5
									c0.6,0.7,1,1.8,1,2.9c0,1.3-0.7,2.5-1.8,3.4c-0.9,0.7-1,0.9-1,1.3c0,0.2,0.7,1,1.4,1.5c1.6,1.2,2.3,2.3,2.3,4.2
									C21.4,27.1,19.9,28.9,17.6,29.5L17.6,29.5z M30.9,19.4c0,0.3-0.2,0.5-0.5,0.5h-3.4v3.4c0,0.3-0.2,0.5-0.5,0.5h-1
									c-0.3,0-0.5-0.2-0.5-0.5v-3.4h-3.4c-0.3,0-0.5-0.2-0.5-0.5v-1c0-0.3,0.2-0.5,0.5-0.5h3.4v-3.4c0-0.3,0.2-0.5,0.5-0.5h1
									c0.3,0,0.5,0.2,0.5,0.5V18h3.4c0.3,0,0.5,0.2,0.5,0.5V19.4z M30.9,19.4"/>
							</g>
							</svg>
						</a>
					</div>
					<!-- <div class="share-button">
						<a href="https://www.facebook.com/sharer/sharer.php?u=http://www.thinkbeforeyoulaunch.com/">
							<svg version="1.1"
								 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/"
								 x="0px" y="0px" viewBox="0 0 39.7 39.7" xml:space="preserve">
							<defs>
							</defs>
							<g>
								<path d="M17.2,23.2c-0.1-0.1-0.3-0.2-0.4-0.3c-0.4-0.1-0.8-0.2-1.3-0.2h-0.1c-2,0-3.8,1.2-3.8,2.6c0,1.5,1.5,2.7,3.4,2.7
									c2.5,0,3.8-0.9,3.8-2.6c0-0.2,0-0.3-0.1-0.5C18.7,24.2,18.1,23.8,17.2,23.2L17.2,23.2z M17.2,23.2"/>
								<path d="M15.8,17.9L15.8,17.9c0.5,0,0.9-0.2,1.2-0.6c0.5-0.6,0.7-1.5,0.6-2.5c-0.2-1.8-1.5-3.2-2.8-3.2l-0.1,0
									c-0.5,0-0.9,0.2-1.2,0.6c-0.5,0.6-0.7,1.4-0.6,2.4C13.2,16.3,14.5,17.8,15.8,17.9L15.8,17.9z M15.8,17.9"/>
								<path d="M19.9,0C8.9,0,0,8.9,0,19.9c0,11,8.9,19.9,19.9,19.9c11,0,19.9-8.9,19.9-19.9C39.7,8.9,30.8,0,19.9,0L19.9,0z M17.6,29.5
									c-0.8,0.2-1.6,0.3-2.4,0.3c-0.9,0-1.9-0.1-2.7-0.3c-1.6-0.4-2.9-1.2-3.4-2.2c-0.2-0.4-0.4-0.9-0.4-1.4c0-0.5,0.1-1,0.4-1.5
									c0.9-1.9,3.3-3.2,5.9-3.2H15c-0.2-0.4-0.3-0.8-0.3-1.2c0-0.2,0-0.4,0.1-0.6c-2.8-0.1-4.8-2.1-4.8-4.7c0-1.9,1.5-3.7,3.7-4.5
									c0.6-0.2,1.3-0.3,1.9-0.3h5.9c0.2,0,0.4,0.1,0.4,0.3c0.1,0.2,0,0.4-0.2,0.5l-1.3,1c-0.1,0.1-0.2,0.1-0.3,0.1h-0.5
									c0.6,0.7,1,1.8,1,2.9c0,1.3-0.7,2.5-1.8,3.4c-0.9,0.7-1,0.9-1,1.3c0,0.2,0.7,1,1.4,1.5c1.6,1.2,2.3,2.3,2.3,4.2
									C21.4,27.1,19.9,28.9,17.6,29.5L17.6,29.5z M30.9,19.4c0,0.3-0.2,0.5-0.5,0.5h-3.4v3.4c0,0.3-0.2,0.5-0.5,0.5h-1
									c-0.3,0-0.5-0.2-0.5-0.5v-3.4h-3.4c-0.3,0-0.5-0.2-0.5-0.5v-1c0-0.3,0.2-0.5,0.5-0.5h3.4v-3.4c0-0.3,0.2-0.5,0.5-0.5h1
									c0.3,0,0.5,0.2,0.5,0.5V18h3.4c0.3,0,0.5,0.2,0.5,0.5V19.4z M30.9,19.4"/>
							</g>
							</svg>
						</a>
					</div> -->
				</div>
			</div>
		</div>
	</div>
	<div id="organizations">
		<div class="container">
			<div id="organizations-headline">
				<h3><?php echo htmlencode($homepage_contentRecord['organizations_headline']) ?></h3>
				<h4><?php echo htmlencode($homepage_contentRecord['organizations_subhead']) ?></h4>
			</div>
				<div id="organizations-list">
				<?php foreach ($organization_listingsRecords as $record): ?>
					<div class="organizations-item">
						<a href="organizations/">
							<?php if (@$record['logo']){?>
								<?php foreach ($record['logo'] as $index => $upload): ?>
									<img src="<?php echo htmlencode($upload['urlPath']) ?>" />
								<?php endforeach; ?>
							<?php } else { ?>
								<div class="organization-name"><?php echo $record['title']; ?></div>
							<?php } ?>
						</a>
					</div>
				<?php endforeach; ?>
			<div class="primary-button"><a href="organizations/">Learn More About Our Stakeholders</a></div>
		</div>
	</div>
	<div id="news-panel" class="panel">
		<div class="close-btn">
			<!-- Generator: Adobe Illustrator 18.1.1, SVG Export Plug-In  -->
			<svg version="1.1"
				 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/"
				 x="0px" y="0px" viewBox="0 0 191.6 191.6" xml:space="preserve">
			<defs>
			</defs>
			<rect x="-28.7" y="84.8" transform="matrix(-0.7071 0.7071 -0.7071 -0.7071 231.2449 95.7848)" width="249" height="21.9"/>
			<rect x="-28.7" y="84.8" transform="matrix(-0.7071 -0.7071 0.7071 -0.7071 95.7848 231.2449)" width="249" height="21.9"/>
			</svg>
		</div>
		<div class="panel-content">
			<div class="panel-headline"><?php echo htmlencode($homepage_contentRecord['news_headline']) ?></div>
			<div class="form-group">
		    	<label for="news-category">Filter by Category</label>
				<select class="form-control" name="news-category">
					<option value="all">All</option>
					<?php foreach ($news_categoriesRecords as $record): ?>
						<option value="<?php echo htmlencode($record['title']) ?>"><?php echo htmlencode($record['title']) ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div id="news-posts-wrapper">
				<div id="news-posts">
					<?php foreach ($articlesRecords as $record): ?>
						<div class="news-post" category="<?php echo htmlencode($record['category']) ?>">
							<?php 
								if (@$record['link_to_article']){
									$newsLink = $record['article_url'] . '" target="_blank';
								} else {
									$newsLink = 'news/?num=' . htmlencode($record['num']);
								}
							?>
							<a href="<?php echo $newsLink; ?>">
								<?php if (@$record['thumbnail']): ?>
									<div class="news-post-image">
										<?php foreach ($record['thumbnail'] as $index => $upload): ?>
											<img src="<?php echo htmlencode($upload['urlPath']) ?>" />
										<?php endforeach; ?>
									</div>
								<?php endif; ?>
								<div class="news-post-copy">
									<div class="headline"><?php echo htmlencode($record['title']) ?></div>
									<div class="date"><?php echo date("F jS, Y", strtotime($record['date'])) ?></div>
									<?php echo $record['short_description'] ?>
								</div>
							</a>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
	<div id="media-panel" class="panel">
		<div class="close-btn">
			<!-- Generator: Adobe Illustrator 18.1.1, SVG Export Plug-In  -->
			<svg version="1.1"
				 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/"
				 x="0px" y="0px" viewBox="0 0 191.6 191.6" xml:space="preserve">
			<defs>
			</defs>
			<rect x="-28.7" y="84.8" transform="matrix(-0.7071 0.7071 -0.7071 -0.7071 231.2449 95.7848)" width="249" height="21.9"/>
			<rect x="-28.7" y="84.8" transform="matrix(-0.7071 -0.7071 0.7071 -0.7071 95.7848 231.2449)" width="249" height="21.9"/>
			</svg>
		</div>
		<div class="panel-content">
			<div class="panel-headline"><?php echo htmlencode($homepage_contentRecord['photos_headline']) ?></div>
			<!-- <div class="form-group">
		    	<label for="media-category">Filter by Category</label>
				<select class="form-control" name="media-category">
					<option>All</option>
				</select>
			</div> -->
			<div id="media-posts-wrapper">
				<div id="media-posts">
					<?php foreach ($photo_and_video_linksRecords as $record): ?>
						<?php
							if (@$record['photo_upload']){
								foreach ($record['photo_upload'] as $index => $upload):
									$imgLocation = $upload['urlPath'];
									$imgUrl = $upload['urlPath'];
									$imgType = '';
									$imgTitle = $record['title'];
								endforeach;
							} else if (@$record['photo_url']){
								$imgLocation = $record['photo_url'];
								$imgUrl = $record['photo_url'];
								$imgType = '';
								$imgTitle = $record['title'];
							} else if (@$record['youtube_video_id']){
								$imgLocation = 'http://img.youtube.com/vi/' . $record['youtube_video_id'] . '/mqdefault.jpg';
								$imgUrl = 'http://www.youtube.com/?v=' . $record['youtube_video_id'];
								$imgType = ' class="mfp-iframe"';
								$imgTitle = '';
							} else if (@$record['vimeo_video_id']){
								$imgLocation = getVimeoInfo($record['vimeo_video_id']);
								$imgUrl = 'http://www.vimeo.com/' . $record['vimeo_video_id'];
								$imgType = ' class="mfp-iframe"';
								$imgTitle = '';

							} else {
								continue;
							}
						?>
						<div class="media-post">
							<a href="<?php echo $imgUrl; ?>"<?php echo $imgType; ?> data-title="<?php echo $imgTitle; ?>">
								<div class="media-post-image" style="background-image:url('<?php echo $imgLocation; ?>');"></div>
							</a>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
	<?php include "includes/footer.php"; ?>
	<script>
		$(document).ready(function(){
			// $('#main-scroll-indicator').click(function(){
			// 	$('html,body').animate({scrollTop: $('#about-blurb').position().top - ($(window).outerWidth() > 767 ? 88 : 44) + "px"}, {duration: 1000})
			// });

			Draggable.create("#hero-drone", {
				type:"y,x",
				edgeResistance:0.65,
				bounds:"#main-image",
				throwProps: true,
				throwResistance: 2000,
				onDragEnd: function(){
					droneHover();
				}
			});

			function droneHover(){
				TweenMax.to($('#hero-drone'), 2.5, {y:"-=30", yoyo: true, repeat: -1, ease: Power1.easeInOut}); 
			}droneHover();

			$('#news-view-more').click(function(){
				$('#news-panel, .overlay').addClass('active');
				$('body').addClass('no-scroll');
			});
			$('#media-view-more').click(function(){
				$('#media-panel, .overlay').addClass('active');
				$('body').addClass('no-scroll');
			});
			$('.panel .close-btn, .overlay').click(function(){
				$('.panel, .overlay').removeClass('active');
				$('body').removeClass('no-scroll');
			});

			$('.airspace-item').click(function(){
				$(this).addClass('selected').removeClass('not-selected');
				$('.airspace-item').not($(this)).addClass('not-selected').removeClass('selected');
			});

			$(window).on('load scroll', function(){
				if (!$('#damage').hasClass('active')) {
					if ($(window).scrollTop() + $(window).height() > ($('#damage').offset().top + ($(window).height() / 3)) && $(window).scrollTop() < $('#damage').offset().top) {
						$('#damage').addClass('active');
						TweenMax.fromTo(lightning1, .4, {opacity:1}, {y: "-=20", opacity:0, scale:1, clearProps:"all", delay: 1.1});
						TweenMax.fromTo(lightning2, .4, {opacity:1}, {y: "-=20", opacity:0, scale:1, clearProps:"all", delay: 1.4});
					}	
				} else {	
					if ($(window).scrollTop() + $(window).height() < ($('#damage').offset().top) || $(window).scrollTop() > ($('#damage').offset().top + $('#damage').height())) {
						$('#damage').removeClass('active');
						// TweenLite.set(lightning1, {clearProps:"all"});
						// TweenLite.set(lightning2, {clearProps:"all"});
					}			
				}
			});

			$('select[name="news-category"]').on('change',function(){
				if ($(this).find('option:selected').attr('value') !== "all"){
					$('.news-post[category!="' + $(this).find('option:selected').attr('value') + '"]').hide();
					$('.news-post[category="' + $(this).find('option:selected').attr('value') + '"]').show();
				} else {
					$('.news-post').show();
				}
			});

		    function initializeGallery() {
		      
		        $('.media .page').each(function() { // the containers for all your galleries
		          $(this).magnificPopup({
		              delegate: 'a', // the selector for gallery item
		              type: 'image',
		              gallery: {
		                enabled:true
		              },
		              image: {
		                titleSrc: 'data-title'
		              },
		          });
		        });
		      
		        $('#media-posts').each(function() { // the containers for all your galleries
		          $(this).magnificPopup({
		              delegate: 'a', // the selector for gallery item
		              type: 'image',
		              gallery: {
		                enabled:true
		              },
		              image: {
		                titleSrc: 'data-title'
		              },
		          });
		        });
	        }initializeGallery();
		});

		$(function() {
		  $('a[href*=#]:not([href=#])').click(function() {
		    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
		      var target = $(this.hash);
		      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
		      if (target.length) {
		        $('html,body').animate({
		          scrollTop: target.offset().top - ($(window).outerWidth() > 767 ? 88 : 44)
		        }, {duration:1000, queue: false});
				$('#navigation').removeClass('active');
		        return false;
		      }
		    }
		  });
		});

		window.onload = function(){
			if(window.location.hash) {
				var hash = window.location.hash.substring(1);
				$(window).scrollTop($('#' + hash).position().top - ($(window).outerWidth() > 767 ? 88 : 44));
			}
		}
	</script>
</body>
</html>