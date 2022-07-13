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

    if(!isset($_COOKIE['php-l4-token'])){
        header("Location: ../index.php");  
    }

    $token = $_COOKIE['php-l4-token'];

    //array or boolean of token_query
    $token_query = $fluent->from('tokens')
                    ->select('user_id')
                    ->where('token', $token)
                    ->fetch();

    if($token_query === false){
        header("Location: ../index.php");  
    }

    $json = file_get_contents('php://input');
    $obj = json_decode($json, true);

    if ($obj['u_id'] != $token_query['user_id']) {
        $resp = [
            'status' => '403',
            'data' => '',
        ];
    } else {
        $prod_name = $obj['pd_name'];
        $prod_price = $obj['pd_price'];
        $prod_qty = $obj['pd_qty'];

        $prod_query = $fluent->insertInto('products')
                            ->values([
                                'name' => $prod_name,
                                'amount' => $prod_qty,
                                'price' => $prod_price,
                                'user_id' => $obj['u_id'],
                            ]);
        $prod_query->execute();

        $resp = [
            'status' => '200',
            'data' => $obj,
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($resp);
?>