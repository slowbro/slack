<?php namespace \Slowbro\Slack\Base;

class Object {

    public function __construct($itemArray=[]){
        if($itemArray)
            $this->update((array)$itemArray);
    }

    public function update($itemArray){
        foreach($itemArray as $key=>$value){
            if(property_exists($this, $key))
                $this->{$key} = $value;
        }
    }

}
