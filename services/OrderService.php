<?php

use services\FileService;
use services\printers\WordOrderPrinter;
require_once 'printers/WordOrderPrinter.php';
require_once '../components/util/MovieHelper.php';

class OrderService {

    private $order_folder;

    public function __construct() {
        $this->order_folder = FILES_DIR . '/orders/';
    }

    public function get_order_information($order_id) {

        $order = wc_get_order($order_id);

        return $order;
    }

    public function print_order($document_type, $order_id) {
        $printer = null;
        switch ($document_type) {
            case 'word':
                $printer = new WordOrderPrinter();
                break;
        }

        $fs = new FileService($printer);

        $order = $this->get_order_information($order_id);
        if (!$order || !$this->can_user_print_order())
            return false;

        try {
            MovieHelper::check_folder_exists_and_create($this->order_folder);
            $file_path = $fs->print_document($order, $this->order_folder);
            $fs->download($file_path);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    private function can_user_print_order() {
            // todo ovo izmesti u movie helper
        $user = wp_get_current_user();

        return get_user_meta($user->ID, 'user_can_print', true) == 1;
    }

}