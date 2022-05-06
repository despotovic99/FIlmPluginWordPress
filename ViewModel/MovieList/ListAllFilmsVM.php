<?php

use services\MovieService;

require_once plugin_dir_path(__FILE__) . '../../services/MovieService.php';
require_once plugin_dir_path(__FILE__) . '/WP_Movie_List_Table.php';

class ListAllFilmsVM {


    const SEARCHBOX_ID = 'pretrazi_film_searchbox_id';

    public function __construct() {

        $this->filmDBService = new MovieService();
    }

    public function getListTable() {

        $filmData = null;
        if (isset($_REQUEST['page']) && isset($_REQUEST['s'])) {
            $name = esc_html($_REQUEST['s']);

            $filmData = BaseRepository::getBaseRepository()->getFilmRepository()->getFilmByName($name);
        } else {

            $filmData = BaseRepository::getBaseRepository()->getFilmRepository()->getFilmDatafForListTable();
        }


        return new WP_Movie_List_Table(null, $filmData);

    }


}