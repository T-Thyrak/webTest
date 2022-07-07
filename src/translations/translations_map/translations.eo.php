<?php
    $translation = array(
        "login" => "Ensalutaformo",
        "username" => "Uzantnomo",
        "password" => "Pasvorto",
        "submit" => "Ensendi",
        "change_language" => "Ŝanĝi lingvon",
    );

    $file_content = gzcompress(serialize($translation), 9);

    if (!(file_exists("translations/translations_map/translations/translations.eo.tr") && $file_content === file_get_contents("translations/translations_map/translations/translations.eo.tr"))) {
        file_put_contents("translations/translations_map/translations/translations.eo.tr", $file_content);
    }
?>