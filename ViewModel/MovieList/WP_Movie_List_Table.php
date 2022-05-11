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
            'movie_name' => 'Naziv filma',
            'movie_category_name' => 'Zanr',
            'movie_date' => 'Pocetak prikazivanja',
            'movie_length' => 'Duzina trajanja',
            'movie_age' => 'Predvidjeni uzrast',
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

        if($this->movieData){
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
            'view' => sprintf('<a href="?page=%s&%s=%s">Prikazi</a>', 'movieview', 'movie_id', $item['movie_id']),
            'edit' => sprintf('<a href="?page=%s&%s=%s">Izmeni</a>', 'movie', 'movie_id', $item['movie_id']),
            'print' => sprintf('<a href="?page=%s&%s=%s">Stampaj</a>', 'movie', 'movie_id', $item['movie_id']),
        );

        return sprintf('%1$s %2$s', $item['movie_name'], $this->row_actions($actions));
    }



}