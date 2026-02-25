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

// Collect repeater data once
$info_items = [];
if (have_rows('info_item')) {

    while (have_rows('info_item')) {
        the_row();
        $image = get_sub_field('image');
        $info_items[] = [
            'title'       => get_sub_field('title'),
            'description' => get_sub_field('description'),
            'img_url'     => is_array($image) ? $image['url'] : $image,
            'img_alt'     => is_array($image) ? $image['alt'] : '',
            'index'       => get_row_index(),
        ];
    }
}

?>

<section class="wrapper info" <?= wp_kses_data($attributes); ?>>
    <h2><?= get_field('title'); ?></h2>

    <?php if (!empty($info_items)): ?>

        <!-- Mobile Swiper -->
        <div class="swiper swiper-info">
            <div class="swiper-wrapper">
                <?php foreach ($info_items as $item): ?>
                    <div class="swiper-slide">
                        <article class="info-block">
                            <div class="info-block__content">
                                <h2><?= esc_html($item['title']); ?></h2>
                                <p><?= wp_kses_post($item['description']); ?></p>
                            </div>
                            <?php if ($item['img_url']): ?>
                                <figure class="info-block__figure">
                                    <img src="<?= esc_url($item['img_url']); ?>" alt="<?= esc_attr($item['img_alt']); ?>">
                                </figure>
                            <?php endif; ?>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Tablet+ Grid -->
        <div class="info-grid">
            <?php foreach ($info_items as $index => $item): ?>
                <?php
                $info_block_classes = 'info-block';
                if ($item['index'] % 2 === 0) {
                    $info_block_classes .= ' image-left';
                }
                ?>
                <article class="<?= esc_attr($info_block_classes); ?>" id="info-block-<?= esc_attr($item['index']); ?>">
                    <div class="info-block__content">
                        <h2><?= esc_html($item['title']); ?></h2>
                        <p><?= wp_kses_post($item['description']); ?></p>
                    </div>
                    <?php if ($item['img_url']): ?>
                        <figure class="info-block__figure">
                            <img src="<?= esc_url($item['img_url']); ?>" alt="<?= esc_attr($item['img_alt']); ?>">
                        </figure>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

</section>
<!-- end temporary info block -->