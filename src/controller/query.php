<?php
    require '../../vendor/autoload.php';

    use Envms\FluentPDO\Query;

    function get_all_users(Query $fluent): array {
        $q = $fluent->from('users')->fetchAll();
        return $q;
    }
?>