<?php namespace Slowbro\Slack\Event\Team_join;

use \Slowbro\Slack\Event\Action;

class InitAction extends Action {

    public function run(){
        $new_user = $this->event->user;
        $logger = $this->slack->getLogger();
        $this->state->addUser((array)$new_user);
        $logger->info("{$new_user->name} has joined the team!");
    }

}
