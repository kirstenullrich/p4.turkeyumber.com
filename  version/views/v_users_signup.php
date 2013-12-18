<div>

    <h1>Sign up</h1>
    
    <p>All fields are required.</p>

    <form method='POST' action='/users/p_signup'>

        <label for="first_name">First Name</label>
        <input type='text' name='first_name' required placeholder="Enter your first name">

        <label for="last_name">Last Name</label>
        <input type='text' name='last_name' required placeholder="Enter your last name"> 

        <label for="email">Email</label>
        <input type='text' name='email' required placeholder="Enter your email address">

        <label for="password">Password</label>
        <input type='password' name='password' required placeholder="Enter a password">
        <br><br>

        <input type='submit' value='Sign up'>

        <?php if(isset($error) && $error == 'missing'): ?>
            <p class='error'>
                Looks like you didn't fill out all the fields. Please try again.<br>
            </p>
        <?php endif; ?>

        <?php if(isset($error) && $error == 'dupemail'):?>
            <p class="error">
            This email address is aready in in use. Please choose another.
            </p>
        <?php endif;?>

    </form>

</div>