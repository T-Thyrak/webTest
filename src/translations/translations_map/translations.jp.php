<?php
    $translation = array(
        "login" => "ログイン",
        "username" => "ユーザー名",
        "password" => "パスワード",
        "submit" => "提出",
        "change_language" => "言語を変更",
    );

    $file_content = gzcompress(serialize($translation), 9);

    if (!(file_exists("translations/translations_map/translations/translations.jp.tr") && $file_content === file_get_contents("translations/translations_map/translations/translations.jp.tr"))) {
        file_put_contents("translations/translations_map/translations/translations.jp.tr", $file_content);
    }
?>