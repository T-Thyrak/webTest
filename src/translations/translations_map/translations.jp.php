<?php
    $__tr_jp_dr = dirname(__FILE__);
    $translation = array(
        "login" => "ログイン",
        "username" => "ユーザー名",
        "password" => "パスワード",
        "submit" => "提出",
        "change_language" => "言語を変更",
        "no_account?" => "アカウントがありませんか？",
        "register_now" => "今すぐ登録",
        "registration_form" => "登録フォーム",
        "email" => "メールアドレス",
        "gender" => "性別",
        "male" => "男性",
        "female" => "女性",
        "other" => "その他",
        "class" => "教室",
        "confirm_password" => "パスワード確認",
        "*all_required" => "*: 指定されずの場合を除いて、すべてのフィールドが必須であります。",
        "submit_register" => "登録情報提出",
        "already_have_account?" => "アカウントがありますか？",
        "login_instead" => "ログインする",
        "cookies" => "このサイトを使用するには、Cookieの使用に同意したことになります。<br />トークンを使用した永続的なログインセッションを提供するためにCookieを使用し、非アクティブの30分後に削除されます。",
        "error!" => "エラー！",
        "success" => "成功！",
        "login_failed!" => "ログインに失敗しました！",
        "register_failed!" => "登録に失敗しました！",
        "register_success!" => "登録に成功しました！",
        "reason" => "理由: ",
        "reason.invalid_credentials" => "無効な認証情報です。",
        "reason.password_mismatch" => "パスワードが一致しません。",
        "reason.username_taken" => "ユーザー名は既に使用されています。",
        "reason.password_too_weak" => "パスワードが弱すぎます。<br />パスワードは少なくとも1大文字、1小文字、1数字、1特殊文字を含む必要があります。",
        "reason.name_too_long" => "名前が長すぎます。",
        "reason.class_too_long" => "教室名が長すぎます。",
        "reason.unknown" => "不明なエラーです。",
        "reenter_credentials" => "認証情報を再度入力してください。",
    );

    $file_content = gzcompress(serialize($translation), 9);

    if (!(file_exists($__tr_jp_dr."/translations/translations.jp.tr") && $file_content === file_get_contents($__tr_jp_dr."/translations/translations.jp.tr"))) {
        file_put_contents($__tr_jp_dr."/translations/translations.jp.tr", $file_content);
    }
?>