<?php

// 添加验证码字段到评论表单
function add_comment_captcha() {
    $num1 = rand(0, 9);
    $num2 = rand(0, 9);

    echo '<p class="comment-form-captcha">
        <label for="captcha">验证码: ' . $num1 . ' + ' . $num2 . ' = ?<span class="required">*</span></label>
        <input type="hidden" name="num1" value="' . $num1 . '">
        <input type="hidden" name="num2" value="' . $num2 . '">
        <input type="text" required name="captcha" id="captcha" size="30">
    </p>';
}

add_action('comment_form_after_fields', 'add_comment_captcha');
add_action('comment_form_logged_in_after', 'add_comment_captcha');

// 验证验证码
function verify_comment_captcha($commentdata) {
    if (!isset($_POST['captcha']) || !isset($_POST['num1']) || !isset($_POST['num2'])) {
        wp_die('错误：请填写验证码。');
    }

    $sum = (int)$_POST['num1'] + (int)$_POST['num2'];
    $captcha = (int)$_POST['captcha'];

    if ($captcha !== $sum) {
        wp_die('错误：验证码不正确，请重试。');
    }

    return $commentdata;
}

add_filter('preprocess_comment', 'verify_comment_captcha');