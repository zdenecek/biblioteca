<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $fileName = $request->file('file')->getClientOriginalName();
        $path = $request->file('file')->storeAs(
            'images',
            $fileName,
            'public'
        );
        $path = Storage::url($path);
        Log::debug("Image uploaded at " . $path);
        return response()->json(['location'=> $path]);

    }
}
