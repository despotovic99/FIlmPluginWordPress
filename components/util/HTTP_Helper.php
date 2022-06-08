<?php

class HTTP_Helper {


    public static function get_param($param_key) {

        if (isset($_REQUEST[$param_key])) {
            return sanitize_text_field(wp_unslash($_REQUEST[$param_key]));
        }

        return null;
    }

}