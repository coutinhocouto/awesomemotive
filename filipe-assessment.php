<?php
/**
 * Plugin Name:       Filipe Plugin
 * Description:       Filipe Coutinho Plugin for Awesome Motive
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Filipe Coutinho
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       filipe-assessment
 *
 * @package           create-block
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_filipe_block_init() {
	register_block_type( __DIR__ . '/build' );
}
add_action( 'init', 'create_block_filipe_block_init' );

function filipe_plugin_textdomain() {
    load_plugin_textdomain('filipe-block', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}

add_action('plugins_loaded', 'filipe_plugin_textdomain');

require_once plugin_dir_path(__FILE__) . 'components/admin-page.php';
require_once plugin_dir_path(__FILE__) . 'components/ajax.php';
require_once plugin_dir_path(__FILE__) . 'components/wp-cli.php';