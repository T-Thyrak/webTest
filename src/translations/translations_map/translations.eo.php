<?php
    $__tr_eo_dr = dirname(__FILE__);
    $translation = array(
        "login" => "Ensalutaformo",
        "username" => "Uzantnomo",
        "password" => "Pasvorto",
        "submit" => "Ensendi",
        "change_language" => "Ŝanĝi lingvon",
        "no_account?" => "Ĉu vi ne havas konton?",
        "register_now" => "Registri nun!",
        "registration_form" => "Registriformularo",
        "email" => "Retpoŝtadreso",
        "gender" => "Sekso",
        "male" => "Viro",
        "female" => "Virino",
        "other" => "Alio",
        "class" => "Klaso",
        "confirm_password" => "Konfirmas Pasvorton",
        "*all_required" => "*: Ĉiuj kampoj estas postulataj krom se specifita",
        "submit_register" => "Ensendi Registri",
        "already_have_account?" => "Ĉu vi jam havas konton?",
        "login_instead" => "Ensaluti anstataŭe",
    );

    $file_content = gzcompress(serialize($translation), 9);

    if (!(file_exists($__tr_eo_dr."/translations/translations.eo.tr") && $file_content === file_get_contents($__tr_eo_dr."/translations/translations.eo.tr"))) {
        file_put_contents($__tr_eo_dr."/translations/translations.eo.tr", $file_content);
    }
?>