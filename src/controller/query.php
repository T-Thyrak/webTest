<?php
    require $_SERVER["DOCUMENT_ROOT"] . "/vendor/autoload.php";

    use Envms\FluentPDO\Query;

    function get_all_users(Query $fluent): array {
        $q = $fluent->from('users')->fetchAll();
        return $q;
    }
?>