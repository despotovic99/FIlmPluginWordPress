<?php

class MovieSettingsVM {

    public  function getAge() {
        $age = get_option('horror_movie_min_age_option');
        if (!$age) {
            $age = ' ';
        }

        return $age;
    }


}