<?php
/**
 * Name:        Login Form
 * Description: The form the user fills out when the login.
 * Date:        10/26/13
 * Programmer:  Liam Kelly
 */

?>

<form action="./includes/controllers/login.php" method="post">
    <h3>Cloud Burst</h3>
    <em>Video Streaming System</em><br /><br >
    <b>Login:</b><br />
    <label for="username">Username:</label><input type="text" name="username" id="username" /><br />
    <label for="password">Password:</label><input type="password" name="password" id="password" /><br />
    <input type="submit" value="Login" /><br />
    <?php
    if(isset($_SESSION['e'])){
        if($_SESSION['e'] == 'badlogin'){
            ?><span class="error"><i>Username or password is incorrect</i></span><?php
        }
        unset($_SESSION['e']);
    }
    ?>
</form>
