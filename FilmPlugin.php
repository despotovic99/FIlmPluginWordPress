<?php
require_once 'repositories/BaseRepository.php';
require_once 'ViewModel/MovieList/WP_Movie_List_Table.php';
require_once 'controllers/BaseController.php';
require_once 'controllers/MovieController.php';
require_once 'controllers/SettingsPageController.php';
require_once 'controllers/FrontendController.php';

class FilmPlugin {


    public function initialize() {
        // todo ovo macinji
        //  init service da napravi tabele bez hook-a
        //
        add_action('admin_init', [BaseRepository::getBaseRepository(), 'initializeFilmPluginTables'], 8);

        add_action('admin_init', [$this, 'movieRegisterSettings'], 9);
        add_action('admin_init', [$this, 'moviepluginControllerActionTrigger']);

        add_action('admin_menu', [$this, 'createMoviePluginMenu']);
        add_action('admin_menu', [$this, 'moviePage']);
        add_action('admin_menu', [$this, 'movieViewPage']);
        add_action('admin_menu', [$this, 'movieSettingsPage']);

        add_filter('set-screen-option', function ($status, $option, $value) {
            return $value;
        }, 10, 3);
    }



    public function createMoviePluginMenu() {

        $hook = add_menu_page(
            'Movie plugin',
            'Movie plugin',
            'manage_options',
            'movies',
            [new FrontendController(), 'render'],
            plugin_dir_url(__FILE__) . '/resources/images/cinema.png',
            55.5
        );

        add_action("load-$hook", function () {
            add_screen_option('per_page', [
                'label' => 'Movies',
                'default' => 2,
                'option' => 'movies_per_page'
            ]);
            $filmList = new WP_Movie_List_Table(null, null);
        });

    }

    public function movieRegisterSettings() {

        register_setting('film-options', 'film_option_name_horor18');
    }

    public function movieSettingsPage() {

        add_submenu_page(
            'movies',
            'Movie options',
            'Settings',
            'manage_options',
            'moviesettings',
            [new FrontendController(), 'render']
        );
    }

    public function moviePage() {

        add_submenu_page(
            'movies',
            'Movie',
            'New movie',
            'manage_options',
            'movie',
            [new FrontendController(), 'render']
        );

    }

    public function movieViewPage() {
        add_submenu_page(
            null,
            'Movie',
            'View movie',
            'manage_options',
            'movieview',
            [new FrontendController(), 'render']
        );
    }

    public function moviepluginControllerActionTrigger() {

        if (!empty($_REQUEST['controller_name'])) {
            $controller = new BaseController();
            $controller->index($_REQUEST['controller_name']);
        }

    }

}