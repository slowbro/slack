<?php namespace Slowbro\Slack\Event\Presence_change;

use \Slowbro\Slack\Event\Action;

class InitAction extends Action {

    public function run(){
        $user = $this->state->findUserById($this->event->user);
        if(!$user)
            throw new \Exception("presence_change: Unknown user: {$this->event->user}");
        $user->setPresence($this->event->presence);
    }

}
