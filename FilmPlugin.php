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

        register_activation_hook($this->plugin_file_path, [$this, 'activate']);

        add_action('init',[$this,'register_new_wc_order_statuses']);
        add_action('init', [$this, 'load_plugin_text_domain']);

        add_action('admin_init', [$this, 'movie_register_settings'], 9);
        add_action('admin_init', [$this, 'movie_plugin_controller_action_trigger']);

        add_action('admin_menu', [$this, 'create_movie_menu']);
        add_action('admin_menu', [$this, 'create_all_movies_page']);
        add_action('admin_menu', [$this, 'movie_page']);
        add_action('admin_menu', [$this, 'movie_view_page']);
        add_action('admin_menu', [$this, 'movie_settings_page']);


        add_filter('wc_order_statuses',[$this,'add_new_registered_wc_order_statuses']);

        add_action('woocommerce_admin_order_actions_start',[$this,'add_print_button_to_order_in_list_table']);

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
            __('All movies', 'movie-plugin'),
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
            __('New movie', 'movie-plugin'),
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
            'movie-plugin',
            false,
            plugin_basename(dirname(__FILE__)) . '/i18n/languages'
        );
    }

    public function register_new_wc_order_statuses(){

        // moras da imas prefiks wc-  jer woocommerce kad cita statuse izvlaci upravo statuse sa wc prefiksom
        $order_statuses = [
            'wc-new_status_1'=>[
                'label'=>_x('New status 1','movie-plugin'),
                'public'=>true,
                'exclude_from_search'=>false,
                'show_in_admin_all_list'=>true,
                'show_in_admin_status_list'=>true,
                'label_count'               => _n_noop( 'New status 1 <span class="count">(%s)</span>',
                    'New status 1 <span class="count">(%s)</span>' )
            ],
            'wc-new_status_2'=>[
                'label'=>_x('New status 2','movie-plugin'),
                'public'=>true,
                'exclude_from_search'=>false,
                'show_in_admin_all_list'=>true,
                'show_in_admin_status_list'=>true,
                'label_count'               => _n_noop( 'New status 2 <span class="count">(%s)</span>',
                    'New status 2<span class="count">(%s)</span>' )
            ],
        ];

        foreach ($order_statuses as $order_status=>$values){
            register_post_status($order_status,$values);
        }

    }

    public function add_new_registered_wc_order_statuses($order_statuses){

        $order_statuses['wc-new_status_1']=__('New status 1',',movie-plugin');
        $order_statuses['wc-new_status_2']=__('New status 2',',movie-plugin');

        return $order_statuses;

    }

    public function add_print_button_to_order_in_list_table($order){

        $order_id = method_exists($order, 'get_id') ? $order->get_id() : $order->id;


        echo "
        <form method='post'>
                    <input type='hidden' name='controller_name' value='movie_controller'>
                    <input type='hidden' name='action' value='print-order'>
                    <input type='hidden' name='order_id' value='".$order_id."'>
                     <button class='btn-delete' type='submit'>".__('Print','movie-plugin')."</button>
       </form>
        ";
}

    public function activate() {

        if (!PluginService::is_woocommerce_active()) {

            wp_die(esc_html(__('Please install and activate WooCommerce plugin', 'movie-plugin')),
                'Plugin active check',
                ['back_link' => true]);
        }

        $updater = new Update();
        $updater->init_or_update_plugin();

    }

}