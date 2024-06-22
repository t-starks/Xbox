<?php

namespace TStark\Xbox\tasks;

use pocketmine\scheduler\AsyncTask;
use pocketmine\utils\Internet;

class GetInfoTask extends AsyncTask {

    const PlayerDB = "https://playerdb.co/api/player/xbox/";

    public function __construct(
        private string $gamertag,
        private $callback
    ){
        //Developer By T. Stark <3
     }
    
    public function onRun(): void
    {
        $url = self::PlayerDB . $this->gamertag;
        $result = Internet::getURL($url, 15);
        $this->setResult($result->getBody());
    }

    public function onCompletion(): void
    {
        $results = $this->getResult(); 
        ($this->callback)(0, json_decode($results, true));
    }
}
