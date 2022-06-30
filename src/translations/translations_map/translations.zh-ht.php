<?php
    $translation = array(
        "login" => "登錄",
        "username" => "用戶名",
        "password" => "密碼",
        "submit" => "提交",
    );

    $file_content = gzcompress(serialize($translation), 9);

    if (!(file_exists("translations/translations_map/translations/translations.zh-ht.tr") && $file_content === file_get_contents("translations/translations_map/translations/translations.zh-ht.tr"))) {
        file_put_contents("translations/translations_map/translations/translations.zh-ht.tr", $file_content);
    }
?>