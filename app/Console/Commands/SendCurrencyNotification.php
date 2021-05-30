<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Notifications;

class SendCurrencyNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:currency';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send currency notification to subscribed users - Telegram';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Notifications $notifications)
    {
        $notifications->sendCurrencyNotification();
    }
}
