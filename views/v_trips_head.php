        <nav class="main">
            <aside class="loggedin">
                Hi, <?=$user->first_name;?>
            </aside>

                <ul>
                    <li><a href="/trips">All Trips</a></li>
                    <li><a href="/trips/starred">Starred Trips</a></li>
                    <li><a href="/trips/add">Add a New Trip</a></li>
                    <li><a class="last" href="/users/logout">Log Out</a></li>
                </ul>
        </nav>

        <header class="clearfix">
            <a href="/trips"><img src="/../images/notes_logo_sm.png" class="smalllogo" height="100" width="277" alt="Notes from the Road logo"/></a>
        </header>

        <div class="sub">
            <h2>Trip Dashboard</h2>
        </div>