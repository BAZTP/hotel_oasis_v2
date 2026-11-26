<?php

namespace Core;

class ValidationException extends \Exception
{
    public $errors;
    public $old;
    public $success;

    public function __construct($message = 'The form failed to validate.', $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function throw($errors, $old, $success = '')
    {
        $instance = new static();
        $instance->errors = $errors;
        $instance->old = $old;
        $instance->success = $success;
        throw $instance;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getOld(): array
    {
        return $this->old;
    }

    public function getSuccess(): string
    {
        return $this->success;
    }
}