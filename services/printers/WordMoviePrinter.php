<?php


namespace services\printers;

use PhpOffice;
use services\MovieService;
use services\printers\interfaces\PrinterInterface;

require_once 'interface/PrinterInterface.php';

class WordMoviePrinter implements PrinterInterface {

    public function __construct() {
        $this->movie_service = new MovieService();
    }

    public function print_document($movie, $outputdir) {

        $file = $outputdir . '/' . $movie['movie_name'] . '-Film.doc';

        $document = new PhpOffice\PhpWord\PhpWord();

        $section = $document->addSection();

        $section->addTitle($movie['movie_name']);
        $section->addText('Opis: ' . $movie['movie_description']);
        $section->addText('Datum prikazivanja: ' . $movie['movie_date']);
        $section->addText('Duzina trajanja: ' . $movie['movie_length'] . ' min');
        $section->addText('Predvidjeni uzrast: ' . $movie['movie_age'] . ' god');
        $section->addText('Zanr: ' . $movie['movie_category_name']);

        $objWriter = PhpOffice\PhpWord\IOFactory::createWriter($document, 'Word2007');
        $objWriter->save($file);

        return $file;
    }
}