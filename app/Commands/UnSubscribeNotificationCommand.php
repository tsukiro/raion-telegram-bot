<?php

namespace App\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use App\Services\Buda;
use App\Subscription;
class UnSubscribeNotificationCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "unsubscribemetonotifications";

    /**
     * @var string Command Description
     */
    protected $description = "Command for unsuscribe your chat to periodically messages (For now Ticker)";

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $this->replyWithMessage(['text' => 'Verificando subscripción...']);
        $this->replyWithChatAction(['action' => Actions::TYPING]);

        $chat_id = $this->getUpdate()->getMessage()->getFrom()->getId();
        $subscription = Subscription::where("chat_id",$chat_id)->first();
        if ($subscription){
            $subscription->remove();
            $this->replyWithMessage(['text' => "Hemos removido tu chat al sistema de notificaciones, recuerda que si deseas subscribir tu chat puedes utilizar el comando /subscribemetonotifications "]);
        }else{
            $this->replyWithMessage(['text' => "Ya no estás subscrito a las notificaciones, si deseas subscribir tu chat nuevamente utiliza el comando /subscribemetonotifications "]);
        }
    }
}