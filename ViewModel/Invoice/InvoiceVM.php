<?php
require_once plugin_dir_path(__FILE__) . '../../services/InvoiceService.php';

class InvoiceVM {

    public function __construct() {

        $this->invoice_service = new InvoiceService();
    }


    public function get_invoice() {

        if (!empty($_GET['invoice_id'])) {
            $invoice_id = esc_html($_GET['invoice_id']);

            $invoice = $this->invoice_service->get_invoice($invoice_id);

        }

        if (!empty($invoice))
            return $invoice;

        return [
            'invoice_id'=>'',
            'order_id'=>'',
            'customer_id'=>'',
            'invoice_date'=>'',
            'customer_full_name'=>'',
            'customer_address'=>'',
            'customer_email'=>'',
            'invoice_currency'=>'',
            'invoice_total'=>'',
            'invoice_number'=>'',
            'order_name'=>'',
            'user'=>'',
        ];

    }


}