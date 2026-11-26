<?php
    use Core\Database;
    use Core\DatabaseException;

    $attributes = [
        'tipo_servicios' => $_POST['tipo_servicios'],
        'detalleservicio' => $_POST['detalleservicio'],
        'descripcion' => $_POST['descripcion'],
        'initial_date' => $_POST['initial_date'],
        'costo' => $_POST['costo']
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
            INSERT INTO mark_prom_serv (TIP_SERV_ID,PROM_SERV_DET,PROM_SERV_DESC,PROM_SERV_FEC,PROM_SERV_COSTO)
            VALUES (:tipo_servicios, :detalleservicio, :descripcion, :initial_date, :costo)
            "
        )
        ->bind (':tipo_servicios', $attributes['tipo_servicios'])
        ->bind (':detalleservicio', $attributes['detalleservicio'])
        ->bind (':descripcion', $attributes['descripcion'])
        ->bind (':initial_date', $attributes['initial_date'])
        ->bind (':costo', $attributes['costo'])
        
            ->execute($attributes);
    } catch (DatabaseException $e) {
        echo $e->getMessage();
    }
    redirect('/auth/marketing');
    ?>