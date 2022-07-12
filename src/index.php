<?php
    session_start();

    require '../vendor/autoload.php';

    require_once 'translations/translations.php';
    require_once 'translations/translations_handler.php';

    require_once 'controller/connect.php';

    use Envms\FluentPDO\Query;

    $pdo = new PDO($dsn_str, $_ENV['DB_USER'], $_ENV['DB_PASS']);
    $fluent = new Query($pdo);

    if (isset($_GET['lang'])) {
        $_SESSION['lang'] = array_key_exists($_GET['lang'], $translation_array) ? $_GET['lang'] : 'en';
    } else {
        if (!isset($_SESSION['lang'])) {
            $_SESSION['lang'] = 'en';
        }
    }

    $GLOBALS['tr'] = get_translation_handler($_SESSION['lang']);

    if (isset($_COOKIE['php-l4-token'])) {
        header("Location: views/main_page.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $GLOBALS['tr']->get("login") ?></title>
    <!-- bootstrap yay -->
    <!-- CSS only -->
    <!-- JavaScript Bundle with Popper -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="resources/css/common.css">
    <link rel="stylesheet" href="resources/css/index.css">
</head>
<body>
    <div class="c-viewport">
        <div class="c-center-parent container d-flex justify-content-center align-items-center h-100 flex-column">
            <div class="c-child">
                <div class="change-lang">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="changeLangMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $GLOBALS['tr']->get("change_language") ?>
                        </button>

                        <div class="dropdown-menu" aria-labelledby="changeLangMenuButton">
                            <a href="index.php?lang=en" class="dropdown-item">English</a>
                            <a href="index.php?lang=eo" class="dropdown-item">Esperanto</a>
                            <a href="index.php?lang=zh-ht" class="dropdown-item">繁體中文</a>
                            <a href="index.php?lang=jp" class="dropdown-item">日本語</a>
                        </div>
                    </div>
                </div>

                <div class="c-header">
                    <h1>
                        <?php echo $GLOBALS['tr']->get('login') ?>
                    </h1>
                </div>

                <div class="c-form-wrapper">
                    <!-- form -->
                    <form action=<?php echo "views/login_authenticate.php?lang=$_SESSION[lang]"?> method="post">
                        <div class="form-group">
                            <label for="username"><?php echo $GLOBALS['tr']->get('username') ?></label>
                            <input type="text" class="form-control" id="username" name="username" placeholder=<?php echo $GLOBALS['tr']->get("username") ?>>
                        </div>
                        <div class="form-group">
                            <label for="password"><?php echo $GLOBALS['tr']->get('password') ?></label>
                            <input type="password" class="form-control" id="password" name="password" placeholder=<?php echo $GLOBALS['tr']->get("password") ?>>
                        </div>
                        <button type="submit" class="btn btn-primary" id="btn-submit"><?php echo $GLOBALS['tr']->get('submit') ?></button>
                        <div class="register">
                            <p><?php echo $GLOBALS['tr']->get("no_account?") . " <a href='views/register.php'>" . $GLOBALS['tr']->get("register_now") . "</a>" ?>
                        </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="c-footer text-center">
            <?php echo $GLOBALS['tr']->get("cookies") ?>
        </div>

    </div>

    <script>
        <?php
            $failed = isset($_GET['failed']) ? $_GET['failed'] : false;

            echo "let lg = ";
            if ($failed) {
                echo "false";
            } else {
                echo "true";
            }
            echo ";";
        ?>

        if (!lg) {
            Swal.fire({
                title: <?php echo "'".$GLOBALS['tr']->get("error!")."'"?>,
                text: <?php echo "'".$GLOBALS['tr']->get("login_failed!")."<br />".$GLOBALS['tr']->get("reason").$GLOBALS['tr']->get("reason.invalid_credentials")."'" ?>,
                icon: 'error',
                confirmButtonText: <?php echo "'".$GLOBALS['tr']->get("reenter_credentials")."'"?>
            })
        }
    </script>
</body>
</html>