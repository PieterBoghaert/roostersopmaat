<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php roostersopmaat_schema_type(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <header class="site-header " role="banner">
        <div class="wrapper-large">
            <div class="site-header__wrapper wrapper">
                <div class="site-header__logo">
                    <?php
                    // Get logo from ACF options page
                    $logo = get_field('logo', 'option');

                    if ($logo) {
                        $logo_url = $logo['url'];
                        $logo_alt = $logo['alt'] ? $logo['alt'] : get_bloginfo('name') . ' logo';
                        $logo_width = $logo['width'];
                        $logo_height = $logo['height'];
                        echo '<a href="' . esc_url(home_url('/')) . '" rel="home">';
                        echo '<img width="' . esc_attr($logo_width) . '" height="' . esc_attr($logo_height) . '" src="' . esc_url($logo_url) . '" alt="' . esc_attr($logo_alt) . '">';
                        echo '</a>';
                    } else {
                        echo '<a href="' . esc_url(home_url('/')) . '" rel="home">' . get_bloginfo('name') . '</a>';
                    }
                    ?>
                </div>
                <div class="site-header__contact">
                    <?php
                    // Get contact info from ACF options page
                    $phone = get_field('contact_tel', 'option');
                    $email = get_field('contact_email', 'option');
                    ?>

                    <?php if ($phone): ?>
                        <a href="tel:<?php echo esc_attr($phone); ?>" class="site-header__phone">
                            <i class="fa fa-phone fa-lg" aria-hidden="true"></i>
                            <span><?php echo esc_html($phone); ?></span>
                        </a>
                    <?php endif; ?>

                    <?php if ($email): ?>
                        <a href="mailto:<?php echo antispambot($email); ?>" class="site-header__email">
                            <i class="fa fa-envelope fa-lg" aria-hidden="true"></i>
                            <span class="email-protected"><?php echo esc_html($email); ?></span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>
    <main id="content" class="site-content" role="main">