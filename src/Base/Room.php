<?php namespace Slowbro\Slack\Base;

class Room extends Obj {

    public $is_im = false;
    public $is_group = false;
    public $is_channel = false;

    public function message($text){
        $message = new \Slowbro\Slack\Obj\MessageObj;
        return $message->setChannel($this->id)->setText($text)->send();
    }

}
