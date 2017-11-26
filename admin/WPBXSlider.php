<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       https://crescentsoftware.ca
 * @since      0.1.0
 *
 * @package    WPBXSlider
 * @subpackage WPBXSlider/admin
 */
class WPBXSlider {
 
    /**
     * The ID of this plugin.
     *
     * @since    0.1.0
     * @access   private
     * @var      string    $name    The ID of this plugin.
     */
    private $name;

    /**
     * The current version of the plugin.
     *
     * @since    0.1.0
     * @access   private
     * @var      string    $version    The version of the plugin
     */
    private $version;

    /**
     * Initializes the plugin by defining the properties.
     *
     * @since 0.1.0
     */
    public function __construct( ) {
        $this->name = 'WPBXSlider';
        $this->version = '0.1.0';
    }
 
    /**
     * Function to initilize the plugin functionality to render the admin view
     *
     * @since 0.1.0
     * @return void
     */
    public function run() {

        // Render the admin page view / menus
        add_action( 
             'admin_menu', 
             array( $this, 'add_settings_page' ) );

        if ( ! empty ( $GLOBALS['pagenow'] ) && ( 
            'options-general.php' === $GLOBALS['pagenow'] || 'options.php' === $GLOBALS['pagenow']
            ))
        {
            // Register the settings and render the fields
            add_action( 
                'admin_init', 
                array( $this, 'register_settings' ) );
        }

    }
 
    /**
     * Creates the submenu item and calls on the Submenu Page object to render
     * the actual contents of the page.
     *
     * @since 0.1.0
     */
    public function add_settings_page() {
        add_options_page( 
            "WP BXSlider Settings",                     // $page_title
            "WP BXSlider",                              // $menu_title
            "manage_options",                           // $capability (ie: permissions)
            $this->name,                                // $menu_slug
            array($this, 'render_admin_page')   // callback to render view
        );
    }

    /**
     * Register the required fields for our plugin.
     * THe method will use $this->name extensively for our key structures
     *
     * @since 0.1.0
     */
    public function register_settings() {

        /**
         * Convenience variable for storing field names to prevent run-time errors
         */
        $fields = array(
            "image" => $this->name . '_image'
        );
        
        /**
         * Retrieve the stored option set for this plugin from the db
         */
        $option_values = get_option( $this->name );

        /**
         * If the db doesn't return anything (ex: on first run), we will run 
         * into null references below, so we define default values for our fields.
         * Note that we're making use of our $fields array from above
         */
        $default_values = array (
            $fields["image"] => ""
        );

        // Parse option values into predefined keys defined in $data, throw the rest away.
        $data = shortcode_atts( $default_values, $option_values );

        /**
         * Register the setting category identified by $this->name
         * We use the same key everywhere since our plugin is simple enough
         * 
         * @since 0.1.0
         */
        register_setting( 
            $this->name,                           // Option group, used for settings_fields()
            $this->name,                           // Option name, key for DB for this option set
            array($this, "validate_options"));     // validation callback


        /**
         * Create a section for our settings.  For some reason 'default' did not work for me.
         */
        add_settings_section(
            $this->name,                         // Section ID
            "Main Settings",                     // Title
            array($this, "render_section"),      // callback to render section
            $this->name                          // $menu_slug
        );

        /**
         * Create the field, which included a callback to render the field view
         * The array is an optional data set which defines arguments provided to
         * the render_image_field callback
         */
        add_settings_field(
            $fields["image"],                          // Field ID
            "Image",                                   // Title
            array( $this, 'render_image_field' ),      // callback to render field
            $this->name,                               // $menu_slug
            $this->name,                               // Section ID
            array(                                     // Args for callback to render field
                'option_name' => $this->name,
                'name' => $fields["image"],
                'value' => esc_attr($data[$fields["image"]])             
            )                
        );
    }

    /**
     * validates the data supplied to this plugin
     *
     * @since 0.1.0
     * @param array values for the plugin
     * @return array the validated set of options supplied to the plugin
     */
    public function validate_option( $values ) {
        $out = array ();
        return $values;
    }

    /**
     * Renders the admin page view
     *
     * @since 0.1.0
     */
    public function render_admin_page() {
        $option_name = $this->name;        
        include_once( dirname( __FILE__ ) . '/views/admin-page.php' );
    }

    /**
     * Empty stub for rendering our plugin section
     *
     * @since 0.1.0
     */
    public function render_section() {
        
    }

    /**
     * Renders our image field view
     * @since 0.1.0
     */
    public function render_image_field($args) {
        include( dirname( __FILE__ ) . '/views/media-image.php' );
    }

    function debug_var( $var, $before = '' )
    {
        $export = esc_html( var_export( $var, TRUE ) );
        print "<pre>$before = $export</pre>";
    }
}