<?php

$block_id = wp_unique_prefixed_id('pl-block-id-');
if (! empty($block['anchor'])) {
    $block_id = esc_attr($block['anchor']);
}

// Grab our alignment class.
$block_classes = '';
if ('' !== $block['align']) {
    $block_classes = 'align' . $block['align'];
}

$attributes = get_block_wrapper_attributes(array(
    'id'    => esc_attr($block_id),
    'class' => $block_classes,
));
?>

<section class="wrapper" <?= wp_kses_data($attributes); ?>>
    <h2><?= get_field('title'); ?></h2>
    <div class="swiper swiper-logo">
        <div class="swiper-wrapper">
            <?php if (have_rows('partners')): ?>
                <?php while (have_rows('partners')): the_row();
                    $logo = get_sub_field('partner_logo');
                    $url = get_sub_field('partner_url');
                ?>
                    <div class="swiper-slide">
                        <?php if ($url): ?>
                            <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener">
                            <?php endif; ?>
                            <?php if ($logo): ?>
                                <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['alt']); ?>" />
                            <?php endif; ?>
                            <?php if ($url): ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>

    </div>
    </div>
    <!-- end temporary slider logo block -->
</section>