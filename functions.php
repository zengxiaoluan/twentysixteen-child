<?php 

/* include google gtag */
require_once get_stylesheet_directory() . '/includes/gtag.php';

/* include google adsense */
require_once get_stylesheet_directory() . '/includes/google-adsense.php';

// add social share buttons
require_once get_stylesheet_directory() . '/includes/share.php';

// See http://core.trac.wordpress.org/ticket/21307
add_filter( 'pre_option_link_manager_enabled', '__return_true' );

/* Automatic updates for All themes: */
add_filter( 'auto_update_theme', '__return_true' );

/* Automatic updates for All plugins: */
add_filter( 'auto_update_plugin', '__return_true' );

// enqueue scripts
add_action('wp_enqueue_scripts', 'enqueue_styles');

function enqueue_styles(){
    // load parent styles
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_script( 'child-script', get_stylesheet_directory_uri() . '/child.js', array('nprogress-script'), '2017-11-10', true );

    // load nprogress
    wp_enqueue_script( 'nprogress-script', get_stylesheet_directory_uri() . '/js/nprogress/nprogress.js', array(), '2017-11-10', true );
    wp_enqueue_style( 'nprogress-style', get_stylesheet_directory_uri() . '/js/nprogress/nprogress.css' );

}

// add back-to-top and beian number
add_action( 'twentysixteen_credits', 'add_beian_number');

function add_beian_number(){
    echo "<span class='site-title'>&copy;".date('Y-m-d', strtotime(get_userdata(1)->user_registered) ).' - '.date('Y-m-d')."</span>"; 
    echo "<span class='site-title'><a target='_blank' href='http://www.miibeian.gov.cn/state/outPortal/loginPortal.action'>湘ICP备16005159号-1</a></span>";
    echo "<span class='site-title'><a id='top' class='genericon-top' title='回到顶部'></a></span>";
}

// set revision time as one
add_filter( 'wp_revisions_to_keep', 'orange_revision_times', 10, 2 );

function orange_revision_times( $num, $post ) {
    return 1;
}

/**
 * Prints HTML with date information for current post.
 *
 * Create your own twentysixteen_entry_date() function to override in a child theme.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_entry_date() {
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

    if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
        $time_string = '<time title="published at" class="entry-date published" datetime="%1$s">%2$s</time>';
    }

    $time_string = sprintf( $time_string,
        esc_attr( get_the_date( 'c' ) ),
        get_the_date()
    );

    printf( '<span class="posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
        _x( 'Posted on', 'Used before publish date.', 'twentysixteen' ),
        esc_url( get_permalink() ),
        $time_string
    );
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

    printf( '<span title="%1$s"><time datetime="%3$s"></time>%2$s</span>', _x( 'last updated at' , 'twentysixteen' ), get_the_modified_date(), get_the_modified_date( 'c' ) );


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

    echo '<span>' . __( 'Views ', 'orange' ) . get_post_meta( get_the_ID(), 'views', true ) . '</span>';

}

// add custome SEO --- start
function SEO(){
    echo '<meta name="baidu_union_verify" content="9045564ee1cbe7e65c46204aba90391b">';

    // add qzone share source
    echo '<meta name="site" content="' . get_bloginfo('url') . '" />';

    if (is_home()) {
        $description = __( '“乱”是这个世界的本质，我看到了快乐和秩序。_曾小乱', 'zengxiaoluan' );
        $keywords = get_option('blogdescription').','.get_option('blogname');
    }else{
        $description = get_the_title();
        $keywords = get_the_tag_list();
        if (empty($keywords)) {
            $keywords = __( '“乱”是这个世界的本质，我看到了快乐和秩序。_曾小乱', 'zengxiaoluan' );
        }else{
            $keywords = preg_replace('/<a href=".*?" rel="tag">/i', ',', $keywords);
            $keywords = preg_replace('/<\/a>/i', '', $keywords);
            $keywords = trim($keywords,',');
        }
    }
    
    echo sprintf("<meta name='description' content='%s'><meta name='keywords' content='%s'>",$description,$keywords);

}
add_action( 'wp_head', 'SEO' );
// add custome SEO --- end
// 
add_filter('user_row_actions', function($actions, $user){
    $capability = (is_multisite())?'manage_site':'manage_options';
    if(current_user_can($capability)){
        $actions['login_as']    = '<a title="以此身份登陆" href="'.wp_nonce_url("users.php?action=login_as&users=$user->ID", 'bulk-users').'">以此身份登陆</a>';
    }
    return $actions;
}, 10, 2);

add_filter('handle_bulk_actions-users', function($sendback, $action, $user_ids){
    if($action == 'login_as'){
        wp_set_auth_cookie($user_ids, true);
        wp_set_current_user($user_ids);
    }
    return admin_url();
},10,3);
