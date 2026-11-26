<?php

namespace Http\Forms;

use Core\Validator;

class LoginForm extends BasicForm
{
	public function __construct(public array $attributes)
	{
		if (!Validator::email($attributes['email']) && !Validator::string($attributes['email'], 1)) {
			$this->errors['email'] = 'Please provide a valid email address or username.';
		}

		if (!Validator::string($attributes['password'])) {
			$this->errors['password'] = 'Please provide a valid password.';
		}
	}
}
