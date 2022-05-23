<?php
require_once plugin_dir_path(__FILE__) . '../../ViewModel/Invoice/InvoiceVM.php';

$invoice_vm = new InvoiceVM();
$invoice = $invoice_vm->get_invoice();
?>

<div class="wrap">

    <div class="blog-container">

        <div class="blog-body">
            <div class="blog-title">
                <h1><?= $invoice['invoice_number'] ?></h1>
            </div>
            <div class="blog-summary">
                <p>Order: <?= $invoice['order_name'] ?></p>
            </div>
            <div class="blog-summary">
                <p>Invoice date: <?= $invoice['invoice_date'] ?></p>
            </div>
            <div class="blog-summary">
                <p>Customer name: <?= $invoice['customer_full_name'] ?></p>
                <p> address: <?= $invoice['customer_address'] ?></p>
                <p> email: <?= $invoice['customer_email'] ?> </p>
            </div>

            <div class="blog-summary">
                <h2>Invoice items</h2>
                <table>
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>pcs</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($invoice['invoice_items'] as $item) { ?>
                        <tr>
                            <td><?= $item['product_name'] ?></td>
                            <td><?= $item['product_quantity'] ?> pcs</td>
                            <td><?= $item['product_quantity'] * $item['product_price'] . " " . $invoice['invoice_currency'] ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="blog-summary">
                <h3>Total: <?= $invoice['invoice_total'] . " " . $invoice['invoice_currency'] ?> </h3>
            </div>

        </div>

        <div class="blog-footer">
            <a class="button" href="?page=invoices">Back</a>
        </div>
    </div>
</div>