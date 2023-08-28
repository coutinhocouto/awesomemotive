<?php

function add_filipe_admin_page()
{
    add_menu_page(
        'Filipe Data Refresh',
        'Data Refresh',
        'manage_options',
        'filipe-data-refresh',
        'render_data_refresh',
        'dashicons-update',
        2
    );
}
add_action('admin_menu', 'add_filipe_admin_page');

function render_data_refresh()
{
?>
    <div class="wrap">
        <h2><?php _e('Filipe Data Refresh', 'filipe-block'); ?></h2>
        <p class="desc"><?php _e('You can see the data and refresh it.', 'filipe-block'); ?></p>
        <div class="filipe-data">
            <div class="filipe-data-label">
                <label>
                    <?php _e('Users Data', 'filipe-block'); ?>
                </label>
            </div>
            <div id="filipe-api-data-container">
                <div class="loading"><?php _e('Loading...', 'filipe-block'); ?></div>
                <div class="filipe-data-holder"></div>
            </div>
        </div>
        <form method="post" action="">
            <?php wp_nonce_field('data_refresh_nonce', 'data_refresh_nonce'); ?>
            <input type="submit" class="button-primary" name="refresh_data" value="<?php _e('Refresh Data', 'filipe-block'); ?>">
        </form>
        <script>
            // Fetch and display API data using AJAX
            jQuery(document).ready(function($) {
                $.ajax({
                    url: 'https://awesomemotive.lndo.site/wp-admin/admin-ajax.php?action=filipe_fetch_data',
                    type: 'GET',
                    success: function(response) {
                        $('#filipe-api-data-container .loading').hide();

                        var apiDataContainer = $('#filipe-api-data-container .filipe-data-holder');
                        var rows = JSON.parse(response).data.rows;

                        console.log(rows);

                        var tableHtml = '<table><thead><tr><th><?php _e('ID', 'filipe-block'); ?></th><th><?php _e('First Name', 'filipe-block'); ?></th><th><?php _e('Last Name', 'filipe-block'); ?></th><th><?php _e('Email', 'filipe-block'); ?></th><th><?php _e('Date', 'filipe-block'); ?></th></tr></thead><tbody>';
                        $.each(rows, function(key, data) {
                            tableHtml += '<tr>';
                            tableHtml += '<td>' + data.id + '</td>';
                            tableHtml += '<td>' + data.fname + '</td>';
                            tableHtml += '<td>' + data.lname + '</td>';
                            tableHtml += '<td>' + data.email + '</td>';
                            tableHtml += '<td>' + new Date(data.date * 1000).toLocaleString() + '</td>';
                            tableHtml += '</tr>';
                        });
                        tableHtml += '</tbody></table>';

                        apiDataContainer.append(tableHtml);

                    },
                    error: function(error) {
                        $('#filipe-api-data-container').html('<p><?php _e('Error fetching API data.', 'filipe-block'); ?></p>');
                    }
                });
            });
        </script>
    </div>
<?php
}

function handle_data_refresh()
{
    if (isset($_POST['refresh_data'])) {
        // Verify nonce
        if (!isset($_POST['data_refresh_nonce']) || !wp_verify_nonce($_POST['data_refresh_nonce'], 'data_refresh_nonce')) {
            return;
        }

        // Perform data refresh here
        update_option('filipe_last_request_time', 0); // Reset the last request time
        echo '<div class="updated"><p>Data refresh initiated.</p></div>';
    }
}
add_action('admin_init', 'handle_data_refresh');

function filipe_admin_styles()
{
    wp_enqueue_style('filipe-admin-style', plugin_dir_url(__FILE__) . 'styles/filipe-admin-style.css', array(), '1.0');
}
add_action('admin_enqueue_scripts', 'filipe_admin_styles');
