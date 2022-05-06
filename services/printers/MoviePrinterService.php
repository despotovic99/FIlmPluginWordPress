<?php

namespace services\printers;

require_once 'WordMoviePrinter.php';
require_once 'PdfMoviePrinter.php';

class MoviePrinterService {

    private $output_dir;

    public function __construct() {
        $this->output_dir = plugin_dir_path(__FILE__) . '../../../temp-files';
    }

    private function getPrinter($format) {

        $printer = null;
        switch ($format) {
            case 'word':
                $printer = new WordMoviePrinter();
                break;
            case 'pdf':
                $printer = new PdfMoviePrinter();
                break;
            default:
                throw new Exception('Invalid format');
        }

        return $printer;
    }

    public function printFilm($format, $film) {

        $printer = $this->getPrinter($format);

        $file = $printer->printFilm($film, $this->output_dir);
        return $file;
    }

}