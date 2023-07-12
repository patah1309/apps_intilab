<?php
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

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
            $file = file_get_contents('file/data_cahaya.json');
            if($file){
                return json_decode($file);
            }else {
                return json_encode(array());
            }
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
	public function HapusDat($id, $kon){
        if($kon == true) {
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
        }else {
            $file = file_get_contents('file/data_cahaya.json');
            if($file){
                $value = [];
                $datoff = json_decode($file, true);
                foreach($datoff as $k => $v){
                    if($v['no_sample'] != str_replace("_","/", $id)){
                        $value[] = $v;
                    }
                }
                $myfile = fopen('file/data_cahaya.json', "w");
                fwrite($myfile, json_encode($value, JSON_PRETTY_PRINT));
                fclose($myfile);
                $res = ([
                    'message' => 'Data Berhasil Dihapus',
                ]);
                return json_encode($res);
            }
        }
		
	}

	public function showDetail($id, $kon){
        if($kon == true) {
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
        }else {
            $file = file_get_contents('file/data_cahaya.json');
            if($file){
                $datoff = json_decode($file, true);
                foreach($datoff as $k => $v){
                    if($v['no_sample'] == str_replace("_","/", $id)){
                        $array[] = $v;
                    }
                }
                return (object)$array[0];
            }else {
                return json_encode(array());
            }
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
        // var_dump(json_encode($post));
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
                        if($v['no_sample'] == $post['no_sample']){
                            $response['message'] = 'No Sample Ini Sudah ada';
                            $response['status'] = 'danger';
                            return $response;die();
                        }
                    }
                    $value = json_decode($file, true);
                    array_push($value, $post);
                    $myfile = fopen('file/data_cahaya.json', "w");
                    fwrite($myfile, json_encode($value, JSON_PRETTY_PRINT));
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
                $gagal = [];
                foreach($total as $key => $value){
                    $client = new Client();
                    try {
                        $guzzle = $client->request('POST', base_api.'/addDataUdaraApi?token='.$_SESSION['token'],
                            [
                                'headers' => [ 'Content-Type' => 'application/json' ],
                                'body' => json_encode($value),
                            ]
                        );
                    } catch (RequestException $e) {
                        if ($e->getResponse() && $e->getResponse()->getStatusCode() === 401) {
                            $gagal[] = $value;
                        }
                    }
                }
                $sidat = count($gagal);
                if($sidat == 0) {
                    return json_encode(array('message' => 'Data berhasil di sinkronisasi'));
                }else {
                    $myfile = fopen('file/data_cahaya.json', "w");
                    fwrite($myfile, json_encode($gagal, JSON_PRETTY_PRINT));
                    fclose($myfile);
                    return json_encode(array('message' => 'Ada data offline gagal upload ke server.!'));
                }
            }else {
                 return json_encode(array());
            }
        }else {
             return json_encode(array());
        }
    }
}