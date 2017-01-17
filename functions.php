<?php 

// enqueue scripts
add_action('wp_enqueue_scripts', 'enqueue_styles');

function enqueue_styles(){
    // load parent styles
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_script( 'child-script', get_stylesheet_directory_uri() . '/child.js', array(), '2016-11-01', true );
}

// add back-to-top and beian number
add_action( 'twentysixteen_credits', 'add_beian_number');

function add_beian_number(){
    echo "<span class='site-title'><a target='_blank' href='http://www.miibeian.gov.cn/state/outPortal/loginPortal.action'>湘ICP备16005159号-1</a></span>";
    echo "<span class='site-title'><a id='top' class='genericon-top' title='回到顶部'></a></span>";
}

// set revision time as one
add_filter( 'wp_revisions_to_keep', 'orange_revision_times', 10, 2 );

function orange_revision_times( $num, $post ) {
    return 1;
}

//  Custome Prints HTML with meta information for the categories, tags.
function twentysixteen_entry_meta() {
    if ( 'post' === get_post_type() ) {
        $author_avatar_size = apply_filters( 'twentysixteen_author_avatar_size', 49 );
        printf( '<span class="byline"><span class="author vcard">%1$s<span class="screen-reader-text">%2$s </span> <a class="url fn n" href="%3$s">%4$s</a></span></span>',
            get_avatar( get_the_author_meta( 'user_email' ), $author_avatar_size ),
            _x( 'Author', 'Used before post author name.', 'twentysixteen' ),
            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
            get_the_author()
        );
    }

    if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
        twentysixteen_entry_date();
    }

    $format = get_post_format();
    if ( current_theme_supports( 'post-formats', $format ) ) {
        printf( '<span class="entry-format">%1$s<a href="%2$s">%3$s</a></span>',
            sprintf( '<span class="screen-reader-text">%s </span>', _x( 'Format', 'Used before post format.', 'twentysixteen' ) ),
            esc_url( get_post_format_link( $format ) ),
            get_post_format_string( $format )
        );
    }

    if ( 'post' === get_post_type() ) {
        twentysixteen_entry_taxonomies();
    }

    if ( ! is_singular() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
        echo '<span class="comments-link">';
        comments_popup_link( sprintf( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'twentysixteen' ), get_the_title() ) );
        echo '</span>';
    }

    echo '<span>' . the_views() . '</span>';
}

/* comment_mail_notify v1.0 by willin kan. */
function comment_mail_notify($comment_id) {
    $comment = get_comment($comment_id);
    $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
    $spam_confirmed = $comment->comment_approved;
    if (($parent_id != '') && ($spam_confirmed != 'spam')) {
        $wp_email = 'no-reply@zengxiaoluan.com'; //e-mail 发出点, no-reply 可改为可用的 e-mail.
        $to = trim(get_comment($parent_id)->comment_author_email);
        $subject = '您在 [' . get_option("blogname") . '] 的留言有了回复';
        $message = '<p>' . trim(get_comment($parent_id)->comment_author) . ', 您好!</p>
            <p><strong>您曾在《' . get_the_title($comment->comment_post_ID) . '》的留言:</strong><br />'
            . trim(get_comment($parent_id)->comment_content) . '</p>
            <p><strong>' . trim($comment->comment_author) . ' 给您的回复:</strong><br />'
            . trim($comment->comment_content) . '<br /></p>
            <p>您可以点击 <a href="' . htmlspecialchars(get_comment_link($parent_id)) . '" target="_blank">查看回复完整內容</a></p>
            <p><a href="'. get_option( 'siteurl' ) .'" target="_blank">' . get_option('blogname') . '</a></p>
            <p>(此邮件由系统自动发送，请勿回复.)</p>';
        $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
        $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
        wp_mail( $to, $subject, $message, $headers );
    }
}
add_action('comment_post', 'comment_mail_notify');