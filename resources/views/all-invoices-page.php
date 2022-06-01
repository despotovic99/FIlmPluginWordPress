<?php
require_once plugin_dir_path(__FILE__) . '../../ViewModel/Invoice/AllInvoicesVM.php';

$all_invoices_vm = new AllInvoicesVM();

?>

<div class="wrap">
    <?php $all_invoices_vm->prepare_items(); ?>
    <form method="post">
        <p class="search-box">
            <?php $all_invoices_vm->search_box(esc_html(__('Find invoice', 'movie-plugin')), 'search_invoice'); ?>
        </p>
    </form>
    <h2>Invoices</h2>
    <?php $all_invoices_vm->display(); ?>
</div>
