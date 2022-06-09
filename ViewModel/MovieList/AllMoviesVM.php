<?php

use services\MovieService;

require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
require_once plugin_dir_path(__FILE__) . '../Movie/MovieVM.php';
require_once plugin_dir_path(__FILE__) . '../../services/MovieService.php';
require_once plugin_dir_path(__FILE__) . '../../components/util/HTTP_Helper.php';

class AllMoviesVM extends WP_List_Table {

    private $movie_service = null;

    public function __construct($args = array()) {
        parent::__construct($args);

        $this->movie_service = new MovieService();
    }


    public function get_columns() {

        return [
            'cb' => '<input type="checkbox"/>',
            'movie_name' => __('Movie name', 'movie-plugin'),
            'movie_category_name' => __('Category', 'movie-plugin'),
            'movie_date' => __('Date', 'movie-plugin'),
            'movie_length' => __('Length', 'movie-plugin'),
            'movie_age' => __('Recommended age', 'movie-plugin'),
        ];

    }

    protected function column_default($item, $column_name) {

        switch ($column_name) {
            case 'movie_name':
            case 'movie_age':
            case 'movie_category_name':
            case 'movie_date':
            case 'movie_length':
                return $item[$column_name];
            default :
//                return print_r($item, true);
        }
    }

    protected function column_cb($item) {

        return sprintf('<input type="checkbox" name="movie[]" value="%s"/>', $item['movie_id']);
    }

    protected function get_sortable_columns() {

        $sortableColumns = [
            'movie_name' => ['movie_name', true],
            'movie_category_name' => ['movie_category_name', false],
            'movie_date' => ['movie_date', false],
            'movie_age' => ['movie_age', false],
        ];

        return $sortableColumns;

    }

    public function prepare_items() {

        $columns = $this->get_columns();
        $hidden = [];
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = [$columns, $hidden, $sortable];


        $per_page = $this->get_items_per_page('movies_per_page', 2);
        $current_page = $this->get_pagenum();


        $this->items = $this->get_movies($per_page, $current_page);
        $total_items = $this->get_total_movies();


        $this->set_pagination_args([
            'total_items' => $total_items,
            'per_page' => $per_page,
            'total_pages' => ceil($total_items / $per_page),
        ]);

    }

    function column_movie_name($item) {

        $print_url = MovieHelper::get_controller('Movie', 'print_movie', ['movie_id' => $item['movie_id'], 'printer' => 'word']);
        $delete_url = MovieHelper::get_controller('Movie', 'delete_movie', ['movie_id' => $item['movie_id']]);

        $actions = array(
            'view' => sprintf('<a href="?page=%s&%s=%s">%s</a>', 'movieview', 'movie_id', $item['movie_id'], __('View', 'movie-plugin')),
            'edit' => sprintf('<a href="?page=%s&%s=%s">%s</a>', 'movie', 'movie_id', $item['movie_id'], __('Edit', 'movie-plugin')),
            'delete' => sprintf('<a href="' . $delete_url . '">%s</a>', __('Delete', 'movie-plugin')),
            'print' => sprintf('<a href="' . $print_url . '">%s</a>', __('Print', 'movie-plugin')),
        );

        return sprintf('%1$s %2$s', $item['movie_name'], $this->row_actions($actions));
    }

    private function get_movies($per_page = 5, $current_page = 0) {

        $order_by = HTTP_Helper::get_param('orderby');
        $order = HTTP_Helper::get_param('order');

        return $this->movie_service->get_movies(
            $this->get_guery_filters(),
            $per_page,
            $current_page,
            $order_by,
            $order);

    }

    private function get_guery_filters() {

        $filters = [];

        $movie_name = HTTP_Helper::get_param('s');
        if (!empty($movie_name)) {
            $filters['movie_name'] = $movie_name;
        }

        $movie_category = HTTP_Helper::get_param('movie_category');
        if (!empty($movie_category)) {
            $filters['movie_category'] = $movie_category;
        }

        return $filters;
    }

    private function get_total_movies($filters = null) {
        $filters = $filters == null ?$this->get_guery_filters() : $filters;

        return $this->movie_service->get_total_movies($filters);
    }

}