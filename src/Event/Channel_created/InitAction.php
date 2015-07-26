<?php namespace Slowbro\Slack\Event\Channel_created;

use \Slowbro\Slack\Event\Action;

class InitAction extends Action {

    protected $trigger = false;

    public function run(){
        $channel = $this->state->addChannel($this->event->asJson());
        $this->slack->logger->info("New channel created: {$channel->name}");
    }

}
