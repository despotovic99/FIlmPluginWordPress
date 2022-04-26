<?php
require_once 'repositories/FilmPluginZanrRepo.php';
require_once 'repositories/FilmPluginFilmRepo.php';
require_once 'Services/WordFilmReportPrinter.php';
require_once 'ViewModel/FilmList/WP_Film_List_Table.php';

class FilmPlugin {

//    private static $filmPlugin = null;
    private $baseRepository = null;

    public function __construct() {
        $this->baseRepository = new BaseRepository();
    }


    public function initialize() {

        add_action('admin_init', [$this->baseRepository, 'initializeFilmPluginTables']);

        add_action('admin_menu', [$this, 'create_filmplugin_menu']);

        add_action('init', [$this, 'create_film_post_type']);
        add_action('save_post', [$this, 'save_film_post_type']);

        add_action('admin_init', function () {
            add_filter('views_edit-film_type', function ($views) {

                global $wp_list_table;
                $filmListTable = new WP_Film_List_Table(null, new FilmPluginFilmRepo());
                $wp_list_table = $filmListTable;
                echo '<div class="wrap"><h3>Lista filmova</h3>';

//                $wp_list_table->search_box('Film', 'film_search_id');
                $wp_list_table->prepare_items();

                echo '</div>';

            });
        });

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

        add_settings_section(
            'film_settings_section',
            'Film plugin podesavanja',
            [$this, 'film_settings_section_uzrast_za_filmove'],
            'film-options'
        );

        add_settings_field(
            'film_settings_horror_uzrast',
            'Uzrast za horor film',
            [$this, 'film_settings_field_uzrast_horror'],
            'film-options',
            'film_settings_section'
        );
    }

    public function film_settings_section_uzrast_za_filmove() {
        echo '<p>Predvidjeni uzrasti za filmove</p>';
    }

    public function film_settings_field_uzrast_horror() {
        $predvidjeniUzrast = get_option('film_option_name_horor18');
        if (!$predvidjeniUzrast) {
            $predvidjeniUzrast = ' ';
        }
        echo "<input type='text'  name='film_option_name_horor18' value='$predvidjeniUzrast'>";
    }

    public function film_option_page() {
        add_submenu_page(
            'filmplugin',
            'Film options',
            'Options',
            'manage_options',
            plugin_dir_path(__FILE__) . 'resources/views/film-settings-page.php',
            null
        );
    }


    public function create_film_post_type() {

        $labels = [
            'name' => __('Svi filmovi', 'filmplugin'),
            'singular_name' => __('Film', 'filmplugin'),
            'add_new' => __('Novi film', 'filmplugin'),
            'add_new_item' => __('Dodaj novi film', 'filmplugin'),
            'edit_item' => __('Izmeni film', 'filmplugin'),
            'new_item' => __('Novi film', 'filmplugin'),
            'view_item' => __('Pogledaj film', 'filmplugin'),
//            'search_items' => __('Pretrazi film', 'filmplugin'),
//            'not_found' => __('Filmovi nisu pronadjeni!', 'filmplugin'),
//            'not_found_in_trash' => __('Filmovi nisu pronadjeni u smecu!', 'filmplugin'),

        ];

        $args = [
            'labels' => $labels,
            'has_archive' => true,
            'public' => false,
            'show_ui' => true,
            'publicly_queryable' => false,
            'query_var' => false,
            'hierarchical' => false,
            'supports' => [
                'title',
                'editor',
            ],
            'register_meta_box_cb' => [$this, 'register_metadata_to_film_type'],
            'show_in_menu' => 'filmplugin',

        ];

        register_post_type('film_type', $args);
    }

    public function register_metadata_to_film_type() {
        $this->create_zanr_metadata();
        $this->add_fim_uzrast_metadata();

    }

    public function create_zanr_metadata() {

        add_meta_box(
            'film_zanr_id',
            'Zanr',
            [$this, 'film_zanrovi_field'],
            'film_type',
            'side'
        );

    }

    public function film_zanrovi_field($film_post) {

        $zanrovi = $this->baseRepository->getZanroviFromTable();

        $zanrMeta = get_post_meta($film_post->ID, '_film_type_zanr');
        $zanrMeta = $zanrMeta ? $zanrMeta[0] : null;

        include_once plugin_dir_path(__FILE__) . 'resources/views/partials/film-zanrovi-field.php';
    }


    public function add_fim_uzrast_metadata() {

        add_meta_box(
            'film_type_uzrast_id',
            'Uzrast ',
            [$this, 'film_type_uzrast_input_field'],
            'film_type',
            'side');
    }

    public function film_type_uzrast_input_field($film_post) {
        $vrednost = get_post_meta($film_post->ID, '_film_type_uzrast_meta_key', true);
        include_once plugin_dir_path(__FILE__) . 'resources/views/partials/film-uzrast-field.php';
    }

    public function save_film_post_type($film_post_id) {

        $this->saveFilmUzrast($film_post_id);
        $this->saveFilmZanr($film_post_id);

    }

    private function saveFilmZanr($film_post_id) {
        if (array_key_exists('film_zanr', $_POST)) {
            $zanrSlug = esc_html($_POST['film_zanr']);

            if (!$this->baseRepository->daLiPostojiZanr($zanrSlug)) {
                return;
            }

            update_post_meta(
                $film_post_id,
                '_film_type_zanr',
                $zanrSlug
            );


        }
    }

    private function saveFilmUzrast($film_post_id) {
        if (array_key_exists('uzrast_film_name', $_POST)) {

            $uzrast = esc_html($_POST['uzrast_film_name']);

            if (array_key_exists('film_zanr', $_POST) &&
                esc_html($_POST['film_zanr']) === 'horor') {

                $predvidjeniUzrast = get_option('film_option_name_horor18');

                $uzrast = $uzrast < $predvidjeniUzrast ? $predvidjeniUzrast : $uzrast;
            }

            update_post_meta(
                $film_post_id,
                '_film_type_uzrast_meta_key',
                $uzrast
            );
        }
    }


}