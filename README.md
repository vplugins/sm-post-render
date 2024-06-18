
# SM Post Render

![PHP Version](https://img.shields.io/badge/PHP-%5E7.4-blue)
![WordPress Version](https://img.shields.io/badge/WordPress-%5E5.0-blue)

## Description

SM Post Render is a WordPress plugin that allows you to fetch and display social media posts on your website using a simple shortcode. The plugin comes with a settings page to configure your AG-ID and Feed Identifier.

## Installation

1. Upload the `sm-post-render` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Navigate to `Settings -> SM Post Render` to configure the plugin.

## Usage

To display social media posts on your website, use the following shortcode in your posts or pages: `[sm-post per_page="5"]`


### Shortcode Attributes

- `per_page`: The number of posts to display per page (default to: 5).

## Frequently Asked Questions

### How do I configure the plugin?

After activating the plugin, go to `Settings -> SM Post Render` and enter your Business ID and Feed Identifier.

### What should I do if the posts are not displaying?

Ensure that your API keys (Business ID and Feed Identifier) are correctly configured in the settings. If the problem persists, check the error logs for any issues with the API request.

### Can I customize the appearance of the posts?

Yes, you can add your own CSS rules in your theme's stylesheet.

## Changelog

### 1.0.0
* Initial release.


## Developer Notes

- Ensure your environment has Composer installed and run `composer install` to load dependencies.
- This plugin requires WordPress version 5.0 and PHP version 7.2 or higher.
