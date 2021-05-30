<?php

namespace App\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use App\Services\Buda;
use App\Currency;
class TickerCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "ticker";

    /**
     * @var string Command Description
     */
    protected $description = "Get Ticker from Buda.com";

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $this->replyWithMessage(['text' => 'Rescatando los datos de Buda.com:']);
        $this->replyWithChatAction(['action' => Actions::TYPING]);

        $currencies = Currency::all();
        
        $buda = new Buda();

        foreach ($currencies as $currency){

            $ticker = $buda->getTicker($currency->currency_code);
            $chart = $buda->generateChartUrl($currency->currency_code);
            $this->replyWithMessage(['text' => $currency->description]);
            $this->replyWithMessage(['text' => $ticker->value."CLP"]);
            $this->replyWithChatAction(['action' => Actions::TYPING]);
            $this->replyWithMessage(["text" => '<a href="'.$chart.'">Chart</a>', "parsemode"=> "HTML"]);
        }
    }
}