<?php
use GuzzleHttp\Client;

class KebisinganModel  extends Model{
	
	public function GetData($no_sample, $kon){
        if($kon == true){
            $client = new Client();
            $guzzle = $client->request('POST', base_api.'/getSample',
            [
                'headers' => [ 'Content-Type' => 'application/json' ],
                'body' => json_encode([
                    'token' => $_SESSION['token'],
                    'no_sample' => $no_sample
                ]),
                'http_errors' => false
            ]);
            if ($guzzle->getStatusCode() != 200) {
                return json_encode(array('message' => 'No Sample Tidak Ditemukan'));
            } else {
                $return = $guzzle->getBody()->getContents();
                return $return;
            }
        }else {
            return json_encode(array('message' => 'Anda sedang offline tidak dapat mendapatkan data dari server'));
        }
	}

    public function saveDataUdara($data, $kon, $post){
        if($kon == true){
           
            $client = new Client();
            $guzzle = $client->request('POST', base_api.'/addDataUdaraApi?token='.$_SESSION['token'],
                [
                    'headers' => [ 'Content-Type' => 'application/json' ],
                    'body' => json_encode($post),
                    'http_errors' => false
                ]
            );
            if ($guzzle->getStatusCode() != 200) {
                $before_save = $this->before_save('Kebisingan', $post);
                $response['message'] = 'Data Gagal Dikirim';
                $response['status'] = 'danger';
                return $response;
            } else {
                $response['message'] = 'Data Berhasil Dikirim Keserver';
                $response['status'] = 'success';
                return $response;
            }
        }else {
            $before_save = $this->before_save('Kebisingan', $post);

            if(file_exists('file/data_kebisingan.json')){
                $file = file_get_contents('file/data_kebisingan.json');
                if($file){
                    $array = [];
                    $old = json_decode($file, true);
                    foreach($old as $k => $v){
                        if($v['no_sample'] == $data['no_sample'] && $data['jenis_durasi'] == 'Sesaat'){
                            $response['message'] = 'No Sample Ini Sudah ada';
                            $response['status'] = 'danger';
                            return $response;die();
                        }
                    }
                    // var_dump('gamasuk');
                    $value = json_decode($file, true);
                    array_push($value, $post);
                    $myfile = fopen('file/data_kebisingan.json', "w");
                    fwrite($myfile, json_encode($value, JSON_PRETTY_PRINT));
                    fclose($myfile);
                    $response['message'] = 'Data Berhasil Disimpan';
                    $response['status'] = 'success';
                    return $response;
                }else {
                    $array = [];
				    array_push($array, $post);
                    $myfile = fopen('file/data_kebisingan.json', "w");
                    fwrite($myfile, json_encode($array, JSON_PRETTY_PRINT));
                    fclose($myfile);
                    $response['message'] = 'Data Berhasil Disimpan';
                    $response['status'] = 'success';
                    return $response;
                }
            }else {
                $array = [];
				array_push($array, $post);
                file_put_contents('file/data_kebisingan.json', json_encode($array, JSON_PRETTY_PRINT));
                $response['message'] = 'Data Berhasil Disimpan';
                $response['status'] = 'success';
                return $response;
            }
        }
    }

    public function getJsonData(){
        if(file_exists('file/data_kebisingan.json')){
            $file = file_get_contents('file/data_kebisingan.json');
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
        if(file_exists('file/data_kebisingan.json')){
            $file = file_get_contents('file/data_kebisingan.json');
            if($file){
                $total = json_decode($file, true);
                foreach($total as $key => $value){
                    $client = new Client();
                    $guzzle = $client->request('POST', base_api.'/addDataUdaraApi?token='.$_SESSION['token'],
                        [
                            'headers' => [ 'Content-Type' => 'application/json' ],
                            'body' => json_encode($value),
                            'http_errors' => false
                        ]
                    );
                    if ($guzzle->getStatusCode() != 200) {
                        return json_encode(array());
                    } else {
                        unset($total[$key]);
                        $json = json_encode($total, JSON_PRETTY_PRINT);
                        file_put_contents('file/data_kebisingan.json', $json);
                        // $return = $guzzle->getBody()->getContents();
                        
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

    public function getDataKebisingan($kon){
        if($kon == true){
            $client = new Client();
            $guzzle = $client->request('POST', base_api.'/showDataUdara',
            [
                'headers' => [ 'Content-Type' => 'application/json' ],
                'body' => json_encode([
                    'token' => $_SESSION['token'],
                    'active' => 0
                ]),
                'http_errors' => false
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

    public function approveData($id){
        $client = new Client();
		$guzzle = $client->request('POST', base_api.'/appDataAir',
		[
			'headers' => [ 'Content-Type' => 'application/json' ],
			'body' => json_encode([
				'token' => $_SESSION['token'],
				'id' => $id
			]),
			'http_errors' => false
		]);
        if ($guzzle->getStatusCode() != 200) {
            return json_encode(array());
        } else {
            $return = $guzzle->getBody()->getContents();
            return $return;
        }
    }

    public function rejectData($id){
        $client = new Client();
		$guzzle = $client->request('POST', base_api.'/deleteUdara',
		[
			'headers' => [ 'Content-Type' => 'application/json' ],
			'body' => json_encode([
				'token' => $_SESSION['token'],
				'id' => $id
			]),
			'http_errors' => false
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
		$guzzle = $client->request('POST', base_api.'/detailLapanganUdara',
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
}