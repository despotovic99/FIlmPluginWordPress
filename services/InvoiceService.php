<?php
require_once plugin_dir_path(__FILE__) . '../repositories/InvoiceRepository.php';

class InvoiceService {

    /**
     * @var InvoiceRepository
     */
    public $invoice_repository;

    public function __construct() {
        $this->invoice_repository = new InvoiceRepository();
    }

    public function get_invoice($invoice_id) {

        $result = $this->invoice_repository->get_invoice_by_id($invoice_id);

        if (!$result)
            return $result;

        $order = get_post($result['order_id']);
        $user = get_user_by('id', $result['user_id']);

        $result['order_name'] = $order->post_name;
        $result['user'] = $user->first_name . " " . $user->last_name;

        return $result;

    }

    public function get_all_invoices_for_list_table($limit, $offset, $orderby, $order) {

        $invoices = $this->invoice_repository->get_all_invoices($limit, $offset, $orderby, $order);
        for ($i = 0; $i < count($invoices); $i++) {
            try {
                $order = get_post($invoices[$i]['order_id']);
                $invoices[$i]['order_name'] = $order->post_name;
                $invoices[$i]['invoice_total'] .= $invoices[$i]['invoice_currency'];
            } catch (Exception $e) {

            }
        }
        return $invoices;
    }

    public function get_all_total_items() {

        return $this->invoice_repository->get_total_items();
    }

    public function get_total_items($name) {
        return $this->invoice_repository->get_total_items($name);
    }

    public function find_invoices_by_name($name, $limit, $offset, $orderby, $order) {

        $invoices = $this->invoice_repository->get_invoices_by_name($name, $limit, $offset, $orderby, $order);

        for ($i = 0; $i < count($invoices); $i++) {
            try {
                $order = get_post($invoices[$i]['order_id']);
                $invoices[$i]['order_name'] = $order->post_name;
                $invoices[$i]['invoice_total'] .= $invoices[$i]['invoice_currency'];
            } catch (Exception $e) {

            }
        }
        return $invoices;
    }

    public function create_invoice($order_id) {

        $order = wc_get_order($order_id);
        $user = wp_get_current_user();

        $invoice = [];
        $invoice_items = [];


        foreach ($order->get_items() as $item_id => $item) {

            $invoice_items[] = [
                'product_name' => $item->get_name(),
                'product_quantity' => $item->get_quantity(),
                'product_price' => $item->get_product()->get_price()
            ];

        }


        $invoice['invoice_number'] = 'Invoice-' . $order->get_order_number();
        $invoice['order_id'] = $order_id;
        $invoice['user_id'] = $user->ID;
        $invoice['customer_id'] = $order->get_customer_id();
        // customer se nije registorvao
        if ($invoice['customer_id'] < 1) {
            $invoice['customer_id'] = null;
        }
        $invoice['invoice_date'] = $order->get_date_created();
        $invoice['customer_full_name'] = $order->get_billing_first_name() . " " . $order->get_billing_last_name();
        $invoice['customer_address'] = $order->get_shipping_address_1();
        $invoice['customer_email'] = $order->get_billing_email();
        $invoice['invoice_currency'] = $order->get_currency();
        $invoice['invoice_total'] = $order->get_total();

        $result = $this->invoice_repository->save_invoice($invoice, $invoice_items);

        return $result;
    }


    public function delete_invoice($invoice_id) {

        $result = $this->invoice_repository->delete_invoice_by_id($invoice_id);

        return $result;
    }


}