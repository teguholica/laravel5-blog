<?php namespace App\Http\Controllers;

use App\Models\VisitorModel;
use App\Models\GCMDeviceModel;
use App\Models\PostModel;
use App\Models\TagModel;
use App\Models\CategoryModel;
use App\Models\WebSettingModel;

use App\Libs\Date;

use Illuminate\Http\Request;

class FrontendController extends Controller {

	function __construct(Request $request){
		$visitorModel = new VisitorModel;
		$visitorModel->ip = $request->getClientIp();
		$visitorModel->url = $request->url();
		$visitorModel->save();

		$this->sendMsg('Ada Pengunjung mengakses '.$visitorModel->url);
	}

	protected function loadView($view, $appendData){
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

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	private function sendMsg($msg)
	{
		$apiKey = "AIzaSyBwpctTqbqX2E6sL4g5-akLwmC3WseUU08";

		$GCMDevices = GCMDeviceModel::where('active', 1)->get();
		foreach($GCMDevices as $device){
			$registrationIDs[] = $device->device_id;
		}

		if(isset($registrationIDs)){
			//$message = "test messages from server";
		    $message = $msg;
		    
		    //foreach($registrationIDs as $id){
	        $fields = array(
	            'registration_ids'  => $registrationIDs,
	            'data'              => array( "message" => $message ),
	        );
	    
	    	$headers = array(
			    "Authorization:key=".$apiKey,
			    "Content-Type:application/json",
			);

	        $ch = curl_init();
	        curl_setopt( $ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
	        curl_setopt( $ch, CURLOPT_POST, true );
	        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
	    	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
	        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
	        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	        curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );
	        //echo json_encode( $fields );

	        $result = curl_exec($ch);
	        curl_close($ch);

	        //echo "$result<br />\n";
	    }
	}

}