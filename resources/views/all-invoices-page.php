<?php
require_once plugin_dir_path(__FILE__) . '../../ViewModel/Invoice/AllInvoicesVM.php';

$all_invoices_vm = new AllInvoicesVM();

$all_invoices = $all_invoices_vm->get_all_invoices();
?>

<div class="wrap">
    <?php
    $all_invoices_vm->prepare_items();

    $all_invoices_vm->display();
    ?>
</div>
