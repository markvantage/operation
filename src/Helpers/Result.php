<?php

namespace Markvantage\Operation\Helpers;

class Result
{
    private $errors;
    private $value;

    public function __construct()
    {
        $this->errors = [];
    }


    public function errors()
    {
        return $this->errors;
    }

    public function has_error(): bool
    {
        return !empty($this->errors);
    }

    public function is_success(): bool
    {
        return !$this->has_error();
    }

    public function is_failure(): bool
    {
        return !$this->is_success();
    }

    public function value()
    {
        return $this->value;
    }

    public function add_error($error)
    {
        $this->errors[] = $error;
    }

    public function set_value($value)
    {
        $this->value = $value;
    }
}
