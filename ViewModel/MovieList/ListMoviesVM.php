<?php

use services\MovieService;

require_once plugin_dir_path(__FILE__) . '../../services/MovieService.php';
require_once plugin_dir_path(__FILE__) . '/WP_Movie_List_Table.php';

class ListMoviesVM {


    public function __construct() {

        $this->movieDBService = new MovieService();
    }

    public function getListTable() {

        $movieData = null;
        if (isset($_REQUEST['page']) && isset($_REQUEST['s'])) {
            $name = esc_html($_REQUEST['s']);

            $movieData = BaseRepository::getBaseRepository()->getFilmRepository()->getFilmByName($name);
        } else {

            $movieData = BaseRepository::getBaseRepository()->getFilmRepository()->getFilmDatafForListTable();
        }


        return new WP_Movie_List_Table(null, $movieData);

    }


}