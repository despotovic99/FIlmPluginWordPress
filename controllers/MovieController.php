<?php

use services\MovieService;
use services\printers\MoviePrinterService;

require_once 'BaseController.php';
require_once plugin_dir_path(__FILE__) . '../services/MovieService.php';
require_once plugin_dir_path(__FILE__) . '../services/OrderService.php';
require_once plugin_dir_path(__FILE__) . '../services/printers/MoviePrinterService.php';

class MovieController extends BaseController {


    public function __construct() {

        $this->movie_db_service = new MovieService();
        $this->movie_print_service = new MoviePrinterService();
        $this->order_service = new OrderService();
    }


    public  function save_movie() {

        $id = '';

        $movie = $this->validate_movie();

        if (!empty($_REQUEST['movie_id'])) {

            $id = esc_html($_REQUEST['movie_id']);

            $result = $this->movie_db_service->update_movie($id, $movie);

        } else {

            $result = $this->movie_db_service->save_movie($movie);
        }

        if ($result)
            $id = $result;

        $url = 'admin.php?page=movie';

        if ($id) {
            $url = 'admin.php?page=movieview&movie_id=' . $id;
        }

        wp_redirect(admin_url($url));

    }


    public function delete_movie() {

        $id = empty($_REQUEST['movie_id']) ? '' : esc_html($_REQUEST['movie_id']);

        $this->movie_db_service->delete_movie($id);

        wp_redirect(admin_url('admin.php?page=movies'));

    }

    public function print_movie() {

        //todo testiranja radi
        if (!$this->movie_print_service->can_user_print_order()) {

            return;
        }

        if (empty($_REQUEST['printer']) ||
            empty($_REQUEST['movie_id'])) {

            return;
        }
        $format = esc_html($_REQUEST['printer']);

        $movie = $this->movie_db_service->find_movie_by_id(esc_html($_REQUEST['movie_id']));
        if (!$movie) {

            return;
        }

        try {

            $file = $this->movie_print_service->print_document($format, $movie);

            $file_path = plugin_dir_path(__FILE__) . '../temp-files/' . $file;

            $this->download_file($file_path);


        } catch (Exception $e) {

            return;
        }

    }


    public function print_order() {

        if (!$this->movie_print_service->can_user_print_order()) {

            return;
        }

        if (empty($_REQUEST['printer']) ||
            empty($_REQUEST['order_id'])) {

            return;
        }
        $order_id = esc_html($_REQUEST['order_id']);
        $format = esc_html($_REQUEST['printer']);

        $order = $this->order_service->get_order_information($order_id);

        if (!$order) {

            return;
        }

        try {

            $file = $this->movie_print_service->print_document($format, $order);

            $file_path = plugin_dir_path(__FILE__) . '../temp-files/' . $file;

            $this->download_file($file_path);


        } catch (Exception $e) {

            return;
        }

    }

    public function get_order_information() {


        if (empty($_REQUEST['order_id']))
            return;

        $order_id = esc_html($_REQUEST['order_id']);

        $order = $this->order_service->get_order_information($order_id);

        wp_send_json_success('neki data');

    }

    private function download_file($file_path) {

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

    private function validate_movie() {

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




}