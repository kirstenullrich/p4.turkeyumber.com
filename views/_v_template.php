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
    <script src="/js/vendor/modernizr-2.6.2.min.js"></script>	
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>    
    <script src="/js/dashboard.js"></script>

	<!-- Controller Specific JS/CSS -->
	<?php if(isset($client_files_head)) echo $client_files_head; ?>
	
</head>

<body>
        <?php if($user): ?>
    <!-- Top for users who are logged in -->

        	<?php if(isset($head)) echo $head; ?>


        <?php else: ?>
    <!-- Top for users who are not logged in -->

            <nav class="main">
                    <ul>
                        <li><a class="last" href="/users/login">Log In</a></li>
                        <li><a class="last" href="/users/signup">Sign Up</a></li>
                    </ul>
            </nav>

             <header class="clearfix index">
                <div class="indexwrap">
                    <a href="/open"><img src="/../images/notes_logo_lg.png" class="indexlogo" height="175" width="485" alt="Notes from the Road logo"/></a>
                    <div class="indexmsg"></div>
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