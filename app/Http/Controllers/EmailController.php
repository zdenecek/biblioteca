<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmailController extends Controller
{
    public function showDashboard()
    {
        $emails = DB::table('emails')->paginate(30);
        return view('admin.email.dashboard' , ['emails' => $emails]);
    }
}
