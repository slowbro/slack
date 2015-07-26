<?php namespace \Slowbro\Slack\Obj;

class ImObj extends \Slowbro\Slack\Base\Room {

    public $id;
    public $user;
    public $is_im = true;
    public $created;
    public $is_user_deleted;

    public function open($userId){
        $slack = \Slowbro\Slack\Client::factory();
        $state = \Slowbro\Slack\State::getState();
        $res = $slack->execute('im.open',[
                'user' => $userId
            ]);
        $body = $res['body'];
        if(!$body['ok'])
            throw new \Exception("Unable to open IM channel with {$userId}: ".$body['error']);
        $this->update($body['channel']+['created'=>time(),'is_user_deleted'=>false]);
        $state->addIm($this);
        return true;
    }

    public function leave(){
        $slack = \Slowbro\Slack\Client::factory();
        $slack->execute('im.close', ['channel'=>$this->id]);
    }

}
