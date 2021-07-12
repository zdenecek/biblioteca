<?php

namespace App\Http\Controllers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{
    public function run(){

        //Artisan::call('schedule:run');
        Artisan::call('notify:overdue');
        Artisan::call('reservations:update');
    }

}
