<?php
    $__tr_en_dr = dirname(__FILE__);
    $translation = array(
        "login" => "Login",
        "username" => "Username",
        "password" => "Password",
        "submit" => "Submit",
        "change_language" => "Change Language",
        "no_account?" => "Don't have an account yet?",
        "register_now" => "Register Now!",
        "registration_form" => "Registration Form",
        "email" => "Email",
        "gender" => "Gender",
        "male" => "Male",
        "female" => "Female",
        "other" => "Other",
        "class" => "Class",
        "confirm_password" => "Confirm Password",
        "*all_required" => "*: All fields are required unless specified",
        "submit_register" => "Submit Register",
        "already_have_account?" => "Already have an account?",
        "login_instead" => "Login Instead",
        "cookies" => "By using this website, you agree to our use of cookies.<br>We use cookies to provide persistent login sessions with tokens, and will be deleted in 30 minutes of inactivity.",
        "error!" => "Error!",
        "login_failed!" => "Login Failed!",
        "register_failed!" => "Registration Failed!",
        "reason" => "Reason(s): ",
        "reason.invalid_credentials" => "Invalid credentials.",
        "reenter_credentials" => "Re-enter credentials",
    );

    $file_content = gzcompress(serialize($translation), 9);

    if (!(file_exists($__tr_en_dr."/translations/translations.en.tr") && $file_content === file_get_contents($__tr_en_dr."/translations/translations.en.tr"))) {
        file_put_contents($__tr_en_dr."/translations/translations.en.tr", $file_content);
    }
?>