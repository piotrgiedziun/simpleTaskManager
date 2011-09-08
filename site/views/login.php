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
            <td>Username</td>
            <td><input type="text" name="username" placeholder="Username" required autofocus/></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="password" name="password" placeholder="Password" required/></td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" class="submit" value="Login" />
            </td>
        </tr>
    </table>
</form>