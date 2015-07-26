<?php namespace \Slowbro\Slack\Object;

class GroupObject extends \Slowbro\Slack\Base\Room {

    public $id;
    public $name;
    public $is_group = true;
    public $created;
    public $creator;
    public $is_archived;

    public $members = [];
    public $topic = [];
    public $purpose = [];

    public function leave(){
        $slack = \Slowbro\Slack\Client::factory();
        $state = \Slowbro\Slack\State::getState();
        $ret = $slack->execute('groups.close', ['channel'=>$this->id]);
        $state->removeGroupById($this->id);
    }

}
