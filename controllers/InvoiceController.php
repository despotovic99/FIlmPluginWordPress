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

        //todo unfinished
        $this->invoice_service->create_invoice(esc_html($_REQUEST['order_id']));


    }

}