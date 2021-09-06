<?php

namespace App\Http\Controllers;

use App\Helpers\Settings;
use App\Models\BookCollection;
use App\Models\BookSection;
use App\Models\Sticker;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    public function install()
    {
        if(Schema::hasTable('users')) return;
        Artisan::call('migrate:fresh --force --seed');
        Artisan::call('storage:link --force');
        return;
    }

    public function showDashboard()
    {
        return view("admin.dashboard");
    }

    public function showArtisan()
    {
        session()->keep('output');
        return view('admin.artisan');
    }

    public function postArtisan(Request $request)
    {
        define('STDIN',fopen("php://stdin","r"));
        $break = "&#13;&#10;";
        $output = session('output', '');
        $input = $request->get('input', '');
        try {
            $output .= '> > ' . $input . $break;
            Artisan::call($input);
            $output .= Artisan::output() . $break;
        }
        catch (Exception $e)
        {
            $output .= $e->getMessage() . $break;
        }
        return redirect()->route('admin.artisan')->with('output', $output);
    }

    public function showSettings()
    {
        $collections = BookCollection::all();
        $sections = BookSection::all();
        $stickers = Sticker::all();
        return view('admin.web_settings', [
            'collections' => $collections,
            'sections' => $sections,
            'stickers' => $stickers]);
    }

    public function editSettings(Request $request)
    {
        $request->validate([
            'borrow_time'  => 'required|lt:100',
            'reservation_time'  => 'required|lt:100',
            'send_email_on_borrow_expiration' => 'sometimes',
            Settings::contact_librarian => 'required|email'
        ]);

        Settings::set('borrow_time', $request->get('borrow_time'));
        Settings::set('reservation_time', $request->get('reservation_time'));
        Settings::set('send_email_on_borrow_expiration', $request->has('send_email_on_borrow_expiration'));
        Settings::set(Settings::contact_librarian, $request->get(Settings::contact_librarian));


        return redirect()
            ->back()
            ->with('notifications', [['type' => 'success', 'message' => "Nastavení bylo aktualizováno"]]);
    }
}
