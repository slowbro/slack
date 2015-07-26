<?php namespace \Slowbro\Slack\Object;

class ChannelObject extends \Slowbro\Slack\Base\Room {

    public $id;
    public $name;
    public $is_channel = true;
    public $created;
    public $creator;
    public $is_archived;
    public $is_general;
    public $is_member;

    public $members = [];
    public $topic   = [];
    public $purpose = [];
    
    public function leave(){
        $slack = \Slowbro\Slack\Client::factory();
        $slack->execute('channels.leave', ['channel'=>$this->id]);
    }

    public function addMember($member_id){
        $this->members[] = $member_id;
        return true;
    }

}
