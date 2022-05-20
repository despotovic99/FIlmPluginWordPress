<?php
require_once plugin_dir_path(__FILE__) . '../../services/InvoiceService.php';

class InvoiceVM {

    public function __construct() {

        $this->invoice_service = new InvoiceService();
    }


    public function get_invoice(){

        $this->invoice_service->get_all_invoices_for_list_table();
    }




}