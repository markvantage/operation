<?php

namespace Markvantage\Operation\Helpers;

use Markvantage\Operation\Operation;

class SetCaller extends Caller
{
    public function call(Operation $obj, string $method_name): void
    {
        $ret = $this->callMethod($obj, $method_name);
        $this->evaluateStepResult($obj, $ret);
    }
}
