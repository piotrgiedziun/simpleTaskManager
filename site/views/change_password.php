<form action="<?=base_url();?>user/change_password" method="POST">
    <table>
        <tr>
            <td colspan="2">
                <h2>Change password form</h2>
                <? if(isset($is_error)): ?>
                <div class="error">
                    <?=$is_error; ?>
                </div>
                <? endif; ?>
            </td>
        </tr>
        <tr>
            <td>Old password</td>
            <td><input type="password" name="old_password" placeholder="Old password" required autofocus/></td>
        </tr>
        <tr>
            <td>New password</td>
            <td><input type="password" name="new_password" placeholder="New password" required/></td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" class="submit" value="Change password" />
            </td>
        </tr>
    </table>
</form>