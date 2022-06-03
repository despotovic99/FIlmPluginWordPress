<?php

namespace services;

use Exception;
use MovieHelper;
use MovieRepository;
use services\FileService;
use services\printers\PdfMoviePrinter;
use services\printers\WordMoviePrinter;

require_once 'FileService.php';
require_once 'printers/WordMoviePrinter.php';
require_once 'printers/PdfMoviePrinter.php';
require_once plugin_dir_path(__FILE__) . '../components/util/MovieHelper.php';
require_once plugin_dir_path(__FILE__) . '../repositories/MovieRepository.php';

class MovieService {

    private $movie_folder;
    /**
     * @var MovieRepository
     */
    private $movie_repository;

    public function __construct() {
        $this->movie_folder = 'movies';
        $this->movie_repository = new MovieRepository();
    }

    public function find_all_movies($limit, $offset, $orderby, $order) {

        $result = $this->movie_repository
            ->get_movie_data_for_list_table($limit, $offset, $orderby, $order);

        return $result;
    }

    public function find_all_categories() {

        $result = $this->movie_repository->get_movie_categories();
        return $result;
    }


    public function find_movie_by_id($id) {

        $result = $this->movie_repository->get_movie_by_id($id);

        return $result;
    }

    public function find_movie_by_name($name, $limit, $offset, $orderby, $order) {

        $result = $this->movie_repository
            ->get_movie_by_name($name, $limit, $offset, $orderby, $order);

        return $result;
    }

    public function delete_movie($id) {

        $result = $this->movie_repository->delete_movie($id);
        return $result;
    }

    public function update_movie($id, $movie) {

        if (!$this->check_movie_category($movie['movie_category_id'])) {
            return false;
        }

        $movie = $this->check_recommended_age_for_movie($movie);

        $result = $this->movie_repository->update_movie($id, $movie);
        return $result;
    }

    public function save_movie($movie) {

        if (!$this->check_movie_category($movie['movie_category_id'])) {
            return false;
        }

        $movie = $this->check_recommended_age_for_movie($movie);

        return $this->movie_repository->save_new_movie($movie);
    }

    private function check_recommended_age_for_movie($movie) {
        $recommended_age = get_option('horror_movie_min_age_option');
        $category = $this->movie_repository->get_movie_category_by_id($movie['movie_category_id']);

        if (!$category) {
            return false;
        }

        if ($category['movie_category_slug'] === 'horor' && $movie['movie_age'] < $recommended_age) {
            $movie['movie_age'] = $recommended_age;
        }

        return $movie;
    }

    private function check_movie_category($id) {
        return $this->movie_repository
            ->get_movie_category_by_id($id);
    }

    public function print_document($document_type, $movie_id) {
        // todo ovde ime metode mozda ne treba, da bude print_document jer ova metoda
        //  proverava dokument, proverava folder, stampa dokument i download ga

        $movie = $this->find_movie_by_id($movie_id);
        if (!$movie || !$this->can_user_print())
            return false;

        $printer = null;
        switch ($document_type) {
            case 'word':
                $printer = new WordMoviePrinter();
                break;
            case 'pdf':
                $printer = new PdfMoviePrinter();
                break;
            default:
                return false;
        }
        $fs = new FileService($printer);

        try {

            $fs->print_document($movie, $this->movie_folder);
            return true;
        } catch (Exception $e) {

            return false;
        }
    }

    private function can_user_print() {

        $user = wp_get_current_user();

        return get_user_meta($user->ID, 'user_can_print', true) == 1;
    }

}