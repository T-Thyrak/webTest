<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/New_Folder/vendor/autoload.php";

    use Symfony\Component\Dotenv\Dotenv;

    $dotenv = new Dotenv();
    $dotenv->load($_SERVER["DOCUMENT_ROOT"] . "/New_Folder/.env");

    $dsn_str = $_ENV['DRIVER'] . ':host=' . $_ENV['DB_HOST'] . ';port=' . $_ENV['DB_PORT'] . ';dbname=' . $_ENV['DB_NAME'];

    $_SESSION['dsn'] = $dsn_str;
?>