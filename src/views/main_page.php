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

    $user_id = $token_query['user_id'];

    $product_query = $fluent -> from('products')
                             -> select('id , name, amount, price')
                             -> where('user_id', $user_id)
                             ->fetchAll();

    $GLOBALS['product_query'] = $product_query;

    $fluent->update('tokens')
        ->set('last_updated', date('Y-m-d H:i:s', time() + 3600 * 5))
        ->where('token', $token)
        ->execute();

?>

<!DOCTYPE html>
<html lang="en"><head>
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

    <style>
        * {
            font-family: Comfortaa, sans-serif;
        }
    </style>

    <script class="init"> $(document).ready(() => { $('#example').DataTable(); }); </script>
</head><body>
    <div class="mx-auto w-75 p-3">
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Price</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $prod = $GLOBALS['product_query'];
                    foreach ($prod as $row) {
                        $price = sprintf("%.2f", $row['price']/100);

                        echo "<tr>";
                        echo "<td>".$row['id']."</td>";
                        echo "<td>".$row['name']."</td>";
                        echo "<td>".$row['amount']."</td>";
                        echo "<td>$".$price."</td>";
                        echo "<td><button class='btn btn-primary'><i class='bi bi-pencil-square'></i>&nbsp;&nbsp;Edit</button>&nbsp;&nbsp;<button class='btn btn-danger'><i class='bi bi-trash'></i>&nbsp;&nbsp;Delete</td>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</body></html>