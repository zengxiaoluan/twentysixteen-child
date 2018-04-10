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

        ?>
        <div class="author-list">
            <ul>
                <?php contributors(); ?>
            </ul>
        </div>
        <?php

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
             
                $authors = $wpdb->get_results("SELECT ID, user_nicename from $wpdb->users ORDER BY ID");
             
                foreach($authors as $author) {

                    $authorID = $author->ID;

                    $display_name = get_the_author_meta('display_name', $authorID);

                    $user_nicename = get_the_author_meta('user_nicename', $authorID);

                    $description = get_the_author_meta('description', $authorID);

                    $user_url = get_the_author_meta('user_url', $authorID);

                    $user_post_count = count_user_posts( $authorID );

                    $link = get_bloginfo('url') . '/author/' . $user_nicename;

        ?>
            <li class="one">
                <a class="avatar" title="<?php echo $display_name; ?>" target="_blank" href="<?php echo $link; ?>">
                    <?php echo get_avatar($authorID, 200, '', $display_name, ['class'=>'author-avatar']); ?>
                </a>
                <dl class="text">
                    <dt><?php echo $display_name; ?></dt>
                    <dd>
                        <a target="_blank" href="<?php echo $user_url; ?>">
                            <?php echo $user_url; ?>
                        </a>
                    </dd>
                    <?php echo $description; ?>
                    <dd>
                        <a target="_blank" href="<?php echo $link; ?>">
                            <?php echo $user_post_count; ?> posts
                        </a>
                    </dd>
                </dl>
            </li>
        <?php
                }
            }
        ?>
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
        vertical-align: middle;
    }
    .author-list .text {
        display: inline-block;
        vertical-align: middle;
    }
    .avatar {
        transition: border-radius .4s;
    }
    .author-avatar:hover {
        border-radius: unset !important;
    }
</style>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
