<?php
    $root = dirname(dirname(dirname(__FILE__)));
    require_once $root . "/vendor/autoload.php";

    use Symfony\Component\Dotenv\Dotenv;

    $dotenv = new Dotenv();
    $dotenv->load($root . "/.env");

    $dsn_str = $_ENV['DRIVER'] . ':host=' . $_ENV['DB_HOST'] . ';port=' . $_ENV['DB_PORT'] . ';dbname=' . $_ENV['DB_NAME'];

    $_SESSION['dsn'] = $dsn_str;
?>