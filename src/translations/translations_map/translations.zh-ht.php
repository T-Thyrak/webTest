<?php
    $__tr_zh_ht_dr = dirname(__FILE__);
    $translation = array(
        "login" => "登錄",
        "username" => "用戶名",
        "password" => "密碼",
        "submit" => "提交",
        "change_language" => "更改語言",
        "no_account?" => "沒有帳戶？",
        "register_now" => "現在註冊",
        "registration_form" => "註冊表單",
        "email" => "電郵地址",
        "gender" => "性別",
        "male" => "男性",
        "female" => "女性",
        "other" => "其他",
        "class" => "課堂",
        "confirm_password" => "確認密碼",
        "*all_required" => "除非指定，否則所有字段都是必需的",
        "submit_register" => "提交註冊信息",
        "already_have_account?" => "已經有賬戶了？",
        "login_instead" => "改為登錄",
    );

    $file_content = gzcompress(serialize($translation), 9);

    if (!(file_exists($__tr_zh_ht_dr."/translations/translations.zh-ht.tr") && $file_content === file_get_contents($__tr_zh_ht_dr."/translations/translations.zh-ht.tr"))) {
        file_put_contents($__tr_zh_ht_dr."/translations/translations.zh-ht.tr", $file_content);
    }
?>