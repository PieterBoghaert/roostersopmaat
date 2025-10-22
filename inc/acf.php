<?php

add_action('acf/init', function () {
    if (function_exists('acf_add_options_page')) {

        acf_add_options_page(array(
            'page_title'    => 'Theme General Settings',
            'menu_title'    => 'Theme Settings',
            'menu_slug'     => 'theme-general-settings',
            'capability'    => 'edit_posts',
            'redirect'      => false
        ));

        acf_add_options_sub_page(array(
            'page_title'    => 'Theme Header Settings',
            'menu_title'    => 'Header',
            'parent_slug'   => 'theme-general-settings',
        ));

        acf_add_options_sub_page(array(
            'page_title'    => 'Theme Footer Settings',
            'menu_title'    => 'Footer',
            'parent_slug'   => 'theme-general-settings',
        ));
    }
});

/**
 * Register ACF Blocks
 */
add_action('init', 'register_acf_blocks');
function register_acf_blocks()
{
    $blocks_dir = __DIR__ . '/../template-parts/blocks/';
    foreach (glob($blocks_dir . '*', GLOB_ONLYDIR) as $block_folder) {
        register_block_type($block_folder);
    }
}

/**
 * Register custom 'roostersopmaat' category
 */
add_filter('block_categories_all', function ($categories) {

    $categories[] = array(
        'slug'  => 'roostersopmaat',
        'title' => 'roostersopmaat',
    );

    return $categories;
});

/**
 * Add custom body classes when specific conditions are met
 */
add_filter('body_class', function ($classes) {
    if (is_page()) {
        global $post;

        if ($post && function_exists('has_blocks') && has_blocks($post->post_content)) {
            $blocks = parse_blocks($post->post_content);

            // Check if there are ANY ACF blocks
            $has_acf_block = false;

            foreach ($blocks as $block) {
                if (!empty($block['blockName']) && str_starts_with($block['blockName'], 'pl/')) {
                    $has_acf_block = true;
                    break;
                }
            }

            // If no ACF blocks found → add static-pages class
            if (!$has_acf_block) {
                $classes[] = 'static-pages';
            }
        } else {
            // No blocks at all → also count as static
            $classes[] = 'static-pages';
        }
    }

    return $classes;
});

/**
 * Allow editors to customize the theme
 */
function allow_editor_customizer()
{
    $role = get_role('editor');
    if ($role && !$role->has_cap('edit_theme_options')) {
        $role->add_cap('edit_theme_options');
    }
}
add_action('init', 'allow_editor_customizer');

/**
 * Show the Customizer menu item for editors
 */
function show_customizer_for_editors()
{
    if (current_user_can('edit_theme_options')) {
        add_menu_page(
            __('Customize', 'roostersopmaat'),
            __('Customize', 'roostersopmaat'),
            'edit_theme_options',
            'customize.php',
            '',
            'dashicons-admin-customizer',
            61
        );
    }
}
add_action('admin_menu', 'show_customizer_for_editors');
