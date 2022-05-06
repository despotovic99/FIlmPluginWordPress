<?php

use services\MovieService;
use services\printers\MoviePrinterService;

require_once 'interface/ControllerInterface.php';
require_once plugin_dir_path(__FILE__) . '../services/MovieService.php';
require_once plugin_dir_path(__FILE__) . '../services/printers/MoviePrinterService.php';

class MovieController implements ControllerInterface {


    public function __construct() {

        $this->movieDBService = new MovieService();
        $this->moviePrintService = new MoviePrinterService();
    }

    public function handleAction($action) {

        switch ($action) {
            case 'save':
                $id = $this->saveMovie();
                $url = 'admin.php?page=movie';

                if ($id) {
                    $url = 'admin.php?page=movieview&movie_id=' . $id;
                }

                wp_redirect(admin_url($url));
                break;

            case 'delete':
                $this->deleteMovie();
                wp_redirect(admin_url('admin.php?page=movies'));
                break;

            case 'print':

                $this->printMovie();
                break;
        }

    }

    private function saveMovie() {

        $id = '';

        if (!empty($_POST['movie_id'])) {

            $id = esc_html($_POST['movie_id']);

            $result = $this->movieDBService->updateMovie($id);

        } else {

            $result = $this->movieDBService->saveMovie();
        }

        if ($result)
            $id = $result;

        return $id;

    }


    private function deleteMovie() {

        $id = empty($_POST['movie_id']) ? '' : esc_html($_POST['movie_id']);

        $this->movieDBService->deleteMovie($id);

    }

    private function printMovie() {

        if (empty($_POST['printer']) ||
            empty($_GET['movie_id'])) {

            return;
        }
        $format = esc_html($_POST['printer']);

        $movie = $this->movieDBService->findMovieByID(esc_html($_GET['movie_id']));
        if (!$movie) {

            return;
        }

        try {

            $file = $this->moviePrintService->printFilm($format, $movie);

            $file_path = plugin_dir_path(__FILE__) . '../temp-files/' . $file;

            $this->downloadFile($file_path);


        } catch (Exception $e) {

            return;
        }


    }

    private function downloadFile($file_path) {

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: 0");
        header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
        header('Content-Length: ' . filesize($file_path));
        header('Pragma: public');

//Clear system output buffer
        flush();

        readfile($file_path);

        unlink($file_path);
    }

}