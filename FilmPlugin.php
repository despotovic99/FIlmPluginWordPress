<?php
require_once 'repositories/BaseRepository.php';
require_once 'ViewModel/FilmList/WP_Film_List_Table.php';
require_once 'controllers/BaseController.php';
require_once 'controllers/FilmController.php';
require_once 'controllers/SettingsPageController.php';
require_once 'controllers/FrontendController.php';

class FilmPlugin {


    public function initialize() {
        // todo ovo macinji
        add_action('admin_init', [BaseRepository::getBaseRepository(), 'initializeFilmPluginTables'], 8);
        add_action('admin_init', [$this, 'film_register_settings'], 9);
        add_action('admin_init', [$this, 'filmplugin_controller_action_trigger']);

        add_action('admin_menu', [$this, 'create_filmplugin_menu']);
        add_action('admin_menu', [$this, 'film_page']);
        add_action('admin_menu', [$this, 'film_view_page']);
        add_action('admin_menu', [$this, 'film_option_page']);

        add_filter('set-screen-option', function ($status, $option, $value) {
            return $value;
        }, 10, 3);
    }

    public function create_filmplugin_menu() {

        $hook = add_menu_page(
            'FilmPlugin',
            'FilmPlugin',
            'manage_options',
            'filmplugin',
            [new FrontendController(), 'render'],
            plugin_dir_url(__FILE__) . '/resources/images/cinema.png',
            55.5
        );

        add_action("load-$hook", function () {
            add_screen_option('per_page', [
                'label' => 'Filmovi',
                'default' => 2,
                'option' => 'filmovi_per_page'
            ]);
            $filmList = new WP_Film_List_Table(null, null);
        });

    }

    public function film_register_settings() {

        register_setting('film-options', 'film_option_name_horor18');
    }

    public function film_option_page() {

        add_submenu_page(
            'filmplugin',
            'Film options',
            'Settings',
            'manage_options',
            'filmpluginsettings',
            [new FrontendController(), 'render']
        );
    }

    public function film_page() {

        add_submenu_page(
            'filmplugin',
            'Film',
            'Novi film',
            'manage_options',
            'filmpage',
            [new FrontendController(), 'render']
        );

    }

    public function film_view_page(){
        add_submenu_page(
            null,
            'Film',
            'Novi film',
            'manage_options',
            'filmviewpage',
            [new FrontendController(), 'render']
        );
    }

    public function filmplugin_controller_action_trigger() {

        if (!empty($_REQUEST['controller_name'])) {
            $controller = new BaseController();
            $controller->index($_REQUEST['controller_name']);
        }

    }

}