<?php
    $__tr_jp_dr = dirname(__FILE__);
    $translation = array(
        "login" => "ログイン",
        "username" => "ユーザー名",
        "password" => "パスワード",
        "submit" => "提出",
        "change_language" => "言語を変更",
        "no_account?" => "アカウントがありませんか？",
        "register_now" => "今すぐ登録"
    );

    $file_content = gzcompress(serialize($translation), 9);

    if (!(file_exists($__tr_jp_dr."/translations/translations.jp.tr") && $file_content === file_get_contents($__tr_jp_dr."/translations/translations.jp.tr"))) {
        file_put_contents($__tr_jp_dr."/translations/translations.jp.tr", $file_content);
    }
?>