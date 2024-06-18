<?php

namespace SMPostRender\Shortcode;

class PostShortcode
{
    // API URL for fetching posts
    const API_URL = 'https://social-posts-prod.apigateway.co/socialposts.v2.CuratedContent/List';

    public function register()
    {
        add_shortcode('sm-post', [$this, 'renderShortcode']);

        // Enqueue custom CSS file
        add_action('wp_enqueue_scripts', [$this, 'enqueue_custom_styles']);
    }

    public function enqueue_custom_styles()
    {
        // Enqueue the custom CSS file
        wp_enqueue_style('sm-post-render-custom', plugin_dir_url(__FILE__) . '../../assets/css/custom.css', [], '1.0.0', 'all');
    }

    public function renderShortcode($atts)
    {
        $agId = get_option('ag_id');
        $feedId = get_option('feed_id');
        $atts = shortcode_atts([
            'per_page' => 5
        ], $atts, 'sm-post');

        // Setup request data based on shortcode attributes
        $data = [
            'businessId' => $agId,
            'feedId' => $feedId,
            'pageSize' => $atts['per_page']
        ];

        // Setup request headers
        $headers = [
            'Content-Type: application/json'
        ];

        // Make the request to the API
        $response = wp_remote_post(self::API_URL, [
            'headers' => $headers,
            'body' => json_encode($data)
        ]);

        // Check for errors in the response
        if (is_wp_error($response)) {
            error_log('API request error: ' . $response->get_error_message());
            return 'Error fetching posts.';
        }

        // Log the raw response body for debugging
        $response_body = wp_remote_retrieve_body($response);
        error_log('API response body: ' . $response_body);

        $posts_data = json_decode($response_body, true);

        // Check if the JSON decoding failed
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log('JSON decode error: ' . json_last_error_msg());
            return 'Error decoding posts data.';
        }

        if (empty($posts_data['posts'])) {
            return 'No posts found.';
        }

        $output = '<div class="sm-posts">';
        foreach ($posts_data['posts'] as $post) {
            $output .= '<div class="sm-post">';
            $output .= '<p>' . esc_html($post['text']) . '</p>';

            // Check if media (images) exist for the current post
            if (!empty($post['media'])) {
                $output .= '<div class="post-images">';
                foreach ($post['media'] as $media) {
                    if ($media['type'] === 'image') {
                        $output .= '<img src="' . esc_url($media['url']) . '" alt="Image">';
                    }
                }
                $output .= '</div>';
            }

            $output .= '</div>';
        }
        $output .= '</div>';

        return $output;
    }
}
