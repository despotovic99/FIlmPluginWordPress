<?php

require_once 'BaseController.php';

class SettingsController extends BaseController {

    public function save_age_option() {

        if (isset($_POST['horror_movie_min_age_option'])) {

            $age = sanitize_text_field(wp_unslash($_POST['horror_movie_min_age_option']));
            update_option('horror_movie_min_age_option', $age);
        }

    }
}