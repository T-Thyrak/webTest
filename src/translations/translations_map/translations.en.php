<?php
    $translation = array(
        "login" => "Login",
        "username" => "Username",
        "password" => "Password",
        "submit" => "Submit",
        "change_language" => "Change Language",
    );

    $file_content = gzcompress(serialize($translation), 9);

    if (!(file_exists("translations/translations_map/translations/translations.en.tr") && $file_content === file_get_contents("translations/translations_map/translations/translations.en.tr"))) {
        file_put_contents("translations/translations_map/translations/translations.en.tr", $file_content);
    }
?>