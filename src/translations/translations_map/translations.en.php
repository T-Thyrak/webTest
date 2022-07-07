<?php
    $__tr_en_dr = dirname(__FILE__);
    $translation = array(
        "login" => "Login",
        "username" => "Username",
        "password" => "Password",
        "submit" => "Submit",
        "change_language" => "Change Language",
        "no_account?" => "Don't have an account yet?",
        "register_now" => "Register Now!"
    );

    $file_content = gzcompress(serialize($translation), 9);

    if (!(file_exists($__tr_en_dr."/translations/translations.en.tr") && $file_content === file_get_contents($__tr_en_dr."/translations/translations.en.tr"))) {
        file_put_contents($__tr_en_dr."/translations/translations.en.tr", $file_content);
    }
?>