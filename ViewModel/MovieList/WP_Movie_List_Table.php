<?php
require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
require_once plugin_dir_path(__FILE__) . '../Movie/MovieVM.php';

class WP_Movie_List_Table extends WP_List_Table {

    private $movieData;

    public function __construct($args = array(), $movieData) {
        parent::__construct($args);
        $this->movieData = $movieData;
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
//            'uzrast' => ['uzrast', false],
        ];

        return $sortableColumns;

    }

    private function usort_reorder($a, $b) {

        $orderby = (!empty($_GET['orderby'])) ? $_GET['orderby'] : 'movie_name'; // po kojoj koloni
        $order = (!empty($_GET['order'])) ? $_GET['order'] : 'asc'; //rastuci ili opadajuci redosled
        $result = strcmp($a[$orderby], $b[$orderby]);

        return ($order == 'asc') ? $result : -$result;
    }

    public function prepare_items() {

        $columns = $this->get_columns();
        $hidden = [];
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = [$columns, $hidden, $sortable];


        $perPage = $this->get_items_per_page('movies_per_page', 2);

        $currentPage = $this->get_pagenum();
        $totalItems = count($this->movieData);

        if ($this->movieData) {
            usort($this->movieData, [&$this, 'usort_reorder']);
            $this->movieData = array_slice($this->movieData, (($currentPage - 1) * $perPage), $perPage);
        }

        $this->set_pagination_args([
            'total_items' => $totalItems,
            'per_page' => $perPage,
            'total_pages' => ceil($totalItems / $perPage)
        ]);


        $this->items = $this->movieData;
    }

    function column_movie_name($item) {
        $actions = array(
            'view' => sprintf('<a href="?page=%s&%s=%s">%s</a>', 'movieview', 'movie_id', $item['movie_id'], __('View', 'movie-plugin')),
            'edit' => sprintf('<a href="?page=%s&%s=%s">%s</a>', 'movie', 'movie_id', $item['movie_id'], __('Edit', 'movie-plugin')),
            'print' => sprintf('<a href="?page=%s&%s=%s">%s</a>', 'movie', 'movie_id', $item['movie_id'], __('Print', 'movie-plugin')),
            'print' => sprintf('
        <a>
        <form method="post">
                <input type="hidden" name="controller_name" value="Movie"">
                <input type="hidden" name="action" value="print">
                <input type="hidden" name="printer" value="word">
                <input type="hidden" name="movie_id" value="%s">
                
                    <button style="background: none; border: none;
                            padding: 0!important;
                            /*optional*/
                             font-family: arial, sans-serif;
                             /*input has OS specific font-family*/
                             color: #069;
                             text-decoration: underline;
                            cursor: pointer;" 
                    type="submit">%s
                 </button>            
            </form>
        </a>
        ',$item['movie_id'], __('Print', 'movie-plugin')),
        );

        return sprintf('%1$s %2$s', $item['movie_name'], $this->row_actions($actions));
    }


}