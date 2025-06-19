<?php
/**
 * Шаблон для отображения страниц
 *
 * @package RocketBusiness
 * @version 1.0.0
 */

get_header(); ?>

<main id="main" class="rb-main">
    <div class="rb-container">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('rb-page-content'); ?>>
                <header class="rb-page-content__header">
                    <h1 class="rb-page-content__title"><?php the_title(); ?></h1>
                </header>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="rb-page-content__thumbnail">
                        <?php the_post_thumbnail('large', ['class' => 'rb-page-content__image']); ?>
                    </div>
                <?php endif; ?>

                <div class="rb-page-content__content">
                    <?php
                    the_content();
                    
                    wp_link_pages([
                        'before' => '<div class="rb-page-content__links">' . __('Страницы:', 'rocketbusiness'),
                        'after'  => '</div>',
                    ]);
                    ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?> 