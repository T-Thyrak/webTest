<?php
    session_start();

    require_once "../../vendor/autoload.php";
    require_once '../controller/connect.php';

    use Envms\FluentPDO\Query;

    $pdo = new PDO($dsn_str, $_ENV['DB_USER'], $_ENV['DB_PASS']);
    $fluent = new Query($pdo);

    if (isset($_GET['lang'])) {
        $_SESSION['lang'] = array_key_exists($_GET['lang'], $translation_array) ? $_GET['lang'] : 'en';
    } else {
        if (!isset($_SESSION['lang'])) {
            $_SESSION['lang'] = 'en';
        }
    }

    $GLOBALS['tr'] = get_translation_handler($_SESSION['lang']);

    $failed = false;

    $username = $_POST['username'];
    $password = $_POST['password'];

    $userdata = $fluent->from('users')
        ->select('salt, hash')
        ->where('name', $username)
        ->fetch();
    
    if ($userdata === false) {
        $failed = true;
    }
    
    if (!$failed) {
        $salt = $userdata['salt'];
        $hash = $userdata['hash'];

        $hash_check = hash('sha256', $password.$salt);

        if ($hash_check !== $hash) {
            $failed = true;
        }
    }

    if ($failed) {
        header("Location: /src/index.php?failed=1");
    }
?>