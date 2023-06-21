<?php
use GuzzleHttp\Client;

class GetaranLingModel {
	
	public function Permission(){
		$client = new Client();
		$guzzle = $client->request('POST', base_api.'/permissionapi',
		[
			'headers' => [ 'Content-Type' => 'application/json' ],
			'body' => json_encode([
				'token' => $_SESSION['token'],
            ]),
		]);
        if ($guzzle->getStatusCode() != 200) {
            return json_encode(array());
        } else {
            $return = $guzzle->getBody()->getContents();
            return json_decode($return);
        }
		
	}
	public function GetListData(){
		$client = new Client();
		$guzzle = $client->request('POST', base_api.'/indexGetaran',
		[
			'headers' => [ 'Content-Type' => 'application/json' ],
			'body' => json_encode([
				'token' => $_SESSION['token'],
                'active' => 0
            ]),
		]);
        if ($guzzle->getStatusCode() != 200) {
            return json_encode(array());
        } else {
            $return = $guzzle->getBody()->getContents();
            return json_decode($return);
        }
		
	}

	public function ApproveDat($id){
		$client = new Client();
		$guzzle = $client->request('POST', base_api.'/appGetaran',
		[
			'headers' => [ 'Content-Type' => 'application/json' ],
			'body' => json_encode([
				'token' => $_SESSION['token'],
                'id' => $id
            ]),
		]);
        if ($guzzle->getStatusCode() != 200) {
            return json_encode(array());
        } else {
            $return = $guzzle->getBody()->getContents();
            return $return;
        }
		
	}
	public function HapusDat($id){
		$client = new Client();
		$guzzle = $client->request('POST', base_api.'/deleteGetaran',
		[
			'headers' => [ 'Content-Type' => 'application/json' ],
			'body' => json_encode([
				'token' => $_SESSION['token'],
                'id' => $id
            ]),
		]);
        if ($guzzle->getStatusCode() != 200) {
            return json_encode(array());
        } else {
            $return = $guzzle->getBody()->getContents();
            return $return;
        }
		
	}

	public function showDetail($id){
		$client = new Client();
		$guzzle = $client->request('POST', base_api.'/detailGetaran',
		[
			'headers' => [ 'Content-Type' => 'application/json' ],
			'body' => json_encode([
				'token' => $_SESSION['token'],
                'id' => $id
            ]),
            // 'http_errors' => false
		]);
        if ($guzzle->getStatusCode() != 200) {
            return json_encode(array());
        } else {
            $return = $guzzle->getBody()->getContents();
            return json_decode($return);
        }
		
	}
	public function GetData($no_sample){
		$client = new Client();
		$guzzle = $client->request('POST', base_api.'/getSample',
		[
			'headers' => [ 'Content-Type' => 'application/json' ],
			'body' => json_encode([
				'token' => $_SESSION['token'],
                'no_sample' => $no_sample
            ]),
            // 'http_errors' => false
		]);
        if ($guzzle->getStatusCode() != 200) {
            return json_encode(array());
        } else {
            $return = $guzzle->getBody()->getContents();
            return $return;
        }
		
	}

    public function saveData($kon, $post){
        // var_dump(json_encode($data));
        if($kon == true){
            $client = new Client();
            $guzzle = $client->post(base_api.'/addDataUdaraApi?token='.$_SESSION['token'],
                [
                    'headers' => [ 'Content-Type' => 'application/json' ],
                    'body' => json_encode($post),
                    'http_errors' => false,
                ]
            );
            if ($guzzle->getStatusCode() != 200) {
                $before_save = $this->before_save('Getaranling', $post);
                $response['message'] = 'Data Gagal Dikirim';
                $response['status'] = 'danger';
                return $response;
            } else {
               $response['message'] = 'Data Berhasil Dikirim Keserver';
                $response['status'] = 'success';
                return $response;
            }
        }else {
            $before_save = $this->before_save('Getaranling', $post);
            if(file_exists('file/data_getaranling.json')){
                $file = file_get_contents('file/data_getaranling.json');
                if($file){
                    $array = [];
                    $old = json_decode($file, true);
                    foreach($old as $k => $v){
                        if($v['no_sample'] == $data['no_sample']){
                            $response['message'] = 'No Sample Ini Sudah ada';
                        }
                    }
                    $i = 0;
                    foreach($old as $key => $value){
                        $array[$i++] = $value;
                    }
                    $array[$i] = $data;
                    $myfile = fopen('file/data_getaranling.json', "w");
                    fwrite($myfile, json_encode($array, JSON_PRETTY_PRINT));
                    fclose($myfile);
                    $response['message'] = 'Data Berhasil Disimpan';
                    $response['status'] = 'success';
                    return $response;
                }else {
                    $array = [0 => $data];
                    $myfile = fopen('file/data_getaranling.json', "w");
                    fwrite($myfile, json_encode($array, JSON_PRETTY_PRINT));
                    fclose($myfile);
                    $response['message'] = 'Data Berhasil Disimpan';
                    $response['status'] = 'success';
                    return $response;
                }
            }else {
                $array = [0 => $data];
                file_put_contents('file/data_getaranling.json', json_encode($array, JSON_PRETTY_PRINT));
                $response['message'] = 'Data Berhasil Disimpan';
                $response['status'] = 'success';
                return $response;
            }
        }
    }

    public function getJsonData(){
        if(file_exists('file/data_getaranling.json')){
            $file = file_get_contents('file/data_getaranling.json');
            if($file){
                $total = count(json_decode($file, true));
            }else {
                $total = 0;
            }
        }else {
            $total = 0;
        }

        return $total;
    }

    public function syncronize(){
        if(file_exists('file/data_getaranling.json')){
            $file = file_get_contents('file/data_getaranling.json');
            if($file){
                $total = json_decode($file, true);
                foreach($total as $key => $value){
                    $client = new Client();
                    $guzzle = $client->request('POST', base_api.'/addDataUdaraApi?token='.$_SESSION['token'],
                        [
                            'headers' => [ 'Content-Type' => 'application/json' ],
                            'body' => json_encode($value),
                            // 'http_errors' => false
                        ]
                    );
                    if ($guzzle->getStatusCode() != 200) {
                        return json_encode(array());
                    } else {
                        unset($total[$key]);
                        $json = json_encode($total, JSON_PRETTY_PRINT);
                        file_put_contents('file/data_getaranling.json', $json);
                        // $return = $guzzle->getBody()->getContents();
                        // return $return;
                    }
                }
                 return json_encode(array('message' => 'Data berhasil di sinkronisasi'));
            }else {
                 return json_encode(array());
            }
        }else {
             return json_encode(array());
        }
    }
}