<?php

/**
 * Register the menu locations.
 */
register_nav_menus(
    array(
        'primary_menu' => __('Main Menu', 'roostersopmaat'),
        'footer_menu'  => __('Footer Menu', 'roostersopmaat'),
    )
);

/**
 * Add theme support for various features.
 */
add_action('after_setup_theme', 'add_theme_settings');

function add_theme_settings()
{

    load_theme_textdomain('roostersopmaat', get_template_directory() . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array('search-form', 'navigation-widgets'));
    add_theme_support('appearance-tools');

    add_theme_support('editor-styles');
    add_theme_support('align-wide');
    add_theme_support('wp-block-styles');

    global $content_width;
    if (!isset($content_width)) {
        $content_width = 1920;
    }

    // Add support for editor styles.
    add_theme_support('disable-custom-font-sizes');
}

add_action('enqueue_block_editor_assets', function () {
    global $post;

    if (! $post) {
        return;
    }

    // Look for blocks in the current post
    if (has_block('pl/partner-slider', $post) || has_block('pl/home-slider', $post) || has_block('pl/info', $post)) {
        // Swiper CSS
        wp_enqueue_style(
            'swiper-css',
            'https://cdn.jsdelivr.net/npm/swiper@12.1.2/swiper-bundle.min.css',
            [],
            '12.1.2'
        );

        // Swiper JS
        wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@12.1.2/swiper-bundle.min.js', [], '12.1.2');
    }


    wp_enqueue_style(
        'editor-custom-style',
        get_stylesheet_directory_uri() . '/dist/main.css',
        [],
        '1.0.0'
    );
});

/**
 * Registers styles and scripts for the theme.
 */
add_action('wp_enqueue_scripts', 'pl_register_styles');
function pl_register_styles()
{
    wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');
    // Swiper CSS
    wp_enqueue_style(
        'swiper-css',
        'https://cdn.jsdelivr.net/npm/swiper@12.1.2/swiper-bundle.min.css',
        [],
        '12.1.2'
    );

    // Swiper JS - load in header (false) so block scripts can depend on it
    wp_enqueue_script(
        'swiper-js',
        'https://cdn.jsdelivr.net/npm/swiper@12.1.2/swiper-bundle.min.js',
        [],
        '12.1.2',
        false
    );
    wp_register_style('main-css', get_template_directory_uri() . '/dist/main.css', array('fontawesome', 'swiper-css', 'wp-block-library'), '1.0.0');
    wp_enqueue_style('main-css');
    wp_register_script('main-js', get_template_directory_uri() . '/dist/main.js', array('wp-i18n', 'swiper-js'), '1.0.0', false);
    wp_enqueue_script('main-js');
}

/**
 * Add swiper-js as a dependency for Swiper-based block scripts
 */
add_action('wp_print_scripts', function () {
    global $wp_scripts;
    if (!$wp_scripts) return;

    $swiper_blocks = array('pl-hero-slider-script', 'pl-partner-slider-script', 'pl-info-script');

    foreach ($swiper_blocks as $block_script) {
        if (isset($wp_scripts->registered[$block_script])) {
            // Add swiper-js as a dependency if not already present
            if (!in_array('swiper-js', $wp_scripts->registered[$block_script]->deps)) {
                $wp_scripts->registered[$block_script]->deps[] = 'swiper-js';
            }
        }
    }
}, 1);

/**
 */
function roostersopmaat_schema_type()
{
    $schema = 'https://schema.org/';
    if (is_single()) {
        $type = "Article";
    } elseif (is_author()) {
        $type = 'ProfilePage';
    } elseif (is_search()) {
        $type = 'SearchResultsPage';
    } else {
        $type = 'WebPage';
    }
    echo 'itemscope itemtype="' . esc_url($schema) . esc_attr($type) . '"';
}

/* gutenberg blocks */

/**
 * Registeren custom 'hondennamen' category
 */

add_filter('block_categories_all', function ($categories) {

    $categories[] = array(
        'slug'  => 'roostersopmaat',
        'title' => 'roostersopmaat'
    );

    return $categories;
});

// rank math

/**
 * Disable Gutenberg Sidebar Integration
 */
add_filter('rank_math/gutenberg/enabled', '__return_false');

/**
 * Add custom variables to Rank Math
 */

add_action('rank_math/vars/register_extra_replacements', function () {
    rank_math_register_var_replacement(
        'number_of_reviews',
        [
            'name'        => esc_html__('Number of reviews', 'uncode'),
            'description' => esc_html__('Number of reviews', 'uncode'),
            'variable'    => 'number_of_reviews',
            'example'     => get_field('number_of_reviews', 'option') ?: 1,
        ],
        function () {
            $number_of_reviews = get_field('number_of_reviews', 'option');
            return isset($number_of_reviews) ? $number_of_reviews : 1;
        }
    );

    rank_math_register_var_replacement(
        'review_score',
        [
            'name'        => esc_html__('Review score', 'uncode'),
            'description' => esc_html__('Review score', 'uncode'),
            'variable'    => 'review_score',
            'example'     => get_field('review_score', 'option') ?: 1,
        ],
        function () {
            $review_score = get_field('review_score', 'option');
            return isset($review_score) ? $review_score : 1;
        }
    );
});

/**
 * add SVG support without plugin
 */

add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mimes) {

    global $wp_version;
    if ($wp_version !== '4.7.1') {
        return $data;
    }

    $filetype = wp_check_filetype($filename, $mimes);

    return [
        'ext'             => $filetype['ext'],
        'type'            => $filetype['type'],
        'proper_filename' => $data['proper_filename']
    ];
}, 10, 4);

/**
 * Add SVG to the supported file types
 */
function cc_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

/**
 * Add some dimensions to some classes for svg
 */
function fix_svg()
{
    echo '<style type="text/css">
          .attachment-266x266, .thumbnail img {
               width: 100% !important;
               height: auto !important;
          }
          </style>';
}
add_action('admin_head', 'fix_svg');

/* Google tag manager */
add_action('wp_head', function () {
?>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-CNVCT22KTR"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-CNVCT22KTR');
    </script>
<?php
});

// TODO fix error
//add_filter('wp_get_attachment_image_src', 'fix_wp_get_attachment_image_svg', 10, 4);

function fix_wp_get_attachment_image_svg($image, $attachment_id, $size, $icon)
{
    if (is_array($image) && preg_match('/\.svg$/i', $image[0]) && $image[1] <= 1) {
        if (is_array($size)) {
            $image[1] = $size[0];
            $image[2] = $size[1];
        } elseif (($xml = simplexml_load_file($image[0])) !== false) {
            $attr = $xml->attributes();
            $viewbox = explode(' ', $attr->viewBox);
            $image[1] = isset($attr->width) && preg_match('/\d+/', $attr->width, $value) ? (int) $value[0] : (count($viewbox) == 4 ? (int) $viewbox[2] : null);
            $image[2] = isset($attr->height) && preg_match('/\d+/', $attr->height, $value) ? (int) $value[0] : (count($viewbox) == 4 ? (int) $viewbox[3] : null);
        } else {
            $image[1] = $image[2] = null;
        }
    }
    return $image;
}


/**
 * To make the editor a bit wider
 */
add_action('admin_head', 'admin_styles');
function admin_styles()
{
    echo '<style>
            .interface-interface-skeleton__sidebar {
                max-width: 600px;
                min-width: 500px;
                resize: horizontal;
            }

            .interface-complementary-area__fill,
            .interface-complementary-area {
                width: 100% !important;
            }

            </style>';
}
