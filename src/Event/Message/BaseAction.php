<?php namespace Slowbro\Slack\Event\Message;

use \Slowbro\Slack\Event\Action;
use \Slowbro\Slack\Obj\MessageObj;
use \Slowbro\Slack\State;

class BaseAction extends Action {

    protected $message;
    protected $trigger = false;
    protected $regex = false;
    protected $matches = [];

    public function __construct($event){
        parent::__construct($event);
        $this->message = new MessageObj($this->event->asObject());
        if(
           ($this->trigger && ($this->message->getChannelType() !== MessageObj::TYPE_IM && preg_match("#^{$this->state->self->name}(:|,)?\s#i", $this->message->text) === 0)) || #check that we were directly triggered
            ($this->regex && (preg_match($this->regex, $this->getCleanText(), $this->matches) === 0)) #check that our regex matched
          ){
            throw new \Slowbro\Slack\Exception\SkipActionException;
        }
    }

    protected function getCleanText(){
        return preg_replace("#^{$this->state->self->name}(:|,)?\s+#i", '', $this->message->text);
    }

}
