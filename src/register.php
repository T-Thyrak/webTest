<?php
    include 'config.php';
    error_reporting(0);
    
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

    if (!isset($_GET['lang'])) {
        $_SESSION['lang'] = 'en';
    } else {
        $_SESSION['lang'] = array_key_exists($_GET['lang'], $translation_array) ? $_GET['lang'] : 'en';
    }

    $GLOBALS['tr'] = get_translation_handler($_SESSION['lang']);

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
                    <h2 class="text-muted ms-1"> SignUp </h2>
                        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                        <label for="username">User Name</label>
                            <input type="text" name="username" id=""  class="form-control my-4 py-2" placeholder="Username" required>

                        <label for="email">Email</label>
                            <input type="email" name="email" id=""  class="form-control my-4 py-2" placeholder="Email">                            
                            <div class="form-check form-check-inline">

                        <label for="gender">Gender</label><br>
                                <input class="form-check-input" type="radio" name="gender" id="female" value="Female" required />
                                <label class="form-check-label" for="female">Female</label>
        
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="male" value="Male" required/>
                                <label class="form-check-label" for="male">Male</label>
                            </div>
                            <br>

                        <label for="class">Major</label>
                            <input type="text" name="major" id=""  class="form-control my-4 py-2" placeholder="Major" required>

                        <label for="password">Password</label>
                            <input type="password" name="password" id=""  class="form-control my-4 py-2" placeholder="Password" required>
                            <div class="text-center mt-3">
                                <button name="submit" class="btn btn-primary mb-3">
                                    Submit  <a href="Data.txt"></a></button>
                               
                                <br>
                                Already have an account?
                                <a href="index.php" class="nav-link link-primary ">Login Here</a>
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
    $file = fopen("Data.txt", "a");
    fwrite($file, $_POST['username']."\n");
    fwrite($file, $_POST['gender']."\n");
    fwrite($file, $_POST['major']."\n");
    fwrite($file, $_POST['email']."\n");
    fwrite($file, $_POST['password']."\n");
    fclose($file);

     if(isset($_POST['submit'])){

        $_SESSION['username'] = $_POST['username'];
        $_SESSION['gender'] = $_POST['gender']; 
        $_SESSION['major'] = $_POST['major'];
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['password'] = md5($_POST['password']);

        header("Location: info.php");        

     }   
?>
