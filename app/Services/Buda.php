<?php 

namespace App\Services;

use Swagger\Client\Api\DefaultApi as BudaApi;
use GuzzleHttp\Client;
use Swagger\Client\Configuration;
class Buda {

    private $instance;
    private $timestamp;
    private $apikey;
    private $secret;
    private $configuration;
    public function __construct(){
        $this->configuration = new Configuration();
        $this->configuration->setHost("https://www.buda.com");
        $this->instance = new BudaApi(new Client(['verify' => false ]), $this->configuration);
        $this->timestamp = time();
        $this->apikey = 'e186650494b44921e23adf1c5a7f634b';
    }
    public function getMarkets(){
        return $this->instance->apiV2MarketsGet();
    }
    public function getBalance(){
        
        $x_sbtc_apikey = $this->apikey;
        $x_sbtc_nonce = $this->timestamp;
        $x_sbtc_signature = hash_hmac("sha384","GET /api/v2/balances ".$this->timestamp,$this->secret,true);
        return $this->instance->apiV2BalancesGet($x_sbtc_apikey, $x_sbtc_nonce, $x_sbtc_signature);
    }
    public function getTicker(){
        return $this->instance->apiV2MarketsMarketIdTickerGet();
    }


    
}