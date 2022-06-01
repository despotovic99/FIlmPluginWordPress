<?php

class OrderService {

    public function get_order_information($order_id) {

        $order = wc_get_order($order_id);

        return $order;
    }

}