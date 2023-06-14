<?php
use GuzzleHttp\Client;

class UserModel {
	
	public function getUserById(){
		$client = new Client();
		$response = $client->request('POST', 'https://apps.intilab.com/eng/backend/public/default/api/getuserbytoken',
		[
			'headers' => [ 'Content-Type' => 'application/json' ],
			'body' => json_encode([
				'token' => $_SESSION['token'],
			]),
			'http_errors' => false
		]);
		$return = $response->getBody()->getContents();
		$res = (array)json_decode($return);
		return $res;
	}
}