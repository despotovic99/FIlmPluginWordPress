<?php
require_once 'BaseController.php';

class InvoiceController extends BaseController {

    public function __construct() {
        $this->invoice_service = new InvoiceService();
    }

    public function create_invoice() {

        if (empty($_REQUEST['order_id'])) {

            return;
        }

        //todo  ovde vrati neki boolean da bi client znao sta se desava
        $result = $this->invoice_service->create_invoice(esc_html($_REQUEST['order_id']));

        if($result){
            wp_send_json('Invoice created successfully');
        }else{
            wp_send_json('ERROR: Invoice not created');
        }

    }

}