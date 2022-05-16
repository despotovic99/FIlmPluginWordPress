<?php


namespace services\printers;
use PhpOffice;
use services\printers\interfaces\PrinterInterface;
require_once 'interface/PrinterInterface.php';
class WordMoviePrinter implements PrinterInterface {

    public function print_document($movie, $outputdir) {

        $file = $movie['movie_name'] . '-Film.doc';

        $document = new PhpOffice\PhpWord\PhpWord();

        $section = $document->addSection();

        $section->addTitle($movie['movie_name']);
        $section->addText('Opis: ' . $movie['movie_description']);
        $section->addText('Datum prikazivanja: ' . $movie['movie_date']);
        $section->addText('Duzina trajanja: ' . $movie['movie_length'] . ' min');
        $section->addText('Predvidjeni uzrast: ' . $movie['movie_age'] . ' god');
        $section->addText('Zanr: ' . $movie['movie_category_name']);

        $objWriter = PhpOffice\PhpWord\IOFactory::createWriter($document, 'Word2007');
        $objWriter->save($outputdir . '/' . $file);

        return $file;
    }
}