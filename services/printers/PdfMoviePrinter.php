<?php

namespace services\printers;
use FPDF;
use services\printers\interfaces\PrinterInterface;
require_once 'interface/PrinterInterface.php';

class PdfMoviePrinter implements PrinterInterface {

    public function print_document($movie, $outputdir) {

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(1, 10, $movie['movie_name']);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(-1, 20, $movie['movie_description']);
        $pdf->Cell(1, 30, $movie['movie_date']);
        $pdf->Cell(-1, 40, $movie['movie_length']);
        $pdf->Cell(1, 50, $movie['movie_age']);
        $pdf->Cell(-1, 60, $movie['movie_category_name']);


        $file_name = $outputdir . '/' . $movie['movie_name'];
        $pdf->Output($file_name, 'F');
        return $movie['movie_name'];
    }


}