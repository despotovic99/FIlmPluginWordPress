<?php

use services\MovieService;

require_once plugin_dir_path(__FILE__) . '../../services/MovieService.php';
require_once plugin_dir_path(__FILE__) . '/WP_Movie_List_Table.php';

class ListMoviesVM {


    public function __construct() {

        $this->movie_db_service = new MovieService();
    }

    public function get_list_table() {

        $movie_data = null;
        if (isset($_REQUEST['page']) && isset($_REQUEST['s'])) {
            $name = esc_html($_REQUEST['s']);

            $movie_data = BaseRepository::getBaseRepository()->getFilmRepository()->getFilmByName($name);
        } else {

            $movie_data = BaseRepository::getBaseRepository()->getFilmRepository()->getFilmDatafForListTable();
        }


        return new WP_Movie_List_Table(null, $movie_data);

    }


}