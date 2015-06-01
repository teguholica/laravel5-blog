<?php namespace App\Http\Controllers\Frontend;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\VisitorModel;
use App\Models\GCMDeviceModel;
use App\Models\PostModel;
use App\Models\TagModel;
use App\Models\CategoryModel;
use App\Models\WebSettingModel;

use App\Libs\Date;

class FrontendController extends Controller {

	function __construct(Request $request)
	{
		$visitorModel = new VisitorModel;
		$visitorModel->ip = $request->getClientIp();
		$visitorModel->url = $request->url();
		$visitorModel->save();
	}

	protected function loadView($view, $appendData)
	{
		$data = $appendData;
		$data['date'] = new Date;
		$data['categories'] = new CategoryModel;
		$data['recentPosts'] = PostModel::where('is_publish', '1')->orderBy('updated_at','DESC')->limit(10)->get();
		$data['tags'] = TagModel::all();

		$data['webSettings'] = new \stdClass;
		foreach(WebSettingModel::all() as $webSetting){
			$data['webSettings']->{$webSetting->attr} = $webSetting->value;
		}

		return view('frontend.'.$view, $data);
	}

}
