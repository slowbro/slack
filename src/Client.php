<?php namespace Slowbro\Slack;

use \Frlnc\Slack\Http\SlackResponseFactory;
use \Frlnc\Slack\Http\CurlInteractor;
use \Frlnc\Slack\Core\Commander;

class Client {

    public  static $eventdir;
    private static $slack;
    private static $apikey;

    private $interactor;
    private $commander;
    private $connection;
    private $logger;
    private $messageCounter = 1;

    protected function __construct($api_key, $event_dir){
        self::$apikey = $api_key;
        self::$eventdir = $event_dir;
        $this->interactor = new CurlInteractor;
        $this->interactor->setResponseFactory(new SlackResponseFactory);
        $this->commander = new Commander(self::$apikey, $this->interactor);
    }

    public static function factory($overwrite=false, $api_key=false, $event_dir=false){
        if(!self::$slack || $overwrite)
            self::$slack = new Client(($api_key?:self::$apikey), ($event_dir?:self::$eventdir));
        return self::$slack;
    }

    public function setLogger($logger){
        $this->logger = $logger;
    }

    public function getLogger(){
        return $this->logger;
    }

    public function setConnection($conn){
        $this->connection = $conn;
    }

    public function execute($cmd, $params=array()){
        return $this->commander->execute($cmd, $params)->toArray();
    }

    public function startRtm(){
        $rtm = $this->execute('rtm.start');
        $state = new State($rtm['body']);
        return $state->url;
    }

    public function send($message){
        $message += ['id'=>$this->messageCounter];
        $this->messageCounter++;
        return $this->connection->send(json_encode($message));
    }

    public function start(){
        $ws = self::$slack->startRtm();
        $loop = \React\EventLoop\Factory::create();
        $connector = new \Ratchet\Client\Factory($loop);
        $connector($ws)->then(
            function(\Ratchet\Client\WebSocket $conn) use ($slack){
                $slack->setConnection($conn);

                $conn->on("message", function($message){
                    $event = new Event;
                    $event->parse($message);
                });
            },
            function ($e) use ($loop, $logger){
                $logger->info("Could not connect: {$e->getMessage()}");
                $loop->stop();
            }
        );

        $loop->run();

    }

}
