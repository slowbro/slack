<?php namespace Slowbro\Slack;

class Event {

    public $slack;
    public $init_time;

    private $data;
    private $_json;

    public function __construct(){
        $this->init_time = microtime(true);
        $this->slack  = Client::factory();
    }

    public function __set($name, $value){
        $this->data->$name = $value;
    }

    public function __get($name){
        if (property_exists($this->data, $name)) {
            return $this->data->$name;
        }
        return null;
    }

    public function __isset($name){
        return isset($this->data->$name);
    }

    public function __unset($name){
        unset($this->data->$name);
    }

    public function parse($messageJson){
        $this->_json = $messageJson;
        $logger = $this->slack->getLogger();
        $this->data = json_decode($messageJson);
        if(!$this->data){
            $logger->error("Received invalid message: $messageJson");
            return false;
        }

        if(!isset($this->data->type)){
            if($this->data->ok == false)
                var_dump($this->data);
            return true;
        }

        $suffix = ucfirst($this->data->type).(isset($this->data->subtype)?'/'.ucfirst($this->data->subtype):'');

        $internalDir = __DIR__.'/Event/'.$suffix;
        $eventDir = Client::$eventdir.'/'.$suffix;
        //$baseDir = \Yii::getAlias("@slackbot/components/Slack/Event/".ucfirst($this->data->type).(isset($this->data->subtype)?'/'.ucfirst($this->data->subtype):''));
        if(!file_exists($internalDir.'/InitAction.php')){
            $logger->debug("[internal] No actions for ".$this->data->type.(isset($this->data->subtype)?':'.$this->data->subtype:''));
            $logger->debug($messageJson);
            return false;
        } else {
            $class = "\Slowbro\Slack\Event\\".ucfirst($this->data->type).(isset($this->data->subtype)?'\\'.ucfirst($this->data->subtype):'')."\InitAction";
            try {
                $action = new $class($this);
                $action->run();
           } catch (Exception $e){
                $logger->info("Unhandled Exception of type ".get_class($e).": ".$e->getMessage());
            } finally {
                $action = null;
            }
        }

        # now do the rest
        # load the classes first so we can sort them...
        $classes = glob($eventDir."/*Action.php");
        $class_array = [];
        foreach($classes as $name){
            $name = str_replace($baseDir.'/', '', str_replace('.php','',$name));
            if(in_array($name,["DefaultAction"]))
                continue;
            $class = "Event\\".ucfirst($this->data->type)."\\$name";
            $class_array[] = ['class'=>$class,'sort'=>$class::$sort];
        }
        usort($class_array, function($a,$b){return $a['sort']-$b['sort'];});

        # run the sorted clases
        foreach($class_array as $ca){
            $class = $ca['class'];
            try {
                $action = new $class($this);
                $action->run();
            } catch (\Exception $e){
                if($e instanceof \Slowbro\Slack\Exception\StopProcessingException)
                    break;
                if($e instanceof \Slowbro\Slack\Exception\SkipActionException)
                    continue;
                $logger->info("$class Unhandled Exception of type ".get_class($e).": ".$e->getMessage());
            } finally {
                $action = null;
            }
        }
        return true;
    }

    private function channel_rename($event){
        $state = State::getState();
        $channel = $state->findChannelById($event->channel->id);
        $old_name = $channel->name;
        $channel->update((array)$event->channel);
    }

    public function asObject(){
        return $this->data;
    }

    public function asJson(){
        return $this->_json;
    }
}
