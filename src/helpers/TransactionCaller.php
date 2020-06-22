<?php

namespace Markvantage\Operation\Helpers;

use Exception;
use Markvantage\Operation\Operation;
use Illuminate\Support\Facades\DB;

class TransactionCaller extends Caller
{
    private $after_commit;
    // public function call(Operation $obj, string $method_name): void
    // {
    //     $value = $this->callMethod($obj, $method_name);
    //     $obj->result->set_value($value);
    // }

    public function call(Operation $obj, array $steps): void
    {
        $steps = array_change_key_case($steps, CASE_LOWER);
        $steps = $this->setAfterCommit($steps);

        DB::beginTransaction();
        try {
            Runner::run($obj, $steps);
            DB::commit();
            try {
                $this->afterCommit($obj);
            } catch (Exception $e) {
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function setAfterCommit($steps)
    {
        foreach ($steps as $key => $step) {
            if (array_key_exists('after_commit', $step)) {
                $this->after_commit = $step['after_commit'];
                unset($steps[$key]);
            }
        }

        return $steps;
    }

    private function afterCommit(Operation $obj): void
    {
        if (is_string($this->after_commit)) {
            $class = new AfterCommitCaller($obj, $this->after_commit);
            $class->call($obj, $this->after_commit);
        } elseif (is_array($this->after_commit)) {
            Runner::run($obj, $this->after_commit);
        }
    }
}
