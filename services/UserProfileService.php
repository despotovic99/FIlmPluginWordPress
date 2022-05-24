<?php

class UserProfileService {

    public function set_user_print_option($user_id, $value) {

        if (!current_user_can('edit_user', $user_id)) {

            return false;
        }

        update_user_meta($user_id, 'user_can_print', $value);
    }

}