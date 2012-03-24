<script>
function confirmDelete() {
  if (confirm("Are you sure you want to delete your account?")) {
    document.location = '<?=base_url();?>user/delete';
  }
}
</script>
<table>
    <tr>
         <td colspan="2"><strong><?=$user->get_username();?></strong> (ID:<?=$user->get_id();?>)</td>
    </tr>
    <tr>
        <td>Since</td>
        <td><?=date("Y-m-d", $user->get_created()); ?></td>
    </tr>
    <? if($logged_account): ?>
    <tr>
         <td colspan="2"><a href="<?=base_url();?>user/change_password">Change password</a></td>
    </tr>
    <tr>
         <td colspan="2"><a href="#" onclick="confirmDelete(); return false;">Delete account</a></td>
    </tr>
    <? endif; ?>
</table>