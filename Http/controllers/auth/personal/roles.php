<?php
use Core\Database;

try {
    $db = Database::getInstance();
    $result = $db
        ->query(
            "SELECT PERS_ID, PERS_CED, PERS_NOM, PERS_APE FROM pers_personal"
        )
        ->fetchAll();
} catch (\Core\DatabaseException $e) {
    die($e->getMessage());
}
view('auth/personal/roles.view.php', [
    'head_title' => 'roles',
    'personal' => $result
]);
