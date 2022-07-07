<?php
    $__tr_eo_dr = dirname(__FILE__);
    $translation = array(
        "login" => "Ensalutaformo",
        "username" => "Uzantnomo",
        "password" => "Pasvorto",
        "submit" => "Ensendi",
        "change_language" => "Ŝanĝi lingvon",
        "no_account?" => "Ĉu vi ne havas konton?",
        "register_now" => "Registri nun!"
    );

    $file_content = gzcompress(serialize($translation), 9);

    if (!(file_exists($__tr_eo_dr."/translations/translations.eo.tr") && $file_content === file_get_contents($__tr_eo_dr."/translations/translations.eo.tr"))) {
        file_put_contents($__tr_eo_dr."/translations/translations.eo.tr", $file_content);
    }
?>