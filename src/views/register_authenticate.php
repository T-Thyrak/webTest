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
?>

<?php
    $username = $_POST['username'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $class = $_POST['class'];
    $password = $_POST['password'];
    $confpassword = $_POST['password'];
    
    function check(string $username, string $class, string $password, string $confpassword): int {
        $fluent = $GLOBALS['f'];

        $fail_reason = 0;
    
        if (hash('sha256', $password) !== hash('sha256', $confpassword)) {
            $fail_reason = 1;
            return $fail_reason;
        }
    
        $userdata = $fluent->from('users')
            ->select('name')
            ->where('name', $username)
            ->fetch();
        
        if ($userdata !== false) {
            $fail_reason = 2;
            return $fail_reason;
        }

        # match regex
        $regex = "/(?=(?:.*\d.*))(?=(?:.*[A-Z].*))(?=(?:.*[a-z].*))(?=(?:.*[\[\-!\\\"§$%&\/()=?+*~#'_:.,;@^\]].*))^.{8,}$/";

        if (!preg_match($regex, $password)) {
            $fail_reason = 3;
            return $fail_reason;
        }

        if (strlen($username) > 200) {
            $fail_reason = 4;
            return $fail_reason;
        }

        if (strlen($class) > 50) {
            $fail_reason = 5;
            return $fail_reason;
        }

        return $fail_reason;
    }

    function register(string $username, string $gender, string $class, string $password, string $email, string $confpassword): void {
        $check_err = check($username, $class, $password, $confpassword);

        if ($check_err === 0) {
            $fluent = $GLOBALS['f'];

            $salt = generateRandomSaltString(32);
            $hash = hash('sha256', $password.$salt);

            # escape strings
            $username = $fluent->insertInto('users')
                ->values([
                    'name' => $username,
                    'email' => $email,
                    'gender' => $gender,
                    'class' => $class,
                    'salt' => $salt,
                    'hash' => $hash,
                ])
                ->execute();
            
            show_alert(0);
        } else {
            show_alert($check_err);
        }
    }

    
    function show_alert(int $error_code): void {
        $get_tr = function($v) {
            return $GLOBALS['tr']->get($v);
        };

        echo '<script>';
        switch ($error_code) {
            case 0:
                echo <<<EOT
                    Swal.fire({
                        title: "{$get_tr('success!')}",
                        text: "{$get_tr('register_success!')}\\nRedirecting back to login page...",
                        icon: 'success',
                        timer: 5000,
                    }).then(function() {
                        window.location.href = "../index.php";
                    });
                EOT;
                break;
            case 1:
                echo <<<EOT
                    Swal.fire({
                        title: "{$get_tr('error!')}",
                        text: "{$get_tr('reason.password_mismatch')}\\nRedirecting back to register page...",
                        icon: 'error',
                        timer: 5000,
                    }).then(function() {
                        window.location.href = "register.php";
                    });
                EOT;
                break;
            case 2:
                echo <<<EOT
                    Swal.fire({
                        title: "{$get_tr('error!')}",
                        text: "{$get_tr('reason.username_taken')}\\nRedirecting back to register page...",
                        icon: 'error',
                        timer: 5000,
                    }).then(function() {
                        window.location.href = "register.php";
                    });
                EOT;
                break;
            case 3:
                echo <<<EOT
                    Swal.fire({
                        title: "{$get_tr('error!')}",
                        text: "{$get_tr('reason.password_too_weak')}\\nRedirecting back to register page...",
                        icon: 'error',
                        timer: 5000,
                    }).then(function() {
                        window.location.href = "register.php";
                    });
                EOT;
                break;
            case 4:
                echo <<<EOT
                    Swal.fire({
                        title: "{$get_tr('error!')}",
                        text: "{$get_tr('reason.name_too_long')}\\nRedirecting back to register page...",
                        icon: 'error',
                        timer: 5000,
                    }).then(function() {
                        window.location.href = "register.php";
                    });
                EOT;
                break;
            case 5:
                echo <<<EOT
                    Swal.fire({
                        title: "{$get_tr('error!')}",
                        text: "{$get_tr('reason.class_too_long')}\\nRedirecting back to register page...",
                        icon: 'error',
                        timer: 5000,
                    }).then(function() {
                        window.location.href = "register.php";
                    });
                EOT;
                break;
            default:
                echo <<<EOT
                    Swal.fire({
                        title: "{$get_tr('error!')}",
                        text: "{$get_tr('reason.unknown')}\\nRedirecting back to register page...",
                        icon: 'error',
                        timer: 5000,
                    }).then(function() {
                        window.location.href = "register.php";
                    });
                EOT;
                break;
        }
        echo '</script>';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>=>></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="../resources/css/common.css">
</head>
<body>
    <?php
        register($username, $gender, $class, $password, $email, $confpassword);
    ?>
</body>
</html>