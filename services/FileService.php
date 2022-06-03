<?php

namespace services;

use MovieHelper;
use services\printers\interfaces\PrinterInterface;

require_once plugin_dir_path(__FILE__) . '../components/util/MovieHelper.php';

class FileService {

    /** @var PrinterInterface */
    private $printer;

    public function __construct(PrinterInterface $printer) {
        $this->printer = $printer;
    }

    public function print_document($document, $output_dir) {
        $output_dir = FILES_DIR . '/' . $output_dir;
        MovieHelper::check_folder_exists_and_create($output_dir);

        $download_path = $this->printer->print_document($document, $output_dir);
        $this->download($download_path);
    }

    public function download($file_path) {

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: 0");
        header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
        header('Content-Length: ' . filesize($file_path));
        header('Pragma: public');

        //Clear system output buffer
        flush();

        readfile($file_path);

        unlink($file_path);
    }
}