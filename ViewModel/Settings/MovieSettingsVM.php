<?php

class MovieSettingsVM {

    public  function get_age() {
        $age = get_option('horror_movie_min_age_option');
        if (!$age) {
            $age = ' ';
        }

        return $age;
    }


}