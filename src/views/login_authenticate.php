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

    $username = $_POST['username'];
    $password = $_POST['password'];

    $d = $fluent->from('users')
        ->select('id, salt, hash')
        ->where('name', $username)
        ->fetch();
    
    if ($d === false) {
        header("Location: ../index.php?failed=1");
    }

    $salt = $d['salt'];
    $hash = $d['hash'];

    $user_id = $d['id'];

    $hash_check = hash('sha256', $password . $salt);

    if ($hash_check !== $hash) {
        header("Location: ../index.php?failed=1");
    }

    # is the token cookie set, if not, create a new token
    $gt = generateRandomSaltString(64);
    if (!isset($_COOKIE['token'])) {
        $token = create_new_token( $fluent, $user_id, $gt);
        # expires in 30 minutes
        setcookie('php-l4-token', $token, time() + 1800, "/");
    }

    # if the token cookie is set, check if it is valid
    else {
        $token = $_COOKIE['php-l4-token'];
        $token_check = $fluent->from('tokens')
            ->select('token, last_updated')
            ->where('token', $token)
            ->fetch();
        if ($token_check === false) {
            $token = create_new_token($fluent, $user_id, $gt);
            # expires in 30 minutes
            setcookie('php-l4-token', $token, time() + 1800, "/");
        } else {
            $last_updated = $token_check['last_updated'];
            if (time() - $last_updated > 1800) {
                $token = create_new_token($fluent, $user_id, $gt);
                # expires in 30 minutes
                setcookie('php-l4-token', $token, time() + 1800, "/");
            }
        }
    }

    # update the last_updated field of the token
    $fluent->update('tokens')
        ->set('last_updated', date('Y-m-d H:i:s', time() + 3600 * 5))
        ->where('token', $token)
        ->execute();
    
    # redirect to main page
    // header("Location: main_page.php");

    echo "<button onclick='main_page.php'>Go to Main Page</button>";
?>