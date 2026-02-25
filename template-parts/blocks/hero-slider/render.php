<?php
$block_id = '';
if (!empty($block['anchor'])) {
    $block_id = esc_attr($block['anchor']);
}

$class_name = '';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}

$attributes = wp_kses_data(
    get_block_wrapper_attributes(
        array(
            'id'    => $block_id,
            'class' => esc_attr($class_name),
        )
    )
);
?>

<!-- temporary slider block -->
<section class="hero <?= $class_name; ?>" <?= $attributes; ?>>
    <div class="wrapper-large">
        <div class="swiper swiper-home">
            <div class="swiper-wrapper">
                <?php if (have_rows('slider_images')): ?>
                    <?php while (have_rows('slider_images')): the_row();
                        $hero_image = get_sub_field('hero_image');
                        $hero_link = get_sub_field('hero_link');
                        if ($hero_image):
                    ?>
                            <div class="swiper-slide">
                                <img src="<?= esc_url($hero_image['url']); ?>" alt="<?= esc_attr($hero_image['alt']); ?>">

                                <div class="hero__content">
                                    <h1><?= get_sub_field('hero_title'); ?></h1>
                                    <h4><?= get_sub_field('hero_subtitle'); ?></h4>
                                    <?php if ($hero_link): ?>
                                        <?php
                                        $url = $hero_link['url'];
                                        $title = esc_html($hero_link['title']);

                                        // Check if the URL contains 'mailto:'
                                        if (str_contains($url, 'mailto:')) {
                                            // Extract the email address and apply antispambot
                                            $email = str_replace('mailto:', '', $url);
                                            $safe_email = antispambot($email);
                                            $url = 'mailto:' . $safe_email;

                                            // Optional: if title is the same as the email, obfuscate it too
                                            if ($title === $email) {
                                                $title = antispambot($title);
                                            }
                                        }
                                        ?>
                                        <a href="<?= esc_url($url); ?>" class="hero__link btn"><?= $title; ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
</section>
<!-- end temporary slider block -->