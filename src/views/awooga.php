<?php
    session_start();

    // header("Location: main_page.php");

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

    if($token_query === false){
        header("Location: ../index.php");  
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <title>wtf</title>
</head>
<body>
    <button onclick="sendSomeData()">
        Click ME!
    </button>

    <script>
        const sendSomeData = () => {
            var resp;

            let settings = {
                url: "http://localhost:20002/src/views/recv_data.php",
                method: "POST",
                timeout: 0,
                headers: {
                    "Content-Type": "application/json",
                },
                data: JSON.stringify({
                    "someData": 123,
                    "jsString": "someString",
                }),
                async: false,
                success: response => {
                    resp = response;
                }
            };

            console.log("preparing to send some data");

            $.ajax(settings);

            console.log(resp);

            window.location.href = ".";
        }
    </script>
</body>
</html>