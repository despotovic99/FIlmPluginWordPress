<?php
require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
require_once plugin_dir_path(__FILE__) . '../Movie/MovieVM.php';

class WP_Movie_List_Table extends WP_List_Table {

    private $movieData;
    private $total_items;

    public function __construct($args = array(), $movieData) {
        parent::__construct($args);
        $this->movieData = $movieData[0];
        $this->total_items = $movieData[1]['total_items'];
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


        $perPage = $this->get_items_per_page('movies_per_page', 2);

        $totalItems = $this->total_items;

        $this->set_pagination_args([
            'total_items' => $totalItems,
            'per_page' => $perPage,
            'total_pages' => ceil($totalItems / $perPage),
        ]);

        $this->items = $this->movieData;
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


}