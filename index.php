<?php

/**

 * Template Name: homepage

 */

get_header();
?>

<section class="homepage">

    <div class="container">

        <div class="row">

            <?php
            $args = array(
                'order' => 'ASC',
                'orderby' => 'title',
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => '20',
            );

            //check if gender is passed
            $gender = get_query_var('custom_gender');
            $additional_args = [];

            if ($gender) {

                // args
                $additional_args = array(

                    'meta_query'    => array(
                        array(
                            'key'       => 'geslacht',
                            'value'     => $gender,
                            'compare'   => '='
                        )
                    )
                );
            }

            $args = array_merge($args, $additional_args);

            $query = new WP_Query($args);

            if ($query->have_posts()) :
                while ($query->have_posts()) :
                    $query->the_post(); ?>

                    <?= get_template_part('inc/components/name', 'block'); ?>

            <?php endwhile;
            endif;
            wp_reset_postdata(); ?>

        </div>

    </div>

</section>

<?php

get_footer();

?>