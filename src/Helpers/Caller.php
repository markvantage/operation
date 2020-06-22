<?php

namespace Markvantage\Operation\Helpers;

use Exception;
use Markvantage\Operation\Operation;

class Caller
{
    public function __construct(Operation $obj, string $method_name)
    {
        // $this->errors = [];
    }

    public function callMethod(Operation $obj, string $method_name)
    {
        echo "\n" . 'calling' . get_class($obj) . '@' . $method_name . ': ';
        try {
            return app()->call([$obj, $method_name], $obj->args);
        } catch (Exception $e) {
            $obj->result->add_error($e);
        }
        return;
    }

    public function evaluateStepResult(Operation $obj, $result): void
    {
        if (!is_null($result) && $result !== true) {
            $obj->result->add_error($result);
        }
    }
}
