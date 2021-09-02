<?php 

namespace App\Services;

use Tsukiro\Client\Api\BudaApi;
use GuzzleHttp\Client;
use Tsukiro\Client\Configuration;
use App\TickerHistory;
use Illuminate\Support\Facades\Log;
use QuickChart;

class Buda {

    private $instance;
    private $apikey;
    private $secret;
    private $lastSavedPrices;
    public function __construct(){
        $this->instance = new BudaApi(new Client(['verify' => false ]));
        $this->apikey = 'e186650494b44921e23adf1c5a7f634b';
        $this->secret = '8SrDMf5W4/Vn9zMJ/Zu/1Hwof0V08LT8fr0cbfVW';
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
        $qc = new QuickChart(array(
            'width'=> 600,
            'height'=> 300,
        ));
        $qc->setConfig($this->generateChartConfig($currency_code));
        return $qc->getShortUrl();
    }
    private function getLastPrices($currency_code){
        return TickerHistory::where("currency_code",$currency_code)->orderBy('created_at', 'desc')->take($this->lastSavedPrices)->get()->groupBy(function($date) {
            //return Carbon::parse($date->created_at)->format('Y'); // grouping by years
            return Carbon::parse($date->created_at)->format('d'); // grouping by months;
        });
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
            "type" => 'line',
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
        return json_encode($chartConfig);
    }

}