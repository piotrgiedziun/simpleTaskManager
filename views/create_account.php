<form action="<?=base_url();?>user/create_account" method="POST">
    <table>
        <tr>
            <td colspan="2">
                <h2>Create account</h2>
                <? if(isset($is_error)): ?>
                    <?=$is_error; ?>
                <? endif; ?>
            </td>
        </tr>
        <tr>
            <td>Username</td>
            <td><input type="text" name="username" placeholder="Username" value="" required autofocus/></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="password" name="password" placeholder="Password" required/></td>
        </tr>
        <tr>
            <td>Mail</td>
            <td><input type="email" name="mail" placeholder="Mail" value="" required/></td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" class="submit" value="Create account" />
            </td>
        </tr>
    </table>
</form>