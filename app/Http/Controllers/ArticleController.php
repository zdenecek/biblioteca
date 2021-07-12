<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use stdClass;

class ArticleController extends Controller
{
	public function showRules()
	{
		$rules = $this->getRules();

		return view('rules', ['rules' => $rules]);
	}

	public function showEditRules()
	{
		$rules = $this->getRules();

		return view('admin.edit_rules', ['rules' => $rules]);
	}

	public function editRules(Request $request)
	{
		DB::table('article')->upsert(['name' => 'rules', 'value' => $request->rules], ['name'], ['value']);

		return redirect()->route('rules');
	}

	public function showDashboard()
	{
		$data = $this->getDashboardData();

		return view('dashboard', ['data' => $data]);
	}

	public function showEditDashboard()
	{
		$data = $this->getDashboardData();

		return view('admin.edit_dashboard', ['data' => $data]);
	}

	public function editDashboard()
	{
		foreach ($this->dashboardData as $item) {
			DB::table('article')->upsert(['name' => $item, 'value' => request()->get($item)], ['name'], ['value']);
		}

		return redirect()->route('dashboard');
	}

	private $dashboardData = ['about', 'mon', 'tue', 'wed', 'thu', 'fri'];

	private function getDashboardData()
	{
		$data = DB::table('article')->whereIn('name', $this->dashboardData)->get();
		$results = new stdClass();

		foreach ($this->dashboardData as $item) {
			$results->$item = $data->where('name', $item)->first()?->value;
		}

		return $results;
	}

	private function getRules()
	{
		return DB::table('article')->where('name', 'rules')->first('value')?->value;
	}
}
