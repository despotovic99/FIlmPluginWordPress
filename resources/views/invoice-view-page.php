<?php
require_once plugin_dir_path(__FILE__) . '../../ViewModel/Invoice/InvoiceVM.php';

$invoice_vm = new InvoiceVM();
$invoice = $invoice_vm->get_invoice();
?>

<div class="wrap">


</div>
