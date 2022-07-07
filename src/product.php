<?php    
session_start();

require '../vendor/autoload.php';

require_once 'translations/translations.php';
require_once 'translations/translations_handler.php';

use Envms\FluentPDO\Query;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../.env');

$dsn_str = $_ENV['DRIVER'] . ':host=' . $_ENV['DB_HOST'] . ';port=' . $_ENV['DB_PORT'] . ';dbname=' . $_ENV['DB_NAME'];

$pdo = new PDO($dsn_str, $_ENV['DB_USER'], $_ENV['DB_PASS']);
$fluent = new Query($pdo);

$GLOBALS['f'] = $fluent;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration-Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>
<body>
    <div class="container pt-5">       
            <div class="col-10 col-md-6 col-lg-4 m-auto">
                <div class="card border-5px shadow" >
                    <div class="card-body">
                    <h2 class="text-muted ms-1"> Register </h2>
                        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                        <label for="id">ID</label>
                            <input type="text" name="username" id=""  class="form-control my-4 py-2" placeholder="Input product id" required>
                        <label for="name">name</label>
                            <input type="name" name="name" id=""  class="form-control my-4 py-2" placeholder="Input product name">                            
                        <label for="user_id">User_Id</label>
                            <input type="text" name="user_id" id=""  class="form-control my-4 py-2" placeholder="Input your id" required>
                        <label for="amount">Amount</label>
                            <input type="number" name="Email" id=""  class="form-control my-4 py-2" placeholder="Input amount of product">                            
                        <label for="price">Price</label>
                            <input type="number" min="0.00" max="10000.00" step="0.01" name="price" id=""  class="form-control my-4 py-2" placeholder="Input the price" required>
                            <div class="text-center mt-3">
                                <button name="submit" class="btn btn-primary mb-3">
                                    Submit  <a href="Data.txt"></a></button>
                               
                                <br>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
       
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
  
</body>
</html>
<?php

?>
<?php
session_start();
//WRITE DATA INTO FILE
    if($_SERVER["REQUEST_METHOD"] == "POST");
    $file = fopen("product.txt", "a");
    fwrite($file, $_POST['id']."\n");
    fwrite($file, $_POST['name']."\n");
    fwrite($file, $_POST['user_id']."\n");
    fwrite($file, $_POST['amount']."\n");
    fwrite($file, $_POST['price']."\n");
    fclose($file);

     if(isset($_POST['submit'])){

        $_SESSION['id']       = $_POST['id'];
        $_SESSION['name']     = $_POST['name']; 
        $_SESSION['user_id']  = $_POST['user_id'];
        $_SESSION['amount']   = $_POST['amount'];
        $_SESSION['price']    = ($_POST['price']);

        header("Location: info.php");        

     }   
?>
