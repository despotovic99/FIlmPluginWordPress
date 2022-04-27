<?php
require_once 'repositories/BaseRepository.php';
require_once 'Services/WordFilmReportPrinter.php';
require_once 'ViewModel/FilmList/WP_Film_List_Table.php';
require_once 'controllers/SettingsPageController.php';

class FilmPlugin {

//    private static $filmPlugin = null;
    private $baseRepository = null;

    public function __construct() {
        $this->baseRepository = new BaseRepository();
    }


    public function initialize() {

        add_action('admin_init', [$this->baseRepository, 'initializeFilmPluginTables']);

        add_action('admin_menu', [$this, 'create_filmplugin_menu']);


//        add_action('admin_init', function () {
//            add_filter('views_edit-film_type', function ($views) {
//
//                global $wp_list_table;
//                $filmListTable = new WP_Film_List_Table(null, $this->baseRepository->getFilmRepository());
//                $wp_list_table = $filmListTable;
//                echo '<div class="wrap"><h3>Lista filmova</h3>';
//
////                $wp_list_table->search_box('Film', 'film_search_id');
//                $wp_list_table->prepare_items();
//
//                echo '</div>';
//
//            });
//        });

        add_action('admin_init', [$this, 'film_register_settings']);
        add_action('admin_menu', [$this, 'film_option_page']);

    }

    public function create_filmplugin_menu() {

        add_menu_page(
            'FilmPlugin',
            'FilmPlugin',
            'manage_options',
            'filmplugin',
            null,
            plugin_dir_url(__FILE__) . '/resources/images/cinema.png',
            55.5
        );

    }

    public function film_register_settings() {
        register_setting('film-options', 'film_option_name_horor18');

//        add_settings_section(
//            'film_settings_section',
//            'Film plugin podesavanja',
//            [$this, 'film_settings_section_uzrast_za_filmove'],
//            'film-options'
//        );
//
//        add_settings_field(
//            'film_settings_horror_uzrast',
//            'Uzrast za horor film',
//            [$this, 'film_settings_field_uzrast_horror'],
//            'film-options',
//            'film_settings_section'
//        );
    }

    public function film_option_page() {
        add_submenu_page(
            'filmplugin',
            'Film options',
            'Settings',
            'manage_options',
            'filmpluginsettings',
            [new SettingsPageController(), 'render']
        );
    }


}