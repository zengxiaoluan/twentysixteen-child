<?php
/**
 * Template Name: Authors
 * Display all authors
 * created at 2018-04-08
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <?php
        // Start the loop.
        while ( have_posts() ) : the_post();

            // Include the page content template.
            get_template_part( 'template-parts/content', 'page' );

            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) {
                comments_template();
            }

            // End of the loop.
        endwhile;
        ?>
        <?php
            function contributors() {
                global $wpdb;
             
                $authors = $wpdb->get_results("SELECT ID, user_nicename from $wpdb->users ORDER BY display_name");
             
                foreach($authors as $author) {

                    $authorID = $author->ID;

                    $display_name = get_the_author_meta('display_name', $authorID);

                    $user_nicename = get_the_author_meta('user_nicename', $authorID);

                    $description = get_the_author_meta('description', $authorID);

                    $user_url = get_the_author_meta('user_url', $authorID);

                    $link = get_bloginfo('url') . '/author/' . $user_nicename;

        ?>
            <li class="one">
                <a class="avatar" target="_blank" href="<?php echo $link; ?>">
                    <?php echo get_avatar($authorID); ?>
                </a>
                <dl class="text">
                    <dt><?php echo $display_name; ?></dt>
                    <dd>
                        <a target="_blank" href="<?php echo $user_url; ?>">
                            <?php echo $user_url; ?>
                        </a>
                    </dd>
                    <?php echo $description; ?>
                </dl>
            </li>
        <?php

                }
            }
        ?>
        <div class="author-list">
            <ul>
                <?php contributors(); ?>
            </ul>
        </div>
    </main>
    <?php get_sidebar( 'content-bottom' ); ?>
</div>

<style>
    .author-list .one {
        border: 1px solid #eee;
        margin-bottom: 1em;
        padding: 1em;
    }
    .author-list .avatar {
        display: inline-block;
    }
    .author-list .text {
        display: inline-block;
    }
</style>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
