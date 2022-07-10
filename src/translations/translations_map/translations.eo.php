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
        "cookies" => "Uzante ĉi tiun retejon, vi konsentas pri nia uzo de kuketoj.<br />Ni uzas kuketojn por provizi konstantan ensalutan sesion kun ĵetonoj, kaj estos forigitaj post 30 minutoj da neaktiveco.",
        "error!" => "Eraro!",
        "success" => "Sukceso!",
        "login_failed" => "Ensaluto malsukcesis!",
        "register_failed!" => "Registrado malsukcesis!",
        "register_success!" => "Registrado sukcesis!",
        "reason" => "Kialo(j): ",
        "reason.invalid_credentials" => "Nevalida uzantnomo kaj/aŭ pasvorto.",
        "reason.password_mismatch" => "La pasvortoj ne kongruas.",
        "reason.username_taken" => "La uzantnomo estas jam uzita.",
        "reason.password_too_weak" => "La pasvorto estas tro malforta.<br />La pasvorto devas kongrui almenaŭ 1 majuskla litero, 1 minuskla litero, 1 numero, kaj 1 speciala signo.",
        "reason.name_too_long" => "La nomo estas tro longa.",
        "reason.class_too_long" => "La klaso estas tro longa.",
        "reason.unknown" => "Nekonata eraro.",
        "reenter_credentials" => "Reenigu akreditaĵojn",
    );

    $file_content = gzcompress(serialize($translation), 9);

    if (!(file_exists($__tr_eo_dr."/translations/translations.eo.tr") && $file_content === file_get_contents($__tr_eo_dr."/translations/translations.eo.tr"))) {
        file_put_contents($__tr_eo_dr."/translations/translations.eo.tr", $file_content);
    }
?>