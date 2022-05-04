<?php

class FilmUzrastOptionVM {

    const CONTROLER_NAME='settings-page';
    const UZRAST_OPTION_NAME='film_option_name_horor18';

    public  function getPredvidjeniUzrast() {
        $predvidjeniUzrast = get_option(self::UZRAST_OPTION_NAME);
        if (!$predvidjeniUzrast) {
            $predvidjeniUzrast = ' ';
        }

        return $predvidjeniUzrast;
    }


}