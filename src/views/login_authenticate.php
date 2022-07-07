<?php
    session_start();

    require_once "../../vendor/autoload.php";
    require_once '../controller/connect.php';

    use Envms\FluentPDO\Query;

    $pdo = new PDO($dsn_str, $_ENV['DB_USER'], $_ENV['DB_PASS']);
    $fluent = new Query($pdo);

    $username = $_POST['username'];
    $password = $_POST['password'];

    $userdata = $fluent->from('users')
        ->select('salt, hash')
        ->where('name', $username)
        ->fetch();
    
    if ($userdata === false) {
        echo "USER NOT FOUND";
        echo "<br />";
    } else {
        $salt = $userdata['salt'];
        $hash = $userdata['hash'];
    
        $hash_check = hash('sha256', $password.$salt);
    
        if ($hash_check === $hash) {
            echo "LOGIN SUCCESSFUL";
        } else {
            echo "LOGIN NOT SUCCESSFUL";
        }
    }
?>