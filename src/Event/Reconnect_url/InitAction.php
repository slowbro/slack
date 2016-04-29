<?php namespace Slowbro\Slack\Event\Reconnect_url;

use \Slowbro\Slack\Event\Action;

class InitAction extends Action {

    public function run(){
        //do nothing - https://api.slack.com/events/reconnect_url
        //The reconnect_url event is currently unsupported and experimental.
    }

}
