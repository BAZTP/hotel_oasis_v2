<?php
use Core\Auth;
use Http\Forms\LoginForm;

$attributes = [
	'email' => $_POST['email'],
	'password' => $_POST['password']
];

$form = LoginForm::validate($attributes);

$signedIn = (new Auth())->try($attributes['email'], $attributes['password']);

if (!$signedIn) {
	$form->error('email', 'Invalid credentials.')->throw();
}

redirect('/auth');
