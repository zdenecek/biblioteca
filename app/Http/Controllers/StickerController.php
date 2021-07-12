<?php

namespace App\Http\Controllers;

use App\Models\BookCollection;
use App\Models\BookSection;
use App\Models\Sticker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Pluralizer;
use Illuminate\Validation\Rule;

use function PHPSTORM_META\map;

class StickerController extends Controller
{

    public function showAddSticker()
    {
        return view('admin.sticker.add',  [
            'stickerables' => Sticker::getStickerablesWithData(),
        ]);
    }

    public function showEditSticker(Sticker $sticker)
    {
        return view('admin.sticker.edit',
        [
            'stickerables' =>  Sticker::getStickerablesWithData(),
            'sticker' => $sticker
        ]);
    }

    public function editSticker(Request $request, Sticker $sticker)
    {
		$stickerables =  Sticker::getStickerables();
        $types = array_keys($stickerables);

        $validator = Validator::make($request->all(), [
            'text' => 'max:8',
            'bg_color' => 'sometimes|regex:/#[0-9a-f]{6}/',
			'text_color' => 'sometimes|regex:/#[0-9a-f]{6}/',
            'stickerable_type' => ['sometimes', Rule::in($types)],
        ]);

        $validator->sometimes('stickerable_id', [Rule::exists(Pluralizer::plural($request->stickerable_type), 'id')],
            function($input) use($stickerables){
                return $stickerables[$input->stickerable_type]['type'] === 'morph';
            }
        );

		$sticker->update($request->only([
			'text' ,
            'bg_color',
            'text_color',
		]) + [
            'type' =>  $request->stickerable_type
        ]);

        if($stickerables[$request->stickerable_type]['type'] === 'morph') {
            $sticker->update($request->only([
                'stickerable_type',
                'stickerable_id',
            ]));
        } else {
            $sticker->stickerable()->dissociate();
        }

        $sticker->save();
        return redirect()->route("admin.web_settings")
            ->with('notifications', [['type' => 'success', 'message' => "Nálepka {$request->name} byla upravena"]]);
    }

    public function addSticker(Request $request)
    {

		$stickerables =  Sticker::getStickerables();
        $types = array_keys($stickerables);

        $validator = Validator::make($request->all(), [
            'text' => 'max:8',
            'bg_color' => 'required|regex:/#[0-9a-f]{6}/',
			'text_color' => 'required|regex:/#[0-9a-f]{6}/',
            'stickerable_type' => ['required', Rule::in($types)],
        ]);

        $validator->sometimes('stickerable_id', [Rule::exists(Pluralizer::plural($request->stickerable_type), 'id')],
            function($input) use($stickerables){
                return $stickerables[$input->stickerable_type]['type'] === 'morph';
            }
        );

		$sticker = Sticker::create($request->only([
			'text' ,
            'bg_color',
            'text_color',
		]) + [
            'type' =>  $request->stickerable_type
        ]);

        if($stickerables[$request->stickerable_type]['type'] === 'morph') {
            $sticker->update($request->only([
                'stickerable_type',
                'stickerable_id',
            ]));
        }


        $sticker->save();
        return redirect()->route("admin.web_settings")
            ->with('notifications', [['type' => 'success', 'message' => "Nálepka {$request->name} byla přidána"]]);
    }

    public function destroy(Sticker $sticker){
        $sticker->delete();
        return redirect()->back()->with('notifications', [['type' => 'success', 'message' => "Nálepka byla smazána"]]);
    }
}
