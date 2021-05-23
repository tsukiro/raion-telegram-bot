<?php 

namespace App\Services;

use Tsukiro\Client\Api\BudaApi;
use GuzzleHttp\Client;
use Tsukiro\Client\Configuration;
class Buda {

    private $instance;
    private $apikey;
    private $secret;
    public function __construct(){
        $this->instance = new BudaApi(new Client(['verify' => false ]));
        $this->apikey = 'e186650494b44921e23adf1c5a7f634b';
        $this->secret = '8SrDMf5W4/Vn9zMJ/Zu/1Hwof0V08LT8fr0cbfVW';
    }
    public function getMarkets(){
        return json_decode($this->instance->getMarkets()[0]);
    }
    public function getBalance(){
        $this->instance->setApiKey($this->apikey);
        $this->instance->setSecret($this->secret);
        return json_decode($this->instance->getBalances()[0]);
    }
    public function getTicker($market_id){
        return json_decode($this->instance->getTicker($market_id)[0]);
    }
}