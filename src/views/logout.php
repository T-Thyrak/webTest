<?php
    session_start();

    require_once "../../vendor/autoload.php";

    require_once "../controller/connect.php";

    require_once "../translations/translations.php";
    require_once "../translations/translations_handler.php";

    require_once "../controller/helper.php";

    use Envms\FluentPDO\Query;

    $pdo = new PDO($dsn_str, $_ENV['DB_USER'], $_ENV['DB_PASS']);
    $fluent = new Query($pdo);

    $GLOBALS['f'] = $fluent;

    if (isset($_GET['lang'])) {
        $_SESSION['lang'] = array_key_exists($_GET['lang'], $translation_array) ? $_GET['lang'] : 'en';
    } else {
        if (!isset($_SESSION['lang'])) {
            $_SESSION['lang'] = 'en';
        }
    }
    $GLOBALS['tr'] = get_translation_handler($_SESSION['lang']);

    if (!isset($_COOKIE['php-l4-token'])) {
        header("Location: ../index.php");  
    }

    $token = $_COOKIE['php-l4-token'];

    //check if exist
    $token_query = $fluent->from('tokens')
                        ->select('user_id')
                        ->where('token', $token)
                        ->fetch();

    if ($token_query === false) {
        header("Location: ../index.php");  
    }

    # remove token from db
    $fluent->delete('tokens')
           ->where('token', $token)
           ->execute();
    
    # remove token from cookie
    setcookie('php-l4-token', '', time() - 3600, '/');

    # redirect to index
    header("Location: ../index.php");
?>