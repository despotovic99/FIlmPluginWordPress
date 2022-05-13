<?php

namespace services\printers;
use PhpOffice;
class WordOrderPrinter {

    public function print_order($order, $outputdir) {

//        $file = $order['movie_name'] . '-Film.doc';

        $file_title = str_replace(' ', '-', $order->post_title);
        $file_title = preg_replace('/[^A-Za-z0-9\-]/', '', $file_title);
        $file= $file_title.'-Order.doc';

        $document = new PhpOffice\PhpWord\PhpWord();

        $section = $document->addSection();

//        $section->addTitle($order['movie_name']);
//        $section->addText('Opis: ' . $order['movie_description']);


        $section->addTitle($file_title);
        $section->addText('Opis: ' . $order->post_content);
        $section->addText('Datum: ' . $order->post_date);
        $section->addText('Status: ' . $order->post_status);
        $section->addText('Name post-a: ' . $order->post_name);


        $objWriter = PhpOffice\PhpWord\IOFactory::createWriter($document, 'Word2007');
        $objWriter->save($outputdir . '/' . $file);

        return $file;
    }

}