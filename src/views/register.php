<?php
    session_start();

    require_once "../../vendor/autoload.php";

    require_once "../controller/connect.php";

    require_once "../translations/translations.php";
    require_once "../translations/translations_handler.php";

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $GLOBALS['tr']->get("registration_form") ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="../resources/css/common.css">
    <link rel="stylesheet" href="../resources/css/register.css">
</head>
<body>
    <div class="c-viewport pt-5">
        <div class="c-center-parent col-10 col-md-6 col-lg-4 m-auto">
            <div class="c-child card border-5px shadow">
                <div class="change-lang">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="changeLangMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $GLOBALS['tr']->get("change_language") ?>
                        </button>
    
                        <div class="dropdown-menu" aria-labelledby="changeLangMenuButton">
                            <a href="register.php?lang=en" class="dropdown-item">English</a>
                            <a href="register.php?lang=eo" class="dropdown-item">Esperanto</a>
                            <a href="register.php?lang=zh-ht" class="dropdown-item">繁體中文</a>
                            <a href="register.php?lang=jp" class="dropdown-item">日本語</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <h2 class="register text-muted ms-1 text-center"><?php echo $GLOBALS['tr']->get("registration_form") ?></h2>
                    <h6 class="sub-notice text-muted ms-1 text-center"><?php echo $GLOBALS['tr']->get("*all_required") ?></h6>
                    <form action=<?php echo "register_authenticate.php?lang=$_SESSION[lang]" ?> method="post">
                        <label for="username"><?php echo $GLOBALS['tr']->get('username') ?></label>
                        <input type="text" name="username" id="f-username" class="form-control mb-4 py-2" placeholder=<?php echo $GLOBALS['tr']->get("username") ?> required>
                        
                        <label for="email"><?php echo $GLOBALS['tr']->get('email') ?></label>
                        <input type="email" name="email" id="f-email" class="form-control mb-4 py-2" placeholder=<?php echo $GLOBALS['tr']->get("email") ?> required>

                        <label for="gender"><?php echo $GLOBALS['tr']->get('gender') ?></label><br />
                        <div class="form-check form-check-inline mb-4">
                            <input type="radio" name="gender" id="f-gender-male" class="form-check-input" value="Male" required />
                            <label for="f-gender-male" class="form-check-label"><?php echo $GLOBALS['tr']->get("male") ?></label>
                        </div>

                        <div class="form-check form-check-inline mb-4">
                            <input type="radio" name="gender" id="f-gender-female" class="form-check-input" value="Female" required />
                            <label for="f-gender-female" class="form-check-label"><?php echo $GLOBALS['tr']->get("female") ?></label>
                        </div>

                        <div class="form-check form-check-inline mb-4">
                            <input type="radio" name="gender" id="f-gender-other" class="form-check-input" value="Other" required />
                            <label for="f-gender-other" class="form-check-label"><?php echo $GLOBALS['tr']->get("other") ?></label>
                        </div><br />

                        <label for="class"><?php echo $GLOBALS['tr']->get("class") ?></label>
                        <input type="text" name="class" id="f-class" class="form-control mb-4 py-2" placeholder=<?php echo $GLOBALS['tr']->get("class") ?> required>

                        <label for="password"><?php echo $GLOBALS['tr']->get('password') ?></label>
                        <input type="password" name="password" id="f-password" class="form-control mb-4 py-2" placeholder=<?php echo $GLOBALS['tr']->get("password") ?> required>

                        <label for="confirm-password"><?php echo $GLOBALS['tr']->get('confirm_password') ?></label>
                        <input type="password" name="confirm-password" id="f-confirm-password" class="form-control mb-4 py-2" placeholder=<?php echo "'".$GLOBALS['tr']->get("confirm_password")."'" ?> required>

                        <button type="submit" class="btn btn-primary btn-block mb-4"><?php echo $GLOBALS['tr']->get("submit_register") ?></button>
                    </form>

                    <h5 class="text-center text-muted ms-1">
                        <?php echo $GLOBALS['tr']->get("already_have_account?") ?>
                        <a href=<?php echo "../index.php?lang=$_SESSION[lang]" ?> class="text-primary"><?php echo $GLOBALS['tr']->get("login_instead") ?></a>
                    </h5>
                </div>
            </div>
        </div>
    </div>
</body>
</html>