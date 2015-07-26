<?php namespace Slowbro\Slack\Event\User_typing;

use \Slowbro\Slack\Event\Action;

class InitAction extends Action {

    public function run(){
        $user = $this->state->findUserById($this->event->user);
        $user->setLastTyping(time());
    }

}
