<?php
require_once plugin_dir_path(__FILE__) . '../../../ViewModel/UserProfile/UserPrintOptionVM.php';

$user_print_option_vm = new UserPrintOptionVM();

?>
<table class="form-table">
    <tbody>
    <tr class="row">
        <th><?= __('Can user print', 'movie-plugin') ?></th>
        <td>
            <input type="checkbox" value="1" name="can_user_print_input"
                <?php
                if ($user_print_option_vm->can_user_print()) {
                    echo 'checked';
                }
                ?>
            />
        </td>
    </tr>
    </tbody>
</table>