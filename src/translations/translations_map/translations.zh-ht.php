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
        "cookies" => "使用本網站，即表示您同意我們使用 cookie。 我們使用 cookie 來提供帶有令牌的持久登錄會話，並將在 30 分鐘不活動後被刪除。",
        "error!" => "錯誤！",
        "success" => "成功！",
        "login_failed!" => "登錄失敗！",
        "register_failed!" => "註冊失敗！",
        "register_success!" => "註冊成功！",
        "reason" => "原因： ",
        "reason.invalid_credentials" => "無效的認證信息。",
        "reason.password_mismatch" => "密碼不匹配。",
        "reason.username_taken" => "用戶名已被使用。",
        "reason.password_too_weak" => "密碼太弱。<br />密碼必須包含至少 1 個大寫字母、1 個小寫字母、1 個數字和 1 個特殊字符。",
        "reason.name_too_long" => "名字太長。",
        "reason.class_too_long" => "課堂名太長。",
        "reason.unknown" => "未知的錯誤。",
        "reenter_credentials" => "請再次輸入認證信息。",
    );

    $file_content = gzcompress(serialize($translation), 9);

    if (!(file_exists($__tr_zh_ht_dr."/translations/translations.zh-ht.tr") && $file_content === file_get_contents($__tr_zh_ht_dr."/translations/translations.zh-ht.tr"))) {
        file_put_contents($__tr_zh_ht_dr."/translations/translations.zh-ht.tr", $file_content);
    }
?>