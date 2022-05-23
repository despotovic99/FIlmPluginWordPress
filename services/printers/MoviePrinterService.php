<?php

namespace services\printers;

use Exception;
use OrderService;
use services\MovieService;


require_once 'WordMoviePrinter.php';
require_once 'PdfMoviePrinter.php';
require_once 'WordOrderPrinter.php';
require_once plugin_dir_path(__FILE__) . '../MovieService.php';
require_once plugin_dir_path(__FILE__) . '../OrderService.php';


class MoviePrinterService {

    private $output_dir;

    public function __construct() {
        $this->output_dir = plugin_dir_path(__FILE__) . '../../temp-files';

        $this->movie_service = new MovieService();
        $this->order_service = new OrderService();
    }

    private function get_printer($format) {

        $printer = null;
        switch ($format) {
            case 'word':
                $printer = new WordMoviePrinter();
                break;
            case 'pdf':
                $printer = new PdfMoviePrinter();
                break;
            case 'word-order':
                $printer = new WordOrderPrinter();
                break;
            default:
                throw new Exception('Invalid format');
        }

        return $printer;
    }

    public function print_document($format, $document_id) {

        $printer = $this->get_printer($format);

        if (strpos($format, 'order')) {

            $document = $this->order_service->get_order_information($document_id);
        } else {

            $document = $this->movie_service->find_movie_by_id(esc_html($_REQUEST['movie_id']));
        }


        if (!$document || !$this->can_user_print_order())
            return;


        $file = $printer->print_document($document, $this->output_dir);
        return $file;
    }

    public function can_user_print_order() {

        $user = wp_get_current_user();

        return $user->has_cap('can_print');
    }


}