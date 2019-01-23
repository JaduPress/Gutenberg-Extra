<?php
/**
 * Plugin Name: Gutenberg Extra
 * Plugin URI: https://bitbucket.org/example/gutenberg-extra/
 * Description: Powerful and feature rich blocks for the WordPress Gutenberg editor.
 * Author: example
 * Author URI: https://bitbucket.org/example/
 * Version: 0.1.0
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 */

/**
 * Gutenberg Extra is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Gutenberg Extra is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Gutenberg Extra. If not, see <http://www.gnu.org/licenses/>.
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Gutenberg Extra class
 *
 * @class Gutenberg Extra The class that holds the entire Gutenberg Extra plugin
 */
class GutenbergExtra {

    /**
     * Plugin version
     *
     * @var string
     */
    public $version = '0.1.0';

    /**
     * The single instance of the class.
     */
    protected static $_instance = null;

    /**
     * Constructor for the Gutenberg Extra class
     *
     * Sets up all the appropriate hooks and actions
     * within our plugin.
     *
     * @uses is_admin()
     * @uses add_action()
     */
    public function __construct() {
        $this->define_constants();

        register_activation_hook( __FILE__, array( $this, 'activate' ) );

        if ( ! $this->is_gutenberg_active() ) {
        	$this->dependency_error();
        	return;
        }

        add_action( 'plugins_loaded', array( $this, 'init_plugin' ) );
    }

    /**
     * Initializes the Gutenberg Extra() class
     *
     * Checks for an existing Gutenberg Extra() instance
     * and if it doesn't find one, creates it.
     */
    public static function instance() {

        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Define the constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'GUTENBERG_VERSION', $this->version );
        define( 'GUTENBERG_ROOT_FILE', __FILE__ );
        define( 'GUTENBERG_ROOT_PATH', plugin_dir_path( __FILE__ ) );
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin() {
        $this->includes();
    }

    /**
     * Check if Gutenberg is active
     *
     * @since 0.1.0
     *
     * @return boolean
     */
    public function is_gutenberg_active() {
    	return function_exists( 'register_block_type' );
    }

    /**
     * Placeholder for activation function
     */
    public function activate() {
    	$installed = get_option( 'gutenberg_extra_installed' );

    	if ( ! $installed ) {
    	    update_option( 'gutenberg_extra_installed', time() );
    	}

    	update_option( 'gutenberg_extra_version', GUTENBERG_VERSION );
    }

    /**
     * Include the required files
     *
     * @return void
     */
    public function includes() {

    	require_once __DIR__ . '/includes/Blocks.php';

    	new GutenbergExtra\Blocks();
    }

    /**
     * Admin notice for no EDD or WC
     */
    public function dependency_error() {

        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        echo '<div class="notice notice-error">';
        echo '<p>Gutenberg Extra requires Gutenberg plugin installed or WordPress 5.0.</p>';
        echo '</div>';
    }

} // GutenbergExtra

GutenbergExtra::instance();
