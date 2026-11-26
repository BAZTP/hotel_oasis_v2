<?php

namespace Http\Forms;

use Core\Validator;

class ContactoForm extends BasicForm
{
	public function __construct(public array $attributes)
	{
		if (!Validator::string($attributes['nombre'])) {
			$this->errors['nombre'] = 'Please provide a valid name.';
		}

		if (!Validator::cedula($attributes['cedula'])) {
			$this->errors['cedula'] = 'Please provide a valid cedula.';
		}

		if (!Validator::email($attributes['email'])) {
			$this->errors['email'] = 'Please provide a valid email.';
		}

		if (!Validator::phone($attributes['telefono'])) {
			$this->errors['telefono'] = 'Please provide a valid phone number.';
		}

		if (!Validator::greaterThan($attributes['estado'], 0)) {
			$this->errors['estado'] = 'Please provide a valid state.';
		}

		if (!Validator::lessThan($attributes['estado'], 5)) {
			$this->errors['estado'] = 'Please provide a valid state.';
		}
	}
}
