<?php

namespace Markvantage\Operation;

use Markvantage\Operation\Helpers\Result;
use Markvantage\Operation\Helpers\Runner;
use Illuminate\Support\Facades\Validator;

abstract class Operation
{
    public $args;

    public $result;

    protected const RULES = [];

    protected const OPERATIONS = [];

    private function __construct(array $args)
    {
        $this->result = new Result();
        $this->args = array_intersect_key($args, static::RULES);
    }

    private function run($operations): void
    {
        Runner::run($this, $operations);
    }

    public static function handle($args)
    {
        $op = new static($args);
        $op->run(static::OPERATIONS);

        return $op->result;
    }

    // public function validate(): bool
    // {
    //     echo 'validating';
    //     if (empty(static::RULES)) {
    //         return true;
    //     }

    //     $validation = Validator::make(
    //         $this->args,
    //         static::RULES
    //     );

    //     if ($validation->fails()) {
    //         $errors = $validation->errors()->all();
    //         foreach ($errors as $error) {
    //             $this->result->add_error($error);
    //         }

    //         $this->evaluateStepResult(!$validation->fails());
    //     }

    //     return true;
    // }

    // public function callMethod(string $method_name)
    // {
    //     echo "\n" . 'calling' . static::class . '@' . $method_name . ': ';
    //     try {
    //         return app()->call([$this, $method_name], $this->args);
    //     } catch (Exception $e) {
    //         $this->result->add_error($e);
    //     }
    //     return;


    // $method = new ReflectionMethod($this, $method_name);
    // if ($method->isProtected()) {
    //     $method->setAccessible(true);
    // }

    // $params = $method->getParameters();

    // if (empty($params)) {
    //     return $method->invoke($this);
    // } else {
    //     $args = $this->resolveArgs($params);
    //     return $method->invokeArgs($this, $args);
    // }
    // }

    // private function resolveArgs($params)
    // {
    //     if (empty($params) || !is_array($params)) {
    //         return [];
    //     }

    //     $args = [];
    //     foreach ($params as $param) {
    //         $name = $param->getName();
    //         if (isset($this->args[$name])) {
    //             $args[$name] = $this->args[$name];
    //         } elseif ($param->isDefaultValueAvailable()) {
    //             $args[$name] = $param->getDefaultValue();
    //         } elseif ($di = app()->make($param->getType()->getName())) {
    //             $args[$name] = $di;
    //         } else {
    //             $args[$name] = null;
    //         }
    //     }
    //     return $args;
    // }
}
