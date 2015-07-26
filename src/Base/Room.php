<?php namespace \Slowbro\Slack\Base;

class eRoom extends Object {

    public $is_im = false;
    public $is_group = false;
    public $is_channel = false;

    public function message($text){
        $message = new \Slowbro\Slack\Object\MessageObject;
        return $message->setChannel($this->id)->setText($text)->send();
    }

}
