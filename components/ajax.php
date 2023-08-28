<?php

/* 
 * -----------------------------------
 * CREATION OF THE CUSTOM API ENDPOINT 
 * -----------------------------------
*/

function filipe_load_textdomain() {
    load_plugin_textdomain('filipe-ajax', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'filipe_load_textdomain');

function filipe_ajax_endpoint() {
    $last_request_time = get_option('filipe_last_request_time', 0);
    $current_time = time();
    $force_refresh = isset($_GET['force_refresh']) ? sanitize_text_field($_GET['force_refresh']) : '';

    if ($force_refresh === 'true') {
        update_option('filipe_last_request_time', 0); // Reset the last request time
        echo esc_html__('Forced refresh initiated.', 'filipe-ajax');
        wp_die();
    }

    if ($current_time - $last_request_time < 3600) {
        $cached_data = get_option('filipe_cached_data', '');
        if (!empty($cached_data)) {
            echo wp_kses_post($cached_data);
            wp_die();
        }
    }

    // Validate the action parameter
    $action = isset($_GET['action']) ? sanitize_text_field($_GET['action']) : '';

    if ($action === 'filipe_fetch_data') {
        $api_response = wp_safe_remote_get('https://miusage.com/v1/challenge/1/');

        if (!is_wp_error($api_response)) {
            $response_body = wp_remote_retrieve_body($api_response);

            update_option('filipe_cached_data', sanitize_textarea_field($response_body));
            update_option('filipe_last_request_time', $current_time);

            echo wp_kses_post($response_body);
        } else {
            echo esc_html__('Error fetching data from API.', 'filipe-ajax');
        }
    } else {
        echo esc_html__('Invalid action.', 'filipe-ajax');
    }

    wp_die();
}
add_action('wp_ajax_filipe_fetch_data', 'filipe_ajax_endpoint');
add_action('wp_ajax_nopriv_filipe_fetch_data', 'filipe_ajax_endpoint');