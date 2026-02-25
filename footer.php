<?php

/**
 * The template for displaying the footer
 *
 * @package roostersopmaat
 */
?>
</main>
<footer id="footer" class="site-footer">
    <div class="wrapper-large">
        <div class="wrapper">
            <div class="site-footer__top">
                <div class="site-footer__col">
                    <?php
                    // Get logo from ACF options page
                    $logo = get_field('footer_logo', 'option');

                    if ($logo) {
                        $logo_url = $logo['url'];
                        echo '<a href="' . esc_url(home_url('/')) . '" rel="home">';
                        echo '<img class="site-footer__logo" src="' . esc_url($logo_url) . '" alt="' . esc_attr(get_bloginfo('name')) . ' logo">';
                        echo '</a>';
                    } else {
                        echo '<a href="' . esc_url(home_url('/')) . '" rel="home">' . get_bloginfo('name') . '</a>';
                    }
                    ?>
                    <?php if (have_rows('footer_socials', 'option')): ?>
                        <ul class="site-footer__socials">
                            <?php while (have_rows('footer_socials', 'option')): the_row();
                                $platform = get_sub_field('platforms');
                                $url = get_sub_field('social_url');
                            ?>
                                <?php if ($url): ?>
                                    <li>
                                        <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener">
                                            <?php
                                            $icons = [
                                                'facebook' => 'fa-facebook-f',
                                                'linkedin' => 'fa-linkedin-in',
                                                'instagram' => 'fa-instagram',
                                                'youtube' => 'fa-youtube',
                                                'x' => 'fa-x-twitter'
                                            ];
                                            if (isset($icons[$platform])) {
                                                echo '<i class="fab fa-lg ' . esc_attr($icons[$platform]) . '"></i>';
                                            }
                                            ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endwhile; ?>
                        </ul>
                    <?php endif; ?>
                </div>
                <div class="site-footer__col">
                    <div class="site-footer__contact">
                        <?php
                        // Get contact info from ACF options page
                        $phone = get_field('contact_tel', 'option');
                        $email = get_field('contact_email', 'option');
                        $address = get_field('contact_adres', 'option');
                        $vat = get_field('contact_btw', 'option');
                        ?>

                        <?php if ($address): ?>
                            <span class="site-header__address">
                                <i class="fa fa-location-dot fa-lg" aria-hidden="true"></i>
                                <span><?php echo esc_html($address); ?></span>
                            </span>
                        <?php endif; ?>

                        <?php if ($email): ?>
                            <a href="mailto:<?php echo antispambot($email); ?>" class="site-header__email">
                                <i class="fa fa-envelope fa-lg" aria-hidden="true"></i>
                                <span class="email-protected"><?php echo esc_html($email); ?></span>
                            </a>
                        <?php endif; ?>

                        <?php if ($phone): ?>
                            <a href="tel:<?php echo esc_attr($phone); ?>" class="site-header__phone">
                                <i class="fa fa-phone fa-lg" aria-hidden="true"></i>
                                <span><?php echo esc_html($phone); ?></span>
                            </a>
                        <?php endif; ?>

                        <?php if ($vat): ?>
                            <span class="site-header__vat">
                                <i class="fa fa-id-card fa-lg" aria-hidden="true"></i>
                                <span><?php echo esc_html($vat); ?></span>
                            </span>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
        <div class="site-footer__bottom wrapper">
            <div class="site-footer__menu">

                <?php if (has_nav_menu('footer_menu')) : ?>
                    <div class="footer-menu">
                        <?php wp_nav_menu(array('theme_location' => 'footer_menu')); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="site-footer__copyright">

                &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>.
            </div>

        </div>
    </div>
</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>

</html>