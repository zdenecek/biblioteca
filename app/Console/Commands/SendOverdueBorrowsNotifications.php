<?php

namespace App\Console\Commands;

use App\Helpers\Settings;
use App\Mail\BorrowExpired;
use App\Models\Borrow;
use App\Models\User;
use App\Notifications\OverdueBorrow;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class SendOverdueBorrowsNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notifications to users with overdue borrows';

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
     * @return
     */
    public function handle()
    {

        Log::channel('library')->info("Probíhá odesílání upomínek...");

        if(Settings::get(Settings::send_email_on_borrow_expiration) == false) {
            $this->info("Notifications are disabled");
            return 0;
        }

        $overdueBorrows = Borrow::query()
            ->where('returned', false)
            ->where('notification_sent', false)
            ->whereDate('borrowed_until', '<', now())
            ->get()
            ->groupBy('user_id');

        $counter = 0;

        $overdueBorrows->each(function ($borrows, $userId) use (&$counter) {
            $user = User::find($userId);
            $user->notify( new OverdueBorrow($borrows));

            $borrows->each(function ($borrow){
                $borrow->notification_sent = true;
                $borrow->save();
            });

            DB::table('emails')->insert(['to' => $user->email, 'at' => now()]);

            Log::channel('library')->info("Uživateli {$user->name} byla odeslána upomínka");
            $counter++;
        });

        $this->info("$counter emailů bylo odesláno!");
        return 0;
    }
}
