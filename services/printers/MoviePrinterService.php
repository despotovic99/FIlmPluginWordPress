<?php

namespace services\printers;

require_once 'WordMoviePrinter.php';
require_once 'PdfMoviePrinter.php';
require_once 'WordOrderPrinter.php';


class MoviePrinterService {

    private $output_dir;

    public function __construct() {
        $this->output_dir = plugin_dir_path(__FILE__) . '../../temp-files';
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

    public function print_movie($format, $movie) {

        $printer = $this->get_printer($format);

        $file = $printer->print_movie($movie, $this->output_dir);
        return $file;
    }

    public function print_order($format, $order) {

        $printer = $this->get_printer($format);

        $file = $printer->print_order($order, $this->output_dir);

        return $file;
    }


}