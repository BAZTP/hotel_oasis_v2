<?php

use Core\Database;
use Core\DatabaseException;
try {
	$db = Database::getInstance();
	$result = $db
		->query(
			"
            SELECT 
                * 
            FROM 
                pers_evaluacion_desempeno;
            "
		)
		->fetchAll();
} catch (DatabaseException $e) {
	die($e->getMessage());
}

view('/auth/evaluacion/index.view.php', [
	'head_title' => 'Evaluacion del desempeño',
    'evaluacion' =>$result
]);


