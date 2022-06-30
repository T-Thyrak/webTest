<?php
    require '../vendor/autoload.php';
    
    require_once 'translations/translations_handler.php';

    require_once 'translations/translations_map/translations.en.php';
    require_once 'translations/translations_map/translations.eo.php';
    require_once 'translations/translations_map/translations.jp.php';
    require_once 'translations/translations_map/translations.zh-ht.php';

    $translation_array = array(
        "en" => new TranslationHandler(unserialize(gzuncompress(file_get_contents('translations/translations_map/translations/translations.en.tr')))),
        "eo" => new TranslationHandler(unserialize(gzuncompress(file_get_contents('translations/translations_map/translations/translations.eo.tr')))),
        "zh-ht" => new TranslationHandler(unserialize(gzuncompress(file_get_contents('translations/translations_map/translations/translations.zh-ht.tr')))),
        "jp" => new TranslationHandler(unserialize(gzuncompress(file_get_contents('translations/translations_map/translations/translations.jp.tr')))),
    );

    function get_translation_handler(?string $lang) {
        global $translation_array;
        if (!array_key_exists($lang, $translation_array) || $lang === null) {
            return $translation_array["en"];
        } else {
            return $translation_array[$lang];
        }
    }
?>