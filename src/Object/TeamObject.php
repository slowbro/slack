<?php namespace \Slowbro\Slack\Object;

class TeamObject extends \Slowbro\Slack\Base\Object {

    public $id;
    public $name;
    public $email_domain;
    public $domain;
    public $msg_edit_window_mins;
    public $over_storage_limit;
    public $prefs = [];

}
