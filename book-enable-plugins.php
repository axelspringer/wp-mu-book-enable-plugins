<?php

// @codingStandardsIgnoreFile

/*
 * Auto-enable plugins
 */
include_once(ABSPATH . 'wp-admin/includes/plugin.php');

// if plugins should be enabled, take that list
foreach (defined('ENABLE_PLUGINS') ? ENABLE_PLUGINS : array() as $plugin) {

    // check that file exists
    if (!file_exists(join('/', array(WP_PLUGIN_DIR, $plugin)))) {
        add_action('admin_notices', function () use ($plugin) {
            echo '<div class="notice notice-error"><p>' . sprintf('<strong>%s</strong> plugin is required but plugin file not exists.', $plugin) . '</p></div>';
        });

        continue;
    }

    // check if plugin is active
    if (!is_plugin_active($plugin)) {
        activate_plugin($plugin);
        // notice user
        add_action('admin_notices', function () use ($plugin) {
            echo '<div class="updated"><p>' . sprintf('<strong>%s</strong> plugin is required & is auto-enabled.', $plugin) . '</p></div>';
        });
    }
}
