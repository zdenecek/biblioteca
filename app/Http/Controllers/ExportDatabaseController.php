<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCollection;
use App\Models\BookSection;
use App\Models\Borrow;
use App\Models\Reservation;
use App\Models\User;
use Egulias\EmailValidator\Exception\ExpectingCTEXT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Zip;

class ExportDatabaseController extends Controller
{
    private function getTables() {
		return [
			'books' => [
				'string' => 'Knihy',
				'getter' => function ($deleted = false) {
                    $ret = $deleted? Book::withTrashed() : Book::query();
					return $ret->get()->map(function ($model) {
						return $model->setAppends([])->makeHidden('author')->attributesToArray();
					});
				},
			],
			'book_collections' => [
				'string' => 'Sbírky',
				'getter' => function ($deleted = false) {
                    $ret = $deleted? BookCollection::withTrashed() : BookCollection::query();
					return $ret->get()->map(function ($model) {
						return $model->attributesToArray();
					});
				},
			],
			'book_sections' => [
				'string' => 'Sekce',
				'getter' => function ($deleted = false) {
                    $ret = $deleted? BookSection::withTrashed() : BookSection::query();
					return $ret->get()->map(function ($model) {
						return $model->attributesToArray();
					});
				},
			],
			'reservations' => [
				'string' => 'Rezervace',
				'getter' => function ($deleted = false) {
                    $ret = $deleted? Reservation::withTrashed() : Reservation::query();
					return $ret->get()->map(function ($model) {
						return $model->attributesToArray();
					});
				},
			],
			'borrows' => [
				'string' => 'Výpůjčky',
				'getter' => function ($deleted = false) {
                    $ret = $deleted? Borrow::withTrashed() : Borrow::query();

					return $ret->get()->map(function ($model) {
						return $model->attributesToArray();
					});
				},
			],
			'users' => [
				'string' => 'Uživatelé',
				'getter' => function ($deleted = false) {
                    $ret = $deleted? User::withTrashed() : User::query();

					return $ret->get()->map(function ($model) {
						return $model->attributesToArray();
					});
				},
			],
			'web_settings' => [
				'string' => 'Nastavení',
				'getter' => function ($deleted = false) {
                    return DB::table('settings')->get();
				},
			],
		];
	}


    public function showExport()
    {
        return view('admin.db.export', ['tables' => $this->getTables()]);
    }

    public function export(Request $request)
	{
        $request->validate([
            'tables' => 'required|min:1'
        ]);

        $includeHeaders = $request->has('include_headers');
        $includeDeleted = $request->has('include_deleted');

		$zipname = "biblioteca-export-" . now()->format('Y-m-d') . ".zip";

        $zip = Zip::create($zipname);

		$tables = $this->getTables();

		$toCsvLine = function ($array) {
			return implode(',', $array) . "\r\n";
		};

		$escape = function ($string) {
			$string = str_replace('"', '""', $string);
			if (str_contains($string, ',')) {
				$string = "\"{$string}\"";
			}
			return $string;
		};

        $counter = 0;
		foreach ($tables as $name => $data) {
            if($request->has('tables.'.$name) === false) continue;
            $counter++;
			$string = '';
            $lines = $data['getter']($includeDeleted);
            if($includeHeaders) $string .= $toCsvLine(array_keys((array) $lines->first()));
			foreach ($lines as $line) {
				$string .= $toCsvLine(array_map($escape, (array) $line));
			}
			$zip->addRaw($string, $name . '.csv');
		}
        return $zip;
	}
}
