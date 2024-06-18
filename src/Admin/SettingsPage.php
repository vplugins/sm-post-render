<?php

namespace SMPostRender\Admin;

class SettingsPage
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'addAdminMenu']);
        add_action('admin_init', [$this, 'settingsInit']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_styles']);
    }

    public function enqueue_admin_styles()
    {
        // Enqueue custom CSS
        wp_enqueue_style('sm-post-render-admin', plugin_dir_url(__FILE__) . '../../assets/css/custom.css', [], '1.0.0');
    }

    public function addAdminMenu()
    {
        add_options_page(
            'SM Post Render Settings',
            'SM Post Render',
            'manage_options',
            'sm-post-render',
            [$this, 'render']
        );
    }

    public function settingsInit()
    {
        // Register the settings
        register_setting('sm_post_render_options_group', 'ag_id');
        register_setting('sm_post_render_options_group', 'feed_id');

        add_settings_section(
            'sm_post_render_main_section',
            'Main Settings',
            [$this, 'mainSectionCallback'],
            'sm-post-render'
        );

        add_settings_field(
            'ag_id_field',
            'Business ID',
            [$this, 'agIdFieldRender'],
            'sm-post-render',
            'sm_post_render_main_section'
        );

        add_settings_field(
            'feed_id_field',
            'Feed Identifier',
            [$this, 'feedIdFieldRender'],
            'sm-post-render',
            'sm_post_render_main_section'
        );
    }

    public function mainSectionCallback()
    {
        echo '<p>Configure the main settings for SM Post Render.</p>';
    }

    public function agIdFieldRender()
    {
        $agId = get_option('ag_id');
        ?>
        <input type="text" name="ag_id" class="regular-text" value="<?php echo isset($agId) ? esc_attr($agId) : ''; ?>" />
        <p class="description">Enter your Business ID here.</p>
        <?php
    }

    public function feedIdFieldRender()
    {
        $feedId = get_option('feed_id');
        ?>
        <input type="text" name="feed_id" class="regular-text" value="<?php echo isset($feedId) ? esc_attr($feedId) : ''; ?>" />
        <p class="description">Enter your Feed Identifier here.</p>
        <?php
    }

    public function render()
    {
        ?>
    <div class="wrap">
    <h1><?php _e('SM Post Render Settings', 'sm-post-render'); ?></h1>
    <h2 class="nav-tab-wrapper">
        <a href="#account-settings" class="nav-tab nav-tab-active">Account Settings</a>
        <a href="#shortcode-details" class="nav-tab">Shortcode Details</a>
        <a href="#additional-information" class="nav-tab">Additional Information</a>
    </h2>
    <div id="account-settings" class="tab-content">
    <form method="post" action="options.php">
        <?php
        settings_fields('sm_post_render_options_group');
        do_settings_sections('sm-post-render');
        submit_button();
        ?>
    </form>
    </div>
    <div id="shortcode-details" class="tab-content" style="display: none;">
    <h2><?php _e('Shortcode Usage', 'sm-post-render'); ?></h2>
    <p><?php _e('Use the', 'sm-post-render'); ?> <code>[sm-post]</code> <?php _e('shortcode to display social media posts on your website. Here are the available attributes:', 'sm-post-render'); ?></p>
    <ul>
        <li><strong><?php _e('per_page', 'sm-post-render'); ?></strong>: <?php _e('The number of posts to display per page (default and restricted to: 5).', 'sm-post-render'); ?></li>
    </ul>
    <p><strong><?php _e('Example Usage:', 'sm-post-render'); ?></strong></p>
    <pre style="display: inline;"><code id="shortcode-sm-render">[sm-post per_page="5"]</code></pre>
    <i id="copy-shortcode-icon" class="fa fa-clone" aria-hidden="true" onclick="copyShortcode()" title="<?php _e('Copy', 'sm-post-render'); ?>" style="cursor: pointer; margin-left: 10px;"></i>
    </div>
    <div id="additional-information" class="tab-content" style="display: none;">
    <h2><?php _e('Additional Information', 'sm-post-render'); ?></h2>
    <p><?php _e('To customize the appearance of the posts, you can add your own CSS rules in your theme\'s stylesheet.', 'sm-post-render'); ?></p>
    <p><?php _e('Ensure your API keys (Business ID and Feed Identifier) are correctly configured to fetch the posts successfully.', 'sm-post-render'); ?></p>
    </div>
    <div id="snackbar"><?php _e('Shortcode copied to clipboard', 'sm-post-render'); ?></div>
</div>

        <?php
    }

    public function enqueue_admin_scripts()
    {
        // Enqueue Font Awesome
        wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css', [], '6.0.0-beta3');

        // Enqueue custom JavaScript
        wp_enqueue_script('sm-post-render-admin', plugin_dir_url(__FILE__) . '../../assets/js/admin.js', [], '1.0.0', true);
    }
}
