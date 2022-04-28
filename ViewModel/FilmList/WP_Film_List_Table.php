<?php
require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');


class WP_Film_List_Table extends WP_List_Table {

    private $filmData;

    public function __construct($args = array(), $filmData) {
        parent::__construct($args);
        $this->filmData = $filmData;
    }


    public function get_columns() {

        return [
            'cb' => '<input type="checkbox"/>',
            'naziv_filma' => 'Naziv filma',
            'zanr' => 'Zanr',
            'pocetak_prikazivanja' => 'Pocetak prikazivanja',
            'duzina_trajanja' => 'Duzina trajanja',
            'uzrast' => 'Predvidjeni uzrast',
            'action' => 'Akcije'
        ];

    }

    protected function column_default($item, $column_name) {

        switch ($column_name) {
            case 'naziv_filma':
            case 'uzrast':
            case 'zanr':
            case 'pocetak_prikazivanja':
            case 'duzina_trajanja':
                return $item[$column_name];
            default :
//                return print_r($item, true);
        }
    }

    protected function column_cb($item) {

        return sprintf('<input type="checkbox" value="%s"/>', $item['film_id']);
    }

    protected function get_sortable_columns() {

        $sortableColumns = [
            'naziv_filma' => ['naziv_filma', true],
            'zanr' => ['zanr', false],
//            'uzrast' => ['uzrast', false],
        ];

        return $sortableColumns;

    }

    private function usort_reorder($a, $b) {

        $orderby = (!empty($_GET['orderby'])) ? $_GET['orderby'] : 'naziv_filma'; // po kojoj koloni
        $order = (!empty($_GET['order'])) ? $_GET['order'] : 'asc'; //rastuci ili opadajuci redosled
        $result = strcmp($a[$orderby], $b[$orderby]);

        return ($order == 'asc') ? $result : -$result;
    }

    public function prepare_items() {

        $columns = $this->get_columns();
        $hidden = [];
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = [$columns, $hidden, $sortable];

        usort($this->filmData, [&$this, 'usort_reorder']);

        $perPage = 5;

        $currentPage = $this->get_pagenum();
        $totalItems = count($this->filmData);

        $this->filmData = array_slice($this->filmData, (($currentPage - 1) * $perPage), $perPage);

        $this->set_pagination_args([
            'total_items' => $totalItems,
            'per_page' => $perPage,
            'total_pages' => ceil($totalItems / $perPage)
        ]);


        $this->items = $this->filmData;
    }


}