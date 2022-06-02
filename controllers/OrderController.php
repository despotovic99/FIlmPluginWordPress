<?php

class OrderController extends BaseController {

    /**
     * @var OrderService
     */
    private $order_service;

    public function __construct() {
        $this->order_service = new OrderService();
    }

    public function print_order() {

        if (empty($_REQUEST['printer']) ||
            empty($_REQUEST['order_id'])) {

            return;
        }

        $order_id = esc_html($_REQUEST['order_id']);
        $format = esc_html($_REQUEST['printer']);
        try {

            $result = $this->order_service->print_order($format, $order_id);
            if (!$result) {

                wp_send_json(['You cant print document.']);
            }
        } catch (Exception $e) {

        }
    }

    public function get_order_information() {

        if (empty($_REQUEST['order_id']))
            return;

        $order_id = esc_html($_REQUEST['order_id']);
        $order = $this->order_service->get_order_information($order_id);

        wp_send_json([strval($order)]);
    }




}