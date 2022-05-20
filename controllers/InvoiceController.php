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

        $result = $this->invoice_service->create_invoice(esc_html($_REQUEST['order_id']));

        if($result){
            wp_send_json('Invoice created successfully');
        }else{
            wp_send_json('ERROR: Invoice not created');
        }

    }

    public function delete_invoice(){
        if(empty($_REQUEST['invoice_id'])){

            return;
        }

        $result = $this->invoice_service->delete_invoice(esc_html($_REQUEST['invoice_id']));
        if($result){
            wp_send_json('Invoice deleted successfully');
        }else{
            wp_send_json('ERROR: Invoice not deleted');
        }

    }


}