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
                $id = $this->save_movie();
                $url = 'admin.php?page=movie';

                if ($id) {
                    $url = 'admin.php?page=movieview&movie_id=' . $id;
                }

                wp_redirect(admin_url($url));
                break;

            case 'delete':
                $this->delete_movie();
                wp_redirect(admin_url('admin.php?page=movies'));
                break;

            case 'print':

                $this->print_movie();
                break;

            case 'print-order':

                $this->print_order();
                break;
        }

    }

    private function save_movie() {

        $id = '';

        $movie = $this->validateMovie();

        if (!empty($_POST['movie_id'])) {

            $id = esc_html($_POST['movie_id']);

            $result = $this->movieDBService->updateMovie($id, $movie);

        } else {

            $result = $this->movieDBService->saveMovie($movie);
        }

        if ($result)
            $id = $result;

        return $id;

    }


    private function delete_movie() {

        $id = empty($_POST['movie_id']) ? '' : esc_html($_POST['movie_id']);

        $this->movieDBService->deleteMovie($id);

    }

    private function print_movie() {

        if (empty($_POST['printer']) ||
            empty($_POST['movie_id'])) {

            return;
        }
        $format = esc_html($_POST['printer']);

        $movie = $this->movieDBService->findMovieByID(esc_html($_POST['movie_id']));
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

    private function validateMovie() {

        if (empty($_POST['movie_name'])) {

            return false;
        }

        if (empty($_POST['movie_description'])) {

            return false;
        }

        if (empty($_POST['movie_date'])) {

            return false;
        }

        if (empty($_POST['movie_length'])) {

            return false;
        }

        if (empty($_POST['movie_age'])) {

            return false;
        }

        if (empty($_POST['movie_category_id'])) {

            return false;
        }

        $category_id = esc_html($_POST['movie_category_id']);

        $category = BaseRepository::get_base_repository()->get_movie_category_repository()->get_movie_category_by_id($category_id);

        if (!$category) {

            return false;
        }

        $age = esc_html($_POST['movie_age']);
        $recommended_age = get_option('horror_movie_min_age_option');

        if ($category['movie_category_slug'] === 'horor' && $age < $recommended_age) {
            $age = $recommended_age;
        }

        return [
            'movie_name' => esc_html($_POST['movie_name']),
            'movie_description' => esc_html($_POST['movie_description']),
            'movie_date' => esc_html($_POST['movie_date']),
            'movie_length' => esc_html($_POST['movie_length']),
            'movie_age' => $age,
            'movie_category_id' => $category_id,
        ];

    }

    private function print_order() {

        if (empty($_POST['printer']) ||
            empty($_POST['order_id'])) {

            return;
        }
        $order_id=esc_html($_POST['order_id']);
        $format = esc_html($_POST['printer']);

        $order = get_post($order_id);
    }

}