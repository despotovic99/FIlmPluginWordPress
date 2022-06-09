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

        $result = $this->invoice_service->create_invoice(sanitize_text_field(wp_unslash($_REQUEST['order_id'])));

        if($result){
            $this->json_response('Invoice created successfully',200);

        }else{

            $this->json_response('ERROR: Invoice not created',500);
        }

    }

    public function delete_invoice(){
        if(empty($_REQUEST['invoice_id'])){

            return;
        }

        $result = $this->invoice_service->delete_invoice(sanitize_text_field(wp_unslash($_REQUEST['invoice_id'])));
        if($result){
            $this->json_response('Invoice deleted successfully',200);
        }else{
            $this->json_response('ERROR: Invoice not deleted',500);
        }

    }


}