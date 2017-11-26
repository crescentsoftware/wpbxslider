<?php

/**
 * Renders the Admin View for the WPBXSlider
 * 
 * @var $option_name is defined by the parent, hopefully by render_admin_page()
 * 
 * @since 0.1.0
 * 
 */
?>

<div class="wrap">
    <h1>WP BXSlider Admin Page</h1>

    <?php settings_errors( $option_name ); ?>

    <form method="post" action="options.php"> 
        <?php 
            settings_fields( $option_name ); 
            do_settings_sections( $option_name ); 
        ?>
        <?php submit_button(); ?>
    </form>
</div>

