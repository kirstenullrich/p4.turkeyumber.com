        <nav class="main">
        	            	<aside class="loggedin">Hi, <?=$user->first_name;?></aside>

                <ul>
                    <li><a href="/trips">All Trips</a></li>
                    <li><a href="/trips/starred">Starred Trips</a></li>
                    <li><a href="/trips/add">Add a New Trip</a></li>
                    <li><a class="last" href="/users/logout">Log Out</a></li>
                </ul>
        </nav>

        <header class="clearfix index">
        	<div class="indexwrap">
            	<a href="/trips"><img src="/../images/notes_logo_lg.png" class="indexlogo" height="175" width="485" alt="Notes from the Road logo"/></a>
            	<div class="indexmsg"></div>
       		</div>

        </header>

        <div class="sub">
            <ul>
            </ul>
        </div>