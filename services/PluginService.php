<?php

class PluginService {

    private static function is_plugin_active($plugin_name){

        $active_plugins = get_option('active_plugins');

        foreach ($active_plugins as $active_plugin){
            if(strpos($active_plugin,'/'.$plugin_name)){

                return true;
            }
        }
        return false;
    }

    public static function is_woocommerce_active(){

        return self::is_plugin_active('woocommerce.php');

    }

}