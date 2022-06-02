<?php

namespace services\printers;

use PhpOffice;
use services\printers\interfaces\PrinterInterface;

require_once 'interface/PrinterInterface.php';

class WordOrderPrinter implements PrinterInterface {

    public function print_document($order, $outputdir) {

//        $file = $order['movie_name'] . '-Film.doc';

        $file_title = str_replace(' ', '-', $order->get_order_number());
        $file_title = preg_replace('/[^A-Za-z0-9\-]/', '', $file_title);
        $file = $outputdir . '/' . $file_title . '-Order.doc';

        $document = new PhpOffice\PhpWord\PhpWord();

        $section = $document->addSection();

//        $section->addTitle($order['movie_name']);
//        $section->addText('Opis: ' . $order['movie_description']);


        $section->addTitle($file_title);
        $section->addText('Name ordera ' . $order->get_order_number());
        $section->addText('Datum kreiranja ordera: ' . $order->get_date_created());
        $section->addText('Status: ' . $order->get_status());
        $section->addText('Customer: ' . $order->get_billing_first_name() . " " . $order->get_billing_last_name());
        $section->addText('Shiping to: ' . $order->get_shipping_address_1());
        $section->addText('Total: ' . $order->get_total() . " " . $order->get_currency());


        $objWriter = PhpOffice\PhpWord\IOFactory::createWriter($document, 'Word2007');
        $objWriter->save($file);

        return $file;
    }

}