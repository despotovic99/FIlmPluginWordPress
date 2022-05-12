<?php

require_once 'repositories/BaseRepository.php';
require_once 'ViewModel/MovieList/WP_Movie_List_Table.php';
require_once 'controllers/BaseController.php';
require_once 'controllers/MovieController.php';
require_once 'controllers/SettingsPageController.php';
require_once 'controllers/FrontendController.php';
require_once 'services/PluginService.php';
require_once 'components/setup/Update.php';

class FilmPlugin {

    private $plugin_file_path;

    public function __construct($plugin_file_path) {
        $this->plugin_file_path = $plugin_file_path;
    }

    public function initialize() {

        $statusi = wc_get_order_statuses();

        register_activation_hook($this->plugin_file_path, [$this, 'activate']);

        add_action('admin_init', [$this, 'movie_register_settings'], 9);
        add_action('admin_init', [$this, 'movie_plugin_controller_action_trigger']);

        add_action('admin_menu', [$this, 'create_movie_menu']);
        add_action('admin_menu', [$this, 'create_all_movies_page']);
        add_action('admin_menu', [$this, 'movie_page']);
        add_action('admin_menu', [$this, 'movie_view_page']);
        add_action('admin_menu', [$this, 'movie_settings_page']);

        add_action('init', [$this, 'load_plugin_text_domain']);

        add_filter('set-screen-option', function ($status, $option, $value) {
            return $value;
        }, 10, 3);


    }


    public function create_movie_menu() {

        add_menu_page(
            'Movie plugin',
            'Movie plugin',
            null,
            'movie_plugin',
            null,
            plugin_dir_url(__FILE__) . '/resources/images/cinema.png',
            55.5
        );


    }

    public function create_all_movies_page() {

        $hook = add_submenu_page(
            'movie_plugin',
            'Movie',
            __('All movies', 'movieplugin'),
            'manage_options',
            'movies',
            [new FrontendController(), 'render']
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

    public function movie_register_settings() {

        register_setting('film-options', 'film_option_name_horor18');
    }

    public function movie_settings_page() {

        add_submenu_page(
            'movie_plugin',
            'Movie options',
            'Settings',
            'manage_options',
            'moviesettings',
            [new FrontendController(), 'render']
        );
    }

    public function movie_page() {

        add_submenu_page(
            'movie_plugin',
            'Movie',
            __('New movie', 'movieplugin'),
            'manage_options',
            'movie',
            [new FrontendController(), 'render']
        );

    }

    public function movie_view_page() {
        add_submenu_page(
            null,
            'Movie',
            'View movie',
            'manage_options',
            'movieview',
            [new FrontendController(), 'render']
        );
    }

    public function movie_plugin_controller_action_trigger() {

        if (!empty($_REQUEST['controller_name'])) {
            $controller = new BaseController();
            $controller->index(esc_html($_REQUEST['controller_name']));
        }

    }

    public function load_plugin_text_domain() {

        load_plugin_textdomain(
            'movieplugin',
            false,
            plugin_basename(dirname(__FILE__)) . '/i18n/languages'
        );
    }

    public function activate() {

        if (!PluginService::is_woocommerce_active()) {

            wp_die(esc_html(__('Please install and activate WooCommerce plugin', 'movieplugin')),
                'Plugin active check',
                ['back_link' => true]);
        }

        $updater = new Update();
        $updater->init_or_update_plugin();

    }

}