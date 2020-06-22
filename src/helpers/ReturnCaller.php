<?php

namespace Markvantage\Operation\Helpers;

use Markvantage\Operation\Operation;

class ReturnCaller extends Caller
{
    public function call(Operation $obj, string $method_name): void
    {
        $value = $this->callMethod($obj, $method_name);
        $obj->result->set_value($value);
    }
}
