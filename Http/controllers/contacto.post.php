<?php
use Http\Forms\ContactoForm;
use Core\Database;

$attributes = [
    'nombre' => $_POST['nombre'],
    'cedula' => $_POST['cedula'],
    'telefono' => $_POST['telefono'],
    'email' => $_POST['email'],
    'estado' => $_POST['estado'],
    'direccion' => $_POST['direccion'] // Incluye el nuevo campo de dirección
];

$form = ContactoForm::validate($attributes);
$db = Database::getInstance();

$resp = $db
    ->prepare(
        '
        INSERT INTO mark_cliente (EST_CLI_ID, CLI_NOM, CLI_CED, CLI__NUM, CLI_EMAIL, direccion)
        VALUES (:estado, :nombre, :cedula, :telefono, :email, :direccion)
        '
    )
    ->bind(':estado', $attributes['estado'])
    ->bind(':nombre', $attributes['nombre'])
    ->bind(':cedula', $attributes['cedula'])
    ->bind(':telefono', $attributes['telefono'])
    ->bind(':email', $attributes['email'])
    ->bind(':direccion', $attributes['direccion'])
    ->execute();

if (!$resp) {
    $form->error('email', 'Error al registrar el cliente.')->throw();
}

header('Location: /contacto?success=true');
exit;
