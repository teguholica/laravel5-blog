<?php namespace App\Http\Controllers;

use App\Models\VisitorModel;
use DB;

class DashboardController extends Controller {

	public function index(){
		$data['visitorByIP'] = VisitorModel::groupBy('ip')->orderBy('total', 'DESC')->limit(5)->get(array(
			'ip',
			DB::raw('count(ip) as total')
		));
		$data['visitorByTime'] = VisitorModel::orderBy('created_at', 'DESC')->limit(5)->get();
		$data['visitorByURL'] = VisitorModel::groupBy('url')->orderBy('total', 'DESC')->limit(5)->get(array(
			'url',
			DB::raw('count(url) as total')
		));
		return view('admin.dashboard.index', $data);
	}

}
