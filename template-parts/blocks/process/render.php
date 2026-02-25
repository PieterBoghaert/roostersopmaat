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
    <div class="process-grid">

        <?php if (have_rows('process_item')): ?>
            <?php while (have_rows('process_item')): the_row();
                $image = get_sub_field('image');
                $title = get_sub_field('title');
                $description = get_sub_field('description');
                $fallback_img = 'https://picsum.photos/id/1005/800/450';
            ?>
                <article class="card">
                    <div class="card__inner">
                        <figure>
                            <?php if ($image): ?>
                                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                            <?php else: ?>
                                <img src="<?php echo esc_url($fallback_img); ?>" alt="">
                            <?php endif; ?>
                        </figure>
                        <div class="card__body">
                            <h3><?php echo esc_html($title); ?></h3>
                            <?php if ($description): ?>
                                <?= wp_kses_post(wpautop($description)); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php endif; ?>

    </div>
</section>
<!-- end temporary process block -->