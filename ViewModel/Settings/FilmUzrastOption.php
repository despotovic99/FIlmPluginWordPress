<?php

class FilmUzrastOption {

    const UZRAST_OPTION_NAME='film_option_name_horor18';

    public static function getPredvidjeniUzrast() {
        $predvidjeniUzrast = get_option(self::UZRAST_OPTION_NAME);
        if (!$predvidjeniUzrast) {
            $predvidjeniUzrast = ' ';
        }

        return $predvidjeniUzrast;
    }


}