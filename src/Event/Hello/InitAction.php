<?php namespace Slowbro\Slack\Event\Hello;

use \Slowbro\Slack\Event\Action;

class InitAction extends Action {

    public function run(){
        $logger = $this->slack->getLogger();
        $logger->info("Logged in to Slack!");
        $logger->info("Welcome to ".$this->state->team->name."!");
    }

}
