<?php 

namespace App\Services;

use Tsukiro\Client\Api\BudaApi;
use GuzzleHttp\Client;
use Tsukiro\Client\Configuration;
use App\TickerHistory;
use Illuminate\Support\Facades\Log;

class Buda {

    private $instance;
    private $apikey;
    private $secret;
    private $graphUrl;
    private $lastSavedPrices;
    public function __construct(){
        $this->instance = new BudaApi(new Client(['verify' => false ]));
        $this->apikey = 'e186650494b44921e23adf1c5a7f634b';
        $this->secret = '8SrDMf5W4/Vn9zMJ/Zu/1Hwof0V08LT8fr0cbfVW';
        $this->graphUrl = env("BUDA_GRAPH_URL","https://quickchart.io/chart?c=");
        $this->lastSavedPrices = env("BUDA_LAST_SAVED_PRICES",5);
    }
    public function getMarkets(){
        return $this->instance->getMarkets()[0];
    }
    public function getBalance(){
        $this->instance->setApiKey($this->apikey);
        $this->instance->setSecret($this->secret);
        return $this->instance->getBalances()[0];
    }
    public function getTicker($market_id){
        try {
            $budaTicker = $this->instance->getTicker($market_id)[0];
            $ticker = new TickerHistory();
            $ticker->value = $budaTicker->ticker->last_price[0];
            $ticker->currency_code = $market_id;
            $ticker->save();
            return $ticker;
        } catch (\Throwable $th) {
            Log::error("Error en ticker");
            Log::error($th);
        }
    }

    public function generateChartUrl($currency_code){
        return $this->graphUrl.$this->generateChartConfig($currency_code);
    }
    private function getLastPrices($currency_code){
        return TickerHistory::where("currency_code",$currency_code)->orderBy('created_at', 'desc')->take($this->lastSavedPrices)->get();
    }
    private function generateChartConfig($currency_code){
        $lastPrices = $this->getLastPrices($currency_code);
        $labels = array();
        $dataset = array();
        foreach($lastPrices as $lastPrice){
            $labels[] = $lastPrice->created_at->format("d-m-Y H:i");
            $dataset[] = $lastPrice->value;
        }

        $chartConfig = [
            "type" => 'bar',
            "data" => [
                "labels" => $labels,
                "datasets" => [
                    [
                        "label" =>$currency_code,
                        "data"  => $dataset 
                    ]
                ]
            ]
        ];
        return urlencode(json_encode($chartConfig));
    }

}