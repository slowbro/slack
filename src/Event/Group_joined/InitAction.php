<?php namespace Slowbro\Slack\Event\Group_joined;

use \Slowbro\Slack\Event\Action;

class InitAction extends Action {

    public function run(){
        $group = $this->event->channel;
        $this->state->addGroup($group);
    }

}
