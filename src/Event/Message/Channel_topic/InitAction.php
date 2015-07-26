<?php namespace Slowbro\Slack\Event\Message\Channel_topic;

use \Slowbro\Slack\Event\Action;

class InitAction extends Action {

    protected $trigger = false;

    public function run(){
        echo $this->event->topic;
    }

}
