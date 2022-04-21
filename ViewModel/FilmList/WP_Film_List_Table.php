<?php
require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');

class WP_Film_List_Table extends WP_List_Table {

    public function get_columns() {

        return [
            'cb'=>'<input type="checkbox"/>',
            'naziv_filma'=>'Naziv filma',
            'uzrast'=>'Predvidjeni uzrast',
            'zanr'=>'Zanr'
        ];

    }

    public function prepare_items() {

        $columns = $this->get_columns();
        $hidden = [];
        $sortable=[];
        $this->_column_headers=[$columns,$hidden,$sortable];

        $this->items=[];
    }


}