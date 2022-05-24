<?php

class UserPrintOptionVM {

    public function can_user_print() {

        if (!empty($_REQUEST['user_id'])) {

            $user_id = esc_html($_REQUEST['user_id']);
        } else {

            $user_id = wp_get_current_user()->ID;
        }

        $result = get_user_meta($user_id, 'user_can_print');
        if ($result)
            return $result[0];

        return false;
    }

}