<?php
namespace services\printers\interfaces;

interface PrinterInterface {

    public function print_document($document, $outputdir);

}