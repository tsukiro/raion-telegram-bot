<?php

namespace App\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use App\Services\Buda;
use App\Subscription;
class SubscribeNotificationCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "subscribemetonotifications";

    /**
     * @var string Command Description
     */
    protected $description = "Command for suscribe your chat to periodically messages (For now Ticker)";

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $this->replyWithMessage(['text' => 'Verificando subscripción...']);
        $this->replyWithChatAction(['action' => Actions::TYPING]);

        $chat_id = $this->getUpdate()->getMessage()->getFrom()->getId();
        $subscription = Subscription::where("chat_id",$chat_id)->first();
        if (!$subscription){
            $subscription = new Subscription;
            $subscription->chat_id = $chat_id;
            $subscription->name = "";
            $subscription->subscription_type = "General";
            $subscription->save();
            $this->replyWithMessage(['text' => "Hemos subscrito tu chat a las notificaciones, recuerda que si deseas desuscribir tu chat utiliza el comando /unsubscribemetonotifications "]);
        }else{
            $this->replyWithMessage(['text' => "Ya estás subscrito a las notificaciones, si deseas desuscribir tu chat utiliza el comando /unsubscribemetonotifications "]);
        }
    }
}