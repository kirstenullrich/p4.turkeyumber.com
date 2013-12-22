<div class="contentwrap clearfix">

    <div id="dash">
        <div id="top">
            <h1>Sign Up</h1>
        </div>
    </div>

    <div id="entry_list">
    
        <p>All fields are required.</p>

        <form class="otherform" method='POST' action='/users/p_signup'>

            <label>First Name</label>
            <input type='text' name='first_name' required placeholder="Enter your first name">

            <label>Last Name</label>
            <input type='text' name='last_name' required placeholder="Enter your last name"> 

            <label>Email</label>
            <input type='text' name='email' required placeholder="Enter your email address">

            <label>Password</label>
            <input type='password' name='password' required placeholder="Enter a password">
            <br><br>

            <input type='submit' value='Sign up'>

            <?php if(isset($error) && $error == 'missing'): ?>
                <p class='red error'>
                    Looks like you didn't fill out all the fields. Please try again.<br>
                </p>
            <?php endif; ?>

            <?php if(isset($error) && $error == 'dupemail'):?>
                <p class="red error">
                This email address is aready in in use. Please choose another.
                </p>
            <?php endif;?>

        </form>
    </div>
</div>