<?php

namespace Http\Forms;

use Core\ValidationException;

class BasicForm
{
	protected $errors = [];
	protected $success = '';

	public function __construct(public array $attributes)
	{
	}

	public static function validate($attributes)
	{
		$instance = new static($attributes);

		return $instance->failed() ? $instance->throw() : $instance;
	}

	public function failed(): int
	{
		return count($this->errors);
	}

	/**
	 * @throws ValidationException
	 */
	public function throw(): void
	{
		ValidationException::throw($this->getErrors(), $this->attributes, $this->getSuccess());
	}
	public function error($field, $message): static
	{
		$this->errors[$field] = $message;

		return $this;
	}

	public function getErrors(): array
	{
		return $this->errors;
	}

	public function getSuccess(): string
	{
		return $this->success;
	}

	public function success($message): void
	{
		$this->success = $message;
	}
}
