<?php

namespace Markvantage\Operation\Helpers;

use Exception;
use Markvantage\Operation\Operation;


final class Runner
{
    private function __construct()
    {
    }

    public static function run(Operation $obj, $steps): void
    {
        if (!is_array($steps)) {
            throw new \Exception('Steps not found');
        }
        try {
            foreach ($steps as $op) {
                if ($obj->result->has_error()) {
                    break;
                }
                $op = array_change_key_case($op, CASE_LOWER);
                $step = array_key_first($op);
                $method = $op[$step];
                if (in_array($step, ['step', 'set', 'return', 'transaction'])) {
                    if ($step == 'step') {
                        $s = new StepCaller($obj, $method);
                        $s->call($obj, $method);
                    } elseif ($step == 'set') {
                        $s = new SetCaller($obj, $method);
                        $s->call($obj, $method);
                    } elseif ($step == 'return') {
                        $s = new ReturnCaller($obj, $method);
                        $s->call($obj, $method);
                    } elseif ($step == 'transaction') {
                        $s = new TransactionCaller($obj, '');
                        $s->call($obj, $method);
                    }
                } else {
                    throw new Exception('Invalid step: ' . $step);
                }
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }
}
