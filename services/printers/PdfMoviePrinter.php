<?php

namespace services\printers;
use FPDF;

class PdfMoviePrinter {

    public function printFilm($film, $outputdir) {

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(1, 10, $film['naziv_filma']);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(-1, 20, $film['opis']);
        $pdf->Cell(1, 30, $film['pocetak_prikazivanja']);
        $pdf->Cell(-1, 40, $film['duzina_trajanja']);
        $pdf->Cell(1, 50, $film['uzrast']);
        $pdf->Cell(-1, 60, $film['zanr']);


        $file_name = $outputdir . '/' . $film['naziv_filma'];
        $pdf->Output($file_name, 'F');
        return $film['naziv_filma'];
    }

}