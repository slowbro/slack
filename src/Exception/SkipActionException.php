<?php namespace Slowbro\Slack\Exception;

class SkipActionException extends \Exception {

    public function __construct($message = "SkipAction called."){
        parent::__construct($message);
    }

}
