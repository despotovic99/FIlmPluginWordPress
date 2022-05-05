<?php

require_once 'WordFilmPrinter.php';
require_once 'PdfFilmPrinter.php';

class FilmPrinterService {


    private function getPrinter($format) {

        $printer = null;
        switch ($format) {
            case 'word':
                $printer = new WordFilmPrinter();
                break;
            case 'pdf':
                $printer = new PdfFilmPrinter();
                break;
            default:
                throw new Exception('Neodgovarajuci format');
        }

        return $printer;
    }

    public function printFilm($format, $film) {

        $printer = $this->getPrinter($format);

        $file =$printer->printFilm($film);
        return  $file;
    }

}