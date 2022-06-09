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

        $order_id = sanitize_text_field(wp_unslash($_REQUEST['order_id']));
        $format = sanitize_text_field(wp_unslash($_REQUEST['printer']));
        try {

            $result = $this->order_service->print_order($format, $order_id);
            if (!$result) {

                $this->json_response('You cant print document.',403);
            }
        } catch (Exception $e) {

        }
    }

    public function get_order_information() {

        if (empty($_REQUEST['order_id']))
            return;

        $order_id = sanitize_text_field(wp_unslash($_REQUEST['order_id']));
        $order = $this->order_service->get_order_information($order_id);

        $this->json_response([strval($order)],200);
    }

}