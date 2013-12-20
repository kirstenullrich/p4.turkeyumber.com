<!DOCTYPE html>
<html>
<head>
	<title><?php if(isset($title)) echo $title; ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Sitewide JS/CSS -->
    <link rel="stylesheet" href="/css/normalize.css">
    <link rel="stylesheet" href="/css/style.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/js/vendors/colorbox/colorbox.css">
    <script src="/js/vendor/modernizr-2.6.2.min.js"></script>	
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>    
    <script src="/js/dashboard.js"></script>
    <script src="/js/vendors/colorbox/jquery.colorbox-min.js"></script>

	<!-- Controller Specific JS/CSS -->
	<?php if(isset($client_files_head)) echo $client_files_head; ?>
	
</head>

<body>
    <!-- Top for users who are logged in -->
        <?php if($user): ?>
            <?php if(isset($nav)) echo $nav; ?>

        	<?php if(isset($head)) echo $head; ?>


    <!-- Top for users who are not logged in -->
        <?php else: ?>

        <nav class="main">
                <ul>
                    
                </ul>
        </nav>

        <header class="clearfix index">
            <div class="indexwrap">
                <img src="/../images/notes_logo_lg.png" class="indexlogo" height="175" width="485" alt="Notes from the Road logo"/>
                <div class="indexmsg">Share stories and photos from your trip in the continental U.S. as you go!</div>
            </div>

        </header>

        <div class="sub">
            <ul>
            </ul>
        </div>

        <?php endif; ?>

	<?php if(isset($content)) echo $content; ?>

	<?php if(isset($client_files_body)) echo $client_files_body; ?>
</body>
</html>