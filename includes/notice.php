<?php 

/* 1.Redefine user notification function ---start--- */
if ( !function_exists('wp_new_user_notification') ) {
    function wp_new_user_notification( $user_id, $plaintext_pass = '' ) {
        $user = new WP_User($user_id);
  
        $user_login = stripslashes($user->user_login);
        $user_email = stripslashes($user->user_email);
  
        $message  = sprintf( __( '有新用户注册，在你的网站---%s:', 'zengxiaoluan' ), get_option('blogname') ) . "rnrn";
        $message .= sprintf( __( '用户名: %s', 'zengxiaoluan' ), $user_login ) . "rnrn";
        $message .= sprintf( __( '邮件: %s', 'zengxiaoluan' ), $user_email ) . "rn";
  
        @wp_mail(get_option('admin_email'), sprintf( __( '[%s] 新用户注册', 'zengxiaoluan' ), get_option('blogname')), $message);
  
        if ( empty($plaintext_pass) )
            return;
  
        $message  = __( '你好,', 'zengxiaoluan') . "rnrn";
        $message .= sprintf( __( "欢迎来到 %s! 在这里登录：" , 'zengxiaoluan' ), get_option('blogname')) . "rnrn";
        $message .= wp_login_url() . "rn";
        $message .= sprintf( __( '用户名: %s', 'zengxiaoluan' ), $user_login) . "rn";
        $message .= sprintf( __( '密码: %s', 'zengxiaoluan' ), $plaintext_pass) . "rnrn";
        $message .= sprintf(__( '如果你遇到了什么问题, 请联系这个邮箱： %s.', 'zengxiaoluan' ), get_option('admin_email')) . "rnrn";
        $message .= __( 'Adios!', 'zengxiaoluan' );
  
        wp_mail($user_email, sprintf( __( '[%s] Your username and password', 'zengxiaoluan' ), get_option('blogname') ), $message);
  
    }
}
/* Redefine user notification function ---end--- */

/* 2.comment_mail_notify v1.0 by willin kan. ---start--- */
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
/* comment_mail_notify v1.0 by willin kan. ---end--- */

/* 3.修复WordPress找回密码提示“抱歉，该key似乎无效”问题 ---start--- */
function reset_password_message( $message, $key ) {
    if ( strpos($_POST['user_login'], '@') ) {
        $user_data = get_user_by('email', trim($_POST['user_login']));
    } else {
        $login = trim($_POST['user_login']);
        $user_data = get_user_by('login', $login);
    }
    $user_login = $user_data->user_login;
    $msg .= __( "亲亲小乱提醒您：", 'zengxiaoluan' );
    $msg .= __( '有人要求重设如下帐号的密码：', 'zengxiaoluan' ). "\r\n\r\n";
    $msg .= network_site_url() . "\r\n\r\n";
    $msg .= sprintf(__( '用户名：%s', 'zengxiaoluan' ), $user_login) . "\r\n\r\n";
    $msg .= __( '若这不是您本人要求的，请忽略本邮件，一切如常。', 'zengxiaoluan' ) . "\r\n\r\n";
    $msg .= __( '要重置您的密码，请打开下面的链接：', 'zengxiaoluan' ). "\r\n\r\n";
    $msg .= network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') ;
    return $msg;
}
add_filter('retrieve_password_message', 'reset_password_message', 10, 2);
/* 修复WordPress找回密码提示“抱歉，该key似乎无效”问题 ---end--- */