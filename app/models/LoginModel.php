<?php
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;

class LoginModel {

	public function checkLogin($data)
	{
		if(file_exists('file/user.json')){
			
			$file = file_get_contents('file/user.json');
			// var_dump(base_api.'gettoken');
			// exit();
			if($file){
				
				$value = json_decode($file, true);
				$query = $value['uname'];
				if($_POST['username'] == $query['identity'] && $_POST['password'] == $query['password']){
					
					if($value['session']['expired_at'] == date('Y-m-d H:i:s')){
						$client = new Client();
						$guzzle = $client->request('POST', base_api.'/gettoken',
						[
							'headers' => [ 'Content-Type' => 'application/json' ],
							'body' => json_encode([
								'identity' => $_POST['username'],
								'password' => $_POST['password'],
							]),
							// 'http_errors' => false
						]
						);
						if ($guzzle->getStatusCode() != 200) {
							$response['session'] = NULL;
							$response['message'] = 'Login Gagal';
							return $response;
						} else {
							$return = $guzzle->getBody()->getContents();
							$res = (array)json_decode($return);
							$uname = ['identity' => $_POST['username'],'password' => $_POST['password']];
							$array = [
								'uname' => $uname, 
								'session' => $res
							];
							if($res['status'] == 200){
								$file = file_put_contents('file/user.json', json_encode($array));
								$response['session'] = $res;
								$response['name'] = $_POST['username'];
								$response['message'] = 'Login Success';
								return $response;
							}else {
								$response['session'] = NULL;
								$response['message'] = 'Login Gagal';
								return $response;
							}
						}
					}else {
						$response['session'] = $value['session'];
						$response['name'] = $_POST['username'];
						$response['message'] = 'Login Success';
						return $response;
					}
				} else {
					
					$client = new Client();
					$guzzle = $client->request('POST', base_api.'/gettoken',
					[
						'headers' => [ 'Content-Type' => 'application/json' ],
						'body' => json_encode([
							'identity' => $_POST['username'],
							'password' => $_POST['password'],
						]),
						'http_errors' => false
					]);
					if ($guzzle->getStatusCode() != 200) {
						$response['session'] = NULL;
						$response['message'] = 'Login Gagal';
						return $response;
					} else {
						$return = $guzzle->getBody()->getContents();
						$res = (array)json_decode($return);
						$uname = ['identity' => $_POST['username'],'password' => $_POST['password']];
						$array = [
							'uname' => $uname, 
							'session' => $res
						];
						if($res['status'] == 200){
							$file = file_put_contents('file/user.json', json_encode($array));
							$response['session'] = $res;
							$response['name'] = $_POST['username'];
							$response['message'] = 'Login Success';
							return $response;
						}else {
							$response['session'] = NULL;
							$response['message'] = 'Login Gagal';
							return $response;
						}
					}
				}
			}else {
				$client = new Client();
				$guzzle = $client->request('POST', base_api.'/gettoken',
				[
					'headers' => [ 'Content-Type' => 'application/json' ],
					'body' => json_encode([
						'identity' => $_POST['username'],
						'password' => $_POST['password'],
					]),
					'http_errors' => false
				]);
				if ($guzzle->getStatusCode() != 200) {
					$response['session'] = NULL;
					$response['message'] = 'Login Gagal';
					return $response;
				} else {
					$return = $guzzle->getBody()->getContents();
					$res = (array)json_decode($return);
					$uname = ['identity' => $_POST['username'],'password' => $_POST['password']];
					$array = [
						'uname' => $uname, 
						'session' => $res
					];
					if($res['status'] == 200){
						$file = file_put_contents('file/user.json', json_encode($array));
						$response['session'] = $res;
						$response['name'] = $_POST['username'];
						$response['message'] = 'Login Success';
						return $response;
					}else {
						$response['session'] = NULL;
						$response['message'] = 'Login Gagal';
						return $response;
					}
				}
			}
		}else {

			$client = new Client();
			$guzzle = $client->request('POST', base_api.'/gettoken',
			[
				'headers' => [ 'Content-Type' => 'application/json' ],
				'body' => json_encode([
					'identity' => $_POST['username'],
					'password' => $_POST['password'],
				]),
				'http_errors' => false
			]);
			$return = $guzzle->getBody()->getContents();
			$res = (array)json_decode($return);
			$uname = ['identity' => $_POST['username'],'password' => $_POST['password']];
			$array = [
				'uname' => $uname, 
				'session' => $res
			];
			if($res['status'] == 200){
				$file = file_put_contents('file/user.json', json_encode($array));
				$response['session'] = $res;
				$response['name'] = $_POST['username'];
				$response['message'] = 'Login Success';
				return $response;
			}else {
				$response['session'] = NULL;
				$response['message'] = 'Login Gagal';
				return $response;
			}
		}
	}

}