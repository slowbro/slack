<?php namespace Slowbro\Slack\Event\Message\Channel_join;

use \Slowbro\Slack\Event\Action;

class InitAction extends Action {

    public function run(){
        $channel = $this->state->findChannelById($this->event->channel);
        $channel->addMember($this->event->user);
        $logger = $this->slack->getLogger();
        $logger->info("({$channel->name}) {$this->event->text}");
    }

}
