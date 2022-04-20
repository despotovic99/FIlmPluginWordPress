
<div class="wrap">
    <h1>Podesavanja <?= esc_html(get_admin_page_title()) ?></h1>
    <form action="options.php" method="post">
        <?php
        settings_fields('film-options');

        //Prints out all settings sections added to a particular settings page
        do_settings_sections('film-options');
        // output save settings button
        submit_button(__('Save Settings', 'textdomain'));
        ?>
    </form>
</div>
