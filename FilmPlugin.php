<?php

require_once 'repositories/BaseRepository.php';
require_once 'ViewModel/MovieList/WP_Movie_List_Table.php';
require_once 'ViewModel/Invoice/AllInvoicesVM.php';
require_once 'controllers/BaseController.php';
require_once 'controllers/MovieController.php';
require_once 'controllers/SettingsController.php';
require_once 'controllers/FrontendController.php';
require_once 'services/PluginService.php';
require_once 'components/setup/Update.php';
require_once 'components/util/MovieHelper.php';

class FilmPlugin {

    private $plugin_file_path;

    public function __construct($plugin_file_path) {
        $this->plugin_file_path = $plugin_file_path;
    }

    public function initialize() {

        $this->load_init_hooks();

        $this->load_menu_pages();

        $this->load_buttons_to_woocommerce_order_page();


    }


    public function create_movie_menu() {

        add_menu_page(
            'Movie plugin',
            'Movie plugin',
            null,
            'movie_plugin',
            [new FrontendController(), 'render'],
            plugin_dir_url(__FILE__) . '/resources/images/cinema.png',
            55.5
        );


    }

    public function create_all_movies_page() {

        $hook = add_submenu_page(
            'movie_plugin',
            'Movie',
            __('All movies', 'movie-plugin'),
            'manage_categories',
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

        if (current_user_can('manage_woocommerce')) {
            add_submenu_page(
                'movie_plugin',
                'Movie options',
                'Settings',
                'manage_woocommerce',
                'moviesettings',
                [new FrontendController(), 'render']
            );
        } else {
            add_submenu_page(
                'movie_plugin',
                'Movie options',
                'Settings',
                'manage_categories',
                'movie_settings_test',
                [new FrontendController(), 'render']
            );
        }
    }

    public function movie_page() {

        add_submenu_page(
            'movie_plugin',
            'Movie',
            __('New movie', 'movie-plugin'),
            'manage_woocommerce',
            'movie',
            [new FrontendController(), 'render']
        );

    }

    public function movie_view_page() {
        add_submenu_page(
            null,
            'Movie',
            'View movie',
            'manage_woocommerce',
            'movieview',
            [new FrontendController(), 'render']
        );
    }

    public function movie_plugin_controller_action_trigger() {

        if (empty($_REQUEST['controller_name'])) {

            return;
        }

        $controller_name = esc_html($_REQUEST['controller_name']) . 'Controller';

        if (!class_exists($controller_name))
            return;

        $controller = new $controller_name;

        $action = esc_html($_REQUEST['action']) ?: '';

        $controller->handle_action($action);


    }

    public function load_plugin_text_domain() {

        load_plugin_textdomain(
            'movie-plugin',
            false,
            plugin_basename(dirname(__FILE__)) . '/i18n/languages'
        );
    }

    public function register_new_wc_order_statuses() {

        // moras da imas prefiks wc-  jer woocommerce kad cita statuse izvlaci upravo statuse sa wc prefiksom
        $order_statuses = [
            'wc-new_status_1' => [
                'label' => _x('New status 1', 'movie-plugin'),
                'public' => true,
                'exclude_from_search' => false,
                'show_in_admin_all_list' => true,
                'show_in_admin_status_list' => true,
                'label_count' => _n_noop('New status 1 <span class="count">(%s)</span>',
                    'New status 1 <span class="count">(%s)</span>')
            ],
            'wc-new_status_2' => [
                'label' => _x('New status 2', 'movie-plugin'),
                'public' => true,
                'exclude_from_search' => false,
                'show_in_admin_all_list' => true,
                'show_in_admin_status_list' => true,
                'label_count' => _n_noop('New status 2 <span class="count">(%s)</span>',
                    'New status 2<span class="count">(%s)</span>')
            ],
        ];

        foreach ($order_statuses as $order_status => $values) {
            register_post_status($order_status, $values);
        }

    }

    public function add_new_registered_wc_order_statuses($order_statuses) {

        $order_statuses['wc-new_status_1'] = __('New status 1', ',movie-plugin');
        $order_statuses['wc-new_status_2'] = __('New status 2', ',movie-plugin');

        return $order_statuses;

    }


    public function add_print_button_to_order_in_list_table($order) {

        $order_id = method_exists($order, 'get_id') ? $order->get_id() : $order->id;

        $url = MovieHelper::get_controller(
            'Movie',
            'print_order',
            [
                'printer' => 'word-order',
                'order_id' => $order_id
            ]);

        wp_enqueue_script(
            'movie-plugin-print-order-btn',
            plugins_url('/resources/js/movie-plugin-print-order.js', __FILE__),
            ['jquery'],
            '1.0.0',
            true
        );

        echo "<button class='print-button button' url-print=' " . $url . " ' >" . __('Print', 'movie-plugin') . "</button>";

    }

    public function add_get_order_information_button($order) {

        $order_id = method_exists($order, 'get_id') ? $order->get_id() : $order->id;

        $url = MovieHelper::get_controller('Movie', 'get_order_information', [
            'order_id' => $order_id
        ]);

        wp_enqueue_script(
            'movie-plugin-print-order-btn',
            plugins_url('/resources/js/movie-plugin-print-order.js', __FILE__),
            ['jquery'],
            '1.0.0',
            true
        );

        echo "<button class='get-order-infromation-button button' url=' " . $url . " ' >" . __('Get info', 'movie-plugin') . "</button>";

    }

    public function invoices_page() {

        $hook = add_submenu_page(
            'woocommerce',
            __('Invoices', 'movie-plugin'),
            __('Invoices', 'movie-plugin'),
            'manage_woocommerce',
            'invoices',
            [new FrontendController(), 'render']
        );

        add_action("load-$hook", function () {
            add_screen_option('per_page', [
                'label' => 'Invoices',
                'default' => 2,
                'option' => 'invoices_per_page'
            ]);
            $all_invoices_vm = new AllInvoicesVM();
        });
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

    private function load_init_hooks() {
        register_activation_hook($this->plugin_file_path, [$this, 'activate']);

        add_action('init', [$this, 'register_new_wc_order_statuses']);
        add_action('init', [$this, 'load_plugin_text_domain']);

        add_action('admin_init', [$this, 'movie_register_settings'], 9);

        add_action('admin_init', [$this, 'movie_plugin_controller_action_trigger']);
        add_action('template_redirect', [$this, 'movie_plugin_controller_action_trigger']);

        add_filter('wc_order_statuses', [$this, 'add_new_registered_wc_order_statuses']);
    }

    private function load_menu_pages() {

        add_action('admin_menu', [$this, 'create_movie_menu']);
        add_action('admin_menu', [$this, 'create_all_movies_page']);

        add_action('admin_menu', [$this, 'movie_page']);
        add_action('admin_menu', [$this, 'movie_view_page']);

        add_action('admin_menu', [$this, 'movie_settings_page']);

        add_filter('set-screen-option', function ($status, $option, $value) {
            return $value;
        }, 10, 3);

        add_action('admin_menu', [$this, 'invoices_page']);

    }

    private function load_buttons_to_woocommerce_order_page() {

        add_action('woocommerce_admin_order_actions_start', [$this, 'add_get_order_information_button']);
        add_action('woocommerce_admin_order_actions_start', [$this, 'add_print_button_to_order_in_list_table']);
    }

}