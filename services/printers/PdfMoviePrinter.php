<?php

namespace services\printers;
use FPDF;

class PdfMoviePrinter {

    public function print_movie($film, $outputdir) {

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(1, 10, $film['movie_name']);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(-1, 20, $film['movie_description']);
        $pdf->Cell(1, 30, $film['movie_date']);
        $pdf->Cell(-1, 40, $film['movie_length']);
        $pdf->Cell(1, 50, $film['movie_age']);
        $pdf->Cell(-1, 60, $film['movie_category_name']);


        $file_name = $outputdir . '/' . $film['movie_name'];
        $pdf->Output($file_name, 'F');
        return $film['movie_name'];
    }

}