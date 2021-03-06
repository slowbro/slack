<?php namespace Slowbro\Slack\Obj;

use \Slowbro\Slack\State;

class UserObj extends \Slowbro\Slack\Base\Obj {

    public $id;
    public $name;
    public $deleted;
    public $color;
    public $profile = [];
    public $is_admin;
    public $is_owner;
    public $is_primary_owner;
    public $is_restricted;
    public $is_ultra_restricted;
    public $has_files;

    public $presence;

    public $last_typing;
    public $last_presence_change;

    public function setPresence($presence){
        $this->presence = $presence;
        $this->last_presence_change = time();
    }

    public function setLastTyping($time){
        $this->last_typing = $time;
    }

    public function im($text){
        $state = State::getState();
        $im = $state->findImByUser($this->id);
        if(!$im){
            $im = new ImObj;
            $im->open($this->id);
        }
        $im->message($text);
    }

}
