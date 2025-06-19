<?php
/**
 * Шаблон для отображения отдельных постов
 *
 * @package RocketBusiness
 * @version 1.0.0
 */

get_header(); ?>

<main id="main" class="rb-main">
    <div class="rb-container">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('rb-single-post'); ?>>
                <header class="rb-single-post__header">
                    <h1 class="rb-single-post__title"><?php the_title(); ?></h1>
                    
                    <div class="rb-single-post__meta">
                        <span class="rb-single-post__meta-item rb-single-post__meta-item--date">
                            <i class="rb-single-post__meta-icon rb-single-post__meta-icon--calendar"></i>
                            <time class="rb-single-post__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                <?php echo get_the_date(); ?>
                            </time>
                        </span>
                        
                        <span class="rb-single-post__meta-item rb-single-post__meta-item--author">
                            <i class="rb-single-post__meta-icon rb-single-post__meta-icon--user"></i>
                            <span class="rb-single-post__author">
                                <a class="rb-single-post__author-link" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                    <?php the_author(); ?>
                                </a>
                            </span>
                        </span>
                        
                        <?php if (has_category()) : ?>
                            <span class="rb-single-post__meta-item rb-single-post__meta-item--categories">
                                <i class="rb-single-post__meta-icon rb-single-post__meta-icon--folder"></i>
                                <?php the_category(', '); ?>
                            </span>
                        <?php endif; ?>
                        
                        <?php if (has_tag()) : ?>
                            <span class="rb-single-post__meta-item rb-single-post__meta-item--tags">
                                <i class="rb-single-post__meta-icon rb-single-post__meta-icon--tag"></i>
                                <?php the_tags('', ', '); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </header>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="rb-single-post__thumbnail">
                        <?php the_post_thumbnail('large', ['class' => 'rb-single-post__image']); ?>
                    </div>
                <?php endif; ?>

                <div class="rb-single-post__content">
                    <?php
                    the_content();
                    
                    wp_link_pages([
                        'before' => '<div class="rb-single-post__links">' . __('Страницы:', 'rocketbusiness'),
                        'after'  => '</div>',
                    ]);
                    ?>
                </div>

                <footer class="rb-single-post__footer">
                    <?php
                    edit_post_link(
                        sprintf(
                            wp_kses(
                                __('Редактировать <span class="rb-screen-reader-text">"%s"</span>', 'rocketbusiness'),
                                [
                                    'span' => [
                                        'class' => [],
                                    ],
                                ]
                            ),
                            wp_kses_post(get_the_title())
                        ),
                        '<span class="rb-single-post__edit-link">',
                        '</span>'
                    );
                    ?>
                </footer>
            </article>

            <nav class="rb-post-navigation">
                <div class="rb-post-navigation__links">
                    <div class="rb-post-navigation__prev">
                        <?php previous_post_link('%link', '<i class="rb-post-navigation__icon rb-post-navigation__icon--left"></i> %title'); ?>
                    </div>
                    <div class="rb-post-navigation__next">
                        <?php next_post_link('%link', '%title <i class="rb-post-navigation__icon rb-post-navigation__icon--right"></i>'); ?>
                    </div>
                </div>
            </nav>

        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?> 