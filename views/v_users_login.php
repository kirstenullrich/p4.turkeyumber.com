<div class="contentwrap clearfix">

    <div id="dash">
        <div id="top">
            <h1>Log In</h1>
        </div>
    </div>

    <div id="entry_list">

        <p>Want to post or create a starred list of your favorite trips? <a href="/users/signup">Sign up!</a></p>

        <form class="otherform" method='POST' action='/users/p_login'>

            <label>Email</label>
            <input type='text' required name='email'>

            <label>Password</label>
            <input type='password' required name='password'>

            <br><br>

            <input type='submit' value='Log in'>

            <?php if(isset($error)): ?>
                <p class='red error'>
                    Login failed! Please double check your email and password. <br>
                    If you've never posted before <a href="/users/signup">sign up here</a> first.
                </p>
            <?php endif; ?>

        </form>

    </div>
    
</div>