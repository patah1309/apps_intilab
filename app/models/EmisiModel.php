<?php
use GuzzleHttp\Client;

class EmisiModel extends Model{
	
	public function GetData($qr = null, $no_sample = null, $kon=false){
        if($kon == true){
            $client = new Client();
            $guzzle = $client->request('POST', base_api.'/checkQr',
            [
                'headers' => [ 'Content-Type' => 'application/json' ],
                'body' => json_encode([
                    'token' => $_SESSION['token'],
                    'qr' => $qr,
                    'no_sample' => $no_sample
                ]),
                'http_errors' => false
            ]);
            
            if ($guzzle->getStatusCode() != 201) {
                return json_encode(array('message' => 'No Data'));
            } else {
                $return = $guzzle->getBody()->getContents();
                return $return;
            }
        }else {
            return json_encode(array('message' => 'No Data'));
        }
	}

    public function saveData($kon, $post){
        if($kon == true){
           
            $client = new Client();
            $guzzle = $client->request('POST', base_api.'/writeEmisi?token='.$_SESSION['token'],
                [
                    'headers' => [ 'Content-Type' => 'application/json' ],
                    'body' => json_encode($post),
                    'http_errors' => false
                ]
            );
            if ($guzzle->getStatusCode() != 201) {
                $before_save = $this->before_save('Emisi', $post);
                $response['message'] = 'Data Gagal Dikirim';
                $response['status'] = 'danger';
                return $response;
            } else {
                $response['message'] = 'Data Berhasil Dikirim Keserver';
                $response['status'] = 'success';
                return $response;
            }
        }else {
            $before_save = $this->before_save('Emisi', $post);

            if(file_exists('file/data_emisi.json')){
                $file = file_get_contents('file/data_emisi.json');
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
                    $myfile = fopen('file/data_emisi.json', "w");
                    fwrite($myfile, json_encode($value, JSON_PRETTY_PRINT));
                    fclose($myfile);
                    $response['message'] = 'Data Berhasil Disimpan';
                    $response['status'] = 'success';
                    return $response;
                }else {
                    $array = [];
				    array_push($array, $post);
                    $myfile = fopen('file/data_emisi.json', "w");
                    fwrite($myfile, json_encode($array, JSON_PRETTY_PRINT));
                    fclose($myfile);
                    $response['message'] = 'Data Berhasil Disimpan';
                    $response['status'] = 'success';
                    return $response;
                }
            }else {
                $array = [];
				array_push($array, $post);
                file_put_contents('file/data_emisi.json', json_encode($array, JSON_PRETTY_PRINT));
                $response['message'] = 'Data Berhasil Disimpan';
                $response['status'] = 'success';
                return $response;
            }
        }
    }

    public function getJsonData(){
        if(file_exists('file/data_emisi.json')){
            $file = file_get_contents('file/data_emisi.json');
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
        if(file_exists('file/data_emisi.json')){
            $file = file_get_contents('file/data_emisi.json');
            if($file){
                $total = json_decode($file, true);
                foreach($total as $key => $value){
                    $client = new Client();
                    $guzzle = $client->request('POST', base_api.'/writeEmisi?token='.$_SESSION['token'],
                        [
                            'headers' => [ 'Content-Type' => 'application/json' ],
                            'body' => json_encode($value),
                            'http_errors' => false
                        ]
                    );
                    if ($guzzle->getStatusCode() != 201) {
                        return json_encode(array());
                    } else {
                        unset($total[$key]);
                        $json = json_encode($total, JSON_PRETTY_PRINT);
                        file_put_contents('file/data_emisi.json', $json);
                        
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

    public function getDataEmisi($kon){
        if($kon == true){
            $client = new Client();
            $guzzle = $client->request('POST', base_api.'/showfdlemisi',
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
            $file = file_get_contents('file/data_emisi.json');
            if($file){
                return json_decode($file);
            }else {
                return json_encode(array());
            }
        }
    }

    public function approveData($id){
        $client = new Client();
		$guzzle = $client->request('POST', base_api.'/appemisi',
		[
			'headers' => [ 'Content-Type' => 'application/json' ],
			'body' => json_encode([
				'token' => $_SESSION['token'],
				'id' => $id
			]),
			'http_errors' => false
		]);
        if ($guzzle->getStatusCode() != 201) {
            return json_encode(array());
        } else {
            $return = $guzzle->getBody()->getContents();
            return $return;
        }
    }

    public function deleteData($id){
        $client = new Client();
		$guzzle = $client->request('POST', base_api.'/hapusemisi',
		[
			'headers' => [ 'Content-Type' => 'application/json' ],
			'body' => json_encode([
				'token' => $_SESSION['token'],
				'id' => $id
			]),
			'http_errors' => false
		]);
        if ($guzzle->getStatusCode() != 201) {
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
            'http_errors' => false
		]);
        if ($guzzle->getStatusCode() != 201) {
            return json_encode(array());
        } else {
            $return = $guzzle->getBody()->getContents();
            return json_decode($return);
        }
		
	}

    public function regulasi($kon){
        if(file_exists('file/master_regulasi.json')){
            $file = file_get_contents('file/master_regulasi.json');
            if($file){
                $data = json_decode($file, true);
                return $data;
            }else {
                return array();
            }
        }else {
            return array();
        }
    }

    public function getDetail($qr){
        $client = new Client();
		$guzzle = $client->request('GET', base_api.'/getDataEmisi',
		[
			'headers' => [ 'Content-Type' => 'application/json','key' => 'eb928269046b298bc2223eb1bacd797b' ],
			'body' => json_encode([
				'token' => $_SESSION['token'],
                'qr' => $qr,
            ]),
            // 'http_errors' => false
		]);
        if ($guzzle->getStatusCode() != 201) {
            return json_encode(array());
        } else { 
            $return = $guzzle->getBody()->getContents();
            return $return;
        }
    }
    
    public function getDetailoff($qr){
        $file = file_get_contents('file/data_emisi.json');
        if($file){
            $datoff = json_decode($file, true);
            foreach($datoff as $k => $v){
                if($v['no_sample'] == str_replace("_","/", $qr)){
                    $array[] = $v;
                }
            }
            return (object)$array[0];
        }else {
            return json_encode(array());
        }
    }

    public function HapusData($id) {
        $file = file_get_contents('file/data_emisi.json');
        if($file){
            $value = [];
            $datoff = json_decode($file, true);
            foreach($datoff as $k => $v){
                if($v['no_sample'] != str_replace("_","/", $id)){
                    $value[] = $v;
                }
            }
            $myfile = fopen('file/data_emisi.json', "w");
            fwrite($myfile, json_encode($value, JSON_PRETTY_PRINT));
            fclose($myfile);
            $res = ([
                'message' => 'Data Berhasil Dihapus',
            ]);
            return json_encode($res);
        }
    }
    
    public function sync_regulasi($kon){
        // var_dump($kon);die();
        if($kon == true){
            $client = new Client();
            $guzzle = $client->request('POST', base_api.'/showRegulasi',
            [
                'headers' => [ 'Content-Type' => 'application/json' ],
                'body' => json_encode([
                    'token' => $_SESSION['token'],
                    'active' => 0
                ]),
                // 'http_errors' => false
            ]);
            if ($guzzle->getStatusCode() != 200) {
                return json_encode(array());
            } else {
                $return = json_decode($guzzle->getBody()->getContents());
                $res = (array)$return->data;
                $file = file_put_contents('file/master_regulasi.json', json_encode($res, JSON_PRETTY_PRINT));
                $response['message'] = 'Berhasil dilakukan';
                $response['status'] = 'success';
                return $response;
            }
        }else {
            $response['message'] = 'Gagal dilakukan';
            $response['status'] = 'danger';
            return $response;
        }
    }
}