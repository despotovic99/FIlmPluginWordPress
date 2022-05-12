<?php


namespace services\printers;
use PhpOffice;

class WordMoviePrinter {

    public function printFilm($film, $outputdir) {

        $file = $film['movie_name'] . '-Film.doc';

        $document = new PhpOffice\PhpWord\PhpWord();

        $section = $document->addSection();

        $section->addTitle($film['movie_name']);
        $section->addText('Opis: ' . $film['movie_description']);
        $section->addText('Datum prikazivanja: ' . $film['movie_date']);
        $section->addText('Duzina trajanja: ' . $film['movie_length'] . ' min');
        $section->addText('Predvidjeni uzrast: ' . $film['movie_age'] . ' god');
        $section->addText('Zanr: ' . $film['movie_category_name']);

        $objWriter = PhpOffice\PhpWord\IOFactory::createWriter($document, 'Word2007');
        $objWriter->save($outputdir . '/' . $file);

        return $file;
    }
}