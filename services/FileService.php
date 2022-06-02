<?php

namespace services;

use services\printers\interfaces\PrinterInterface;

class FileService {

    /** @var PrinterInterface */
    private $pi;

    public function __construct(PrinterInterface $pi) {
        $this->pi = $pi;
    }

    public function print_document($document, $output_dir) {
        return $this->pi->print_document($document, $output_dir);
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