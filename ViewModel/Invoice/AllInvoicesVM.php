<?php
require_once plugin_dir_path(__FILE__) . '../../services/InvoiceService.php';

class AllInvoicesVM {

    public function __construct() {

        $this->invoice_service = new InvoiceService();
    }

}