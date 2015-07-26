<?php namespace Slowbro\Slack\Event\Message;

class InitAction extends BaseAction {

    public function run(){
        $logger = $this->slack->getLogger();
        $logger->info((string) $this->message);
    }

}
