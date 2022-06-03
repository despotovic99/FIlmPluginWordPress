<?php

class MovieHelper {

    public static function get_controller($controller_name, $action = '', $parameters = []) {

        $url = site_url();

        $query = ['controller_name' => $controller_name];
        if ($action) {
            $query['action'] = $action;
        }

        $query = array_merge($query, $parameters);


        return $url . "/?" . http_build_query($query);
    }

    public  static  function check_folder_exists_and_create($folder) {
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
    }


}