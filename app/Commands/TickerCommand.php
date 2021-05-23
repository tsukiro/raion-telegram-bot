<?php

namespace App\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use App\Services\Buda;
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
        // This will send a message using `sendMessage` method behind the scenes to
        // the user/chat id who triggered this command.
        // `replyWith<Message|Photo|Audio|Video|Voice|Document|Sticker|Location|ChatAction>()` all the available methods are dynamically
        // handled when you replace `send<Method>` with `replyWith` and use the same parameters - except chat_id does NOT need to be included in the array.
        $this->replyWithMessage(['text' => 'Rescatando los datos de Buda.com:']);
        
        // This will update the chat status to typing...
        $this->replyWithChatAction(['action' => Actions::TYPING]);
        
        $buda = new Buda();
        list($ticker,$status,$header) = $buda->getTicker("btc-clp");
        $this->replyWithMessage(['text' => 'BitCoin a CLP ']);
        $this->replyWithMessage(['text' => $ticker->ticker->last_price[0].$ticker->ticker->last_price[1]]);
        list($ticker,$status,$header) = $buda->getTicker("eth-clp");
        $this->replyWithMessage(['text' => 'Etherium a CLP ']);
        $this->replyWithMessage(['text' => $ticker->ticker->last_price[0].$ticker->ticker->last_price[1]]);
    }
}