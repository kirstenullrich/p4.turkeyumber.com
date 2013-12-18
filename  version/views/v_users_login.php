<div>

    <h1>Log in</h1>

    <p>Want to post? <a href="/users/signup">Sign up</a>.</p>

    <form class="otherform" method='POST' action='/users/p_login'>

        <label for="email">Email</label>
        <input type='text' name='email'>

        <label for="password">Password</label>
        <input type='password' name='password'>

        <br><br>

        <input type='submit' value='Log in'>

        <?php if(isset($error)): ?>
            <p class='error'>
                Login failed! Please double check your email and password. <br>
                If you've never posted before <a href="/users/signup">sign up here</a> first.
            </p>
        <?php endif; ?>

    </form>
    
</div>