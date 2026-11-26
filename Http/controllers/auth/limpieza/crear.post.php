<?php
    use Core\Database;
    use Core\DatabaseException;

    $attributes = [
        'tipo_habitaciones' => $_POST['tipo_habitaciones'],
        'tipo_personales' => $_POST['tipo_personales'],
        'initial_date' => $_POST['initial_date']
    ];
    foreach ($_POST as $key => $value) {
        if (str_contains($key, 'field_')) {
            $attributes['additional_fields'][$key] = $value;
        }
    }
    

    try {
        $db = Database::getInstance();
        $result = $db
            ->prepare(
            "
            INSERT INTO adm_lim_prog (HAB_ID, PERS_ID,LIM_PROG_FECH)
            VALUES (:tipo_habitaciones, :tipo_personales, :initial_date)
            "
        )
        ->bind (':tipo_habitaciones', $attributes['tipo_habitaciones'])
        ->bind (':tipo_personales', $attributes['tipo_personales'])
        ->bind (':initial_date', $attributes['initial_date'])
        
            ->execute($attributes);
    } catch (DatabaseException $e) {
        echo $e->getMessage();
    }
    redirect('/auth/limpieza');
?>