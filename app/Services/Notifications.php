<?php 

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Subscription;
use App\Currency;
use Telegram\Bot\Actions;
use App\Services\Buda;
use Telegram;
class Notifications  {
    const GENERAL = "General"; 
    public function sendCurrencyNotification(){

        $subscriptions = Subscription::where("subscription_type",self::GENERAL)->get();
        $currencies = Currency::all();
        $buda = new Buda();
        
        foreach ($currencies as $currency){
            $ticker = $buda->getTicker($currency->currency_code);
            $chart = $buda->generateChartUrl($currency->currency_code);
            foreach ($subscriptions as $subscription){
    
                Telegram::sendMessage(['text' => 'Rescatando los datos de Buda.com:']);
                Telegram::sendChatAction(['action' => Actions::TYPING]);
                Telegram::sendMessage([ "chat_id" => $subscription->chat_id, 'text' => $currency->description]);
                Telegram::sendMessage([ "chat_id" => $subscription->chat_id, 'text' => $ticker->value."CLP"]);
                Telegram::sendChatAction([ "chat_id" => $subscription->chat_id, 'action' => Actions::UPLOAD_PHOTO]);
                Telegram::sendMessage([ "chat_id" => $subscription->chat_id, "text" => $chart]);
            }
        }

    }

}