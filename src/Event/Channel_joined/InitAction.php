<?php namespace Slowbro\Slack\Event\Channel_joined;

use \Slowbro\Slack\Event\Action;

class InitAction extends Action {

    public function run(){
        $channel = $this->event->channel;
        $this->state->addChannel($channel);
    }

}
