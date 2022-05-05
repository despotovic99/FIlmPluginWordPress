<?php


class WordFilmPrinter {

    public function printFilm($film, $outputdir) {

        $file = $film['naziv_filma'] . '-Film.doc';

        $document = new PhpOffice\PhpWord\PhpWord();

        $section = $document->addSection();

        $section->addTitle($film['naziv_filma']);
        $section->addText('Opis: ' . $film['opis']);
        $section->addText('Datum prikazivanja: ' . $film['pocetak_prikazivanja']);
        $section->addText('Duzina trajanja: ' . $film['duzina_trajanja'] . ' min');
        $section->addText('Predvidjeni uzrast: ' . $film['uzrast'] . ' god');
        $section->addText('Zanr: ' . $film['zanr']);

        $objWriter = PhpOffice\PhpWord\IOFactory::createWriter($document, 'Word2007');
        $objWriter->save($outputdir.'/'.$file);

        return $file;
    }
}