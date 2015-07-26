<?php namespace Slowbro\Slack\Obj;

class TeamObj extends \Slowbro\Slack\Base\Obj {

    public $id;
    public $name;
    public $email_domain;
    public $domain;
    public $msg_edit_window_mins;
    public $over_storage_limit;
    public $prefs = [];

}
