<?php

use services\MovieService;

require_once 'BaseController.php';
require_once plugin_dir_path(__FILE__) . '../services/MovieService.php';
require_once plugin_dir_path(__FILE__) . '../services/OrderService.php';

class MovieController extends BaseController {


    /**
     * @var MovieService
     */
    private $movie_service;

    public function __construct() {
        $this->movie_service = new MovieService();
    }

    public function save_movie() {

        $movie = $this->validate_save_movie_request();
        if (!$movie) {

            return;
        }

        if (!empty($_REQUEST['movie_id'])) {

            $id = sanitize_text_field(wp_unslash($_REQUEST['movie_id']));
            $result = $this->movie_service->update_movie($id, $movie);
        } else {

            $result = $this->movie_service->save_movie($movie);
        }

        $url = 'admin.php?page=movie';

        if ($result)
            $url = 'admin.php?page=movieview&movie_id=' . $result;

        wp_redirect(admin_url($url));
    }


    public function delete_movie() {

        $id = empty($_REQUEST['movie_id']) ? '' : sanitize_text_field(wp_unslash($_REQUEST['movie_id']));
        $result = $this->movie_service->delete_movie($id);

        wp_redirect(admin_url('admin.php?page=movies'));
    }

    public function print_movie() {

        if (empty($_REQUEST['printer']) ||
            empty($_REQUEST['movie_id'])) {

            return;
        }

        $format = sanitize_text_field(wp_unslash($_REQUEST['printer']));
        $movie_id = sanitize_text_field(wp_unslash($_REQUEST['movie_id']));

        try {

            $result = $this->movie_service->print_document($format, $movie_id);
            if (!$result) {

                $this->json_response('You cant print document.',403);
            }
        } catch (Exception $e) {

        }
    }


    private function validate_save_movie_request() {

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

        return [
            'movie_name' => sanitize_text_field(wp_unslash($_POST['movie_name'])),
            'movie_description' => sanitize_text_field(wp_unslash($_POST['movie_description'])),
            'movie_date' => sanitize_text_field(wp_unslash($_POST['movie_date'])),
            'movie_length' => sanitize_text_field(wp_unslash($_POST['movie_length'])),
            'movie_age' =>sanitize_text_field(wp_unslash($_POST['movie_age'])),
            'movie_category_id' => sanitize_text_field(wp_unslash($_POST['movie_category_id'])),
        ];
    }

}