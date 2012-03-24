<form action="<?=base_url();?>user/login" method="POST">
    <table>
        <tr>
            <td colspan="2">
                <h2>Login form</h2>
                <? if(isset($is_error)): ?>
                <div class="error">
                    Invalid login or password. Try again.
                </div>
                <? endif; ?>
            </td>
        </tr>
        <tr>
            <td><label for="username">Username</label></td>
            <td><input id="username" type="text" name="username" placeholder="Username" required autofocus/></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="password" name="password" placeholder="Password" required/></td>
        </tr>
        <tr>
            <td><label for="remember">Remember me</label></td>
            <td><input type="checkbox" id="remember" name="remember" value="remember"/></td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" class="submit" value="Login" />
            </td>
        </tr>
    </table>
</form>