<?php

/* 
 * ------------------------------
 * CREATION OF THE WP-CLI COMMAND 
 * ------------------------------
*/

if ( defined('WP_CLI') && WP_CLI ) {
    class ForceRefreshDataCommand extends WP_CLI_Command {
        public function refresh_data() {
            update_option('filipe_last_request_time', 0);
            WP_CLI::success('Data refresh forced.');
        }
    }
    WP_CLI::add_command('refresh-data', 'ForceRefreshDataCommand');
}