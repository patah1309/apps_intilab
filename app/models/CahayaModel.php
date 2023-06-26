<?php
use GuzzleHttp\Client;

class CahayaModel extends Model{
	
	public function Permission($kon){
        if($kon == true){
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
        }else {
            return json_encode(array());
        }
		
	}
	public function GetListData($kon){
        if($kon == true) {
            $client = new Client();
            $guzzle = $client->request('POST', base_api.'/indexCahaya',
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
        }else {
            return json_encode(array());
        }
		
	}

	public function ApproveDat($id){
		$client = new Client();
		$guzzle = $client->request('POST', base_api.'/appCahaya',
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
		$guzzle = $client->request('POST', base_api.'/deleteCahaya',
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
		$guzzle = $client->request('POST', base_api.'/detailCahaya',
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
	public function GetData($no_sample, $kon){
        if($kon == true) {
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
        }else {
            return json_encode(array('message' => 'Anda sedang offline tidak dapat mendapatkan data dari server'));
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
                $before_save = $this->before_save('Cahaya', $post);
                $response['message'] = 'Data Gagal Dikirim';
                $response['status'] = 'danger';
                return $response;
            } else {
               $response['message'] = 'Data Berhasil Dikirim Keserver';
                $response['status'] = 'success';
                return $response;
                
            }
        }else {
            $before_save = $this->before_save('Cahaya', $post);
            if(file_exists('file/data_cahaya.json')){
                $file = file_get_contents('file/data_cahaya.json');
                if($file){
                    $array = [];
                    $old = json_decode($file, true);
                    foreach($old as $k => $v){
                        if($v['no_sample'] == $data['no_sample']){
                            $response['message'] = 'No Sample Ini Sudah ada';
                        }
                    }
                    $value = json_decode($file, true);
                    array_push($value, $post);
                    $myfile = fopen('file/data_cahaya.json', "w");
                    fwrite($myfile, json_encode($array, JSON_PRETTY_PRINT));
                    fclose($myfile);
                    $response['message'] = 'Data Berhasil Disimpan';
                    $response['status'] = 'success';
                    return $response;
                }else {
                    $array = [];
				    array_push($array, $post);
                    $myfile = fopen('file/data_cahaya.json', "w");
                    fwrite($myfile, json_encode($array, JSON_PRETTY_PRINT));
                    fclose($myfile);
                    $response['message'] = 'Data Berhasil Disimpan';
                    $response['status'] = 'success';
                    return $response;
                }
            }else {
                $array = [];
				array_push($array, $post);
                file_put_contents('file/data_cahaya.json', json_encode($array, JSON_PRETTY_PRINT));
                $response['message'] = 'Data Berhasil Disimpan';
                $response['status'] = 'success';
                return $response;
            }
        }
    }

    public function getJsonData(){
        if(file_exists('file/data_cahaya.json')){
            $file = file_get_contents('file/data_cahaya.json');
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
        if(file_exists('file/data_cahaya.json')){
            $file = file_get_contents('file/data_cahaya.json');
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
                        file_put_contents('file/data_cahaya.json', $json);
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