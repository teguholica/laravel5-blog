<?php

class GCMServiceController extends BaseController {

	public function register()
	{
		if(Input::has('regId')){
		    $cdate = date("Y-m-d H:i:s");

		    $GCMDeviceModel = new GCMDeviceModel;
		    $GCMDeviceModel->device_id = Input::get('regId');
		    $GCMDeviceModel->active = 1;
		    $GCMDeviceModel->save();

		    return "OK";
		} else {
		    return "NG";
		}
	}

	public function unregister()
	{
		if(Input::has('regId')){
		    $cdate = date("Y-m-d H:i:s");

		    $GCMDeviceModel = GCMDeviceModel::where('device_id', Input::get('regId'))->first();
		    $GCMDeviceModel->active = 0;
		    $GCMDeviceModel->save();

		    return "OK";
		} else {
		    return "NG";
		}
	}

	public function sendMsg()
	{
		$apiKey = "AIzaSyCVMx3w9Pw0DQyfXiQEqcA5OGWegrBichM";

		$GCMDevices = GCMDeviceModel::where('active', 1)->get();
		foreach($GCMDevices as $device){
			$registrationIDs[] = $device->device_id;
		}

		//$message = "test messages from server";
	    $message = 'coba';
	    
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
        echo json_encode( $fields );

        $result = curl_exec($ch);
        curl_close($ch);

        echo "$result<br />\n";
	}

}