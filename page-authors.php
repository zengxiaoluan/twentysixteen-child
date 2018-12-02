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
                $posts = array();
             
                $authors = $wpdb->get_results("SELECT ID, user_nicename from $wpdb->users ORDER BY ID");
             
                foreach($authors as $author) {
                    $one = array();

                    $authorID = $author->ID;

                    $user_post_count = count_user_posts( $authorID );
                    if (!$user_post_count) continue;

                    $display_name = get_the_author_meta('display_name', $authorID);
                    $user_nicename = get_the_author_meta('user_nicename', $authorID);
                    $description = get_the_author_meta('description', $authorID);
                    $user_url = get_the_author_meta('user_url', $authorID);
                    $link = get_bloginfo('url') . '/author/' . $user_nicename;
                    
                    $one['authorID'] = $authorID;
                    $one['user_post_count'] = $user_post_count;
                    $one['display_name'] = $display_name;
                    $one['user_nicename'] = $user_nicename;
                    $one['description'] = $description;
                    $one['user_url'] = $user_url;
                    $one['link'] = $link;

                    $posts[] = $one;
                }

                function cmp($a, $b){
                    if ($a['user_post_count'] == $b['user_post_count']) {
                        return 0;
                    }
                    return ($a['user_post_count'] > $b['user_post_count']) ? -1 : 1;
                }
                usort($posts, 'cmp');

                foreach($posts as $one) {
                    $authorID = $one['authorID'];
                    $user_post_count = $one['user_post_count'];
                    $display_name = $one['display_name'];
                    $user_nicename = $one['user_nicename'];
                    $description = $one['description'];
                    $user_url = $one['user_url'];
                    $link = $one['link'];
        ?>
            <li class="one">
                <a class="avatar-wrap" title="<?php echo $display_name; ?>" target="_blank" href="<?php echo $link; ?>">
                    <?php echo get_avatar($authorID, 200, '', $display_name, ['class'=>'author-avatar']); ?>
                </a>
                <dl class="text">
                    <dt><?php echo $display_name; ?></dt>
                    <dd>
                        <a class="user-url" target="_blank" href="<?php echo $user_url; ?>">
                            <?php echo $user_url; ?>
                        </a>
                    </dd>
                    <?php echo $description; ?>
                    <dd>
                        <a target="_blank" href="<?php echo $link; ?>">
                            <?php echo $user_post_count; ?> 篇文章
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
    .author-list {
        margin: 0 1em;
    }
    .author-list .one {
        border: 1px solid #eee;
        margin-bottom: 1em;
        padding: 1em;
        display: flex;
        align-items: center;
    }
    .author-list .one img {
        max-width: unset;
    }
    @media screen and (max-width: 710px) {
        .author-list .one {
            display: inline-block;
        }
    }
    .author-list .avatar-wrap {
        display: inline-block;
        vertical-align: middle;
        margin-right: 1em;
    }
    .author-list .text {
        display: inline-block;
        vertical-align: middle;
    }
    .author-list .avatar {
        transition: border-radius .4s;
    }
    .author-list .avatar:hover {
        border-radius: unset !important;
    }
    .user-url {
        word-break: break-all;
    }
</style>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
