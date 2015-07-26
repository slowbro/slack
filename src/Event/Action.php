<?php namespace Slowbro\Slack\Event;

use Slowbro\Slack\Client;
use Slowbro\Slack\State;

class Action {

    protected $event;
    protected $slack;
    protected $state;
    public static $sort = 0;

    public function __construct($event){
        $this->event = $event;
        $this->slack = Client::factory();
        $this->state = State::getState();
    }

    public function run(){

    }

}
