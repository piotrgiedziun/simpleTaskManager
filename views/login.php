<form action="" method="POST">
    <? if(isset($is_error)): ?>
        Invalid login or password. Try again.
    <? endif; ?>
    <ul id="login">
        <li><h2>Login form</h2></li>
        <li><input type="text" name="username" placeholder="Username" /></li>
        <li><input type="password" name="password" placeholder="Password" /></li>
        <li><input type="submit" id="submit" value="Login" /></li>
    </ul>
</form>