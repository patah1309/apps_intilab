<?php
use GuzzleHttp\Client;

class KebisinganModel {
	
	public function GetData($no_sample){
		$client = new Client();
		$guzzle = $client->request('POST', 'https://apps.intilab.com/eng/backend/public/default/api/getSample',
		[
			'headers' => [ 'Content-Type' => 'application/json' ],
			'body' => json_encode([
				'token' => $_SESSION['token'],
                'no_sample' => $no_sample
            ]),
            'http_errors' => false
		]);
        // var_dump($guzzle->getStatusCode());
        if ($guzzle->getStatusCode() != 200) {
            return json_encode(array());
        } else {
            $return = $guzzle->getBody()->getContents();
            // $res = (array)json_decode($return);
            return $return;
        }
		
	}

    public function saveDataUdara($data, $kon){
        // $kon = $this->connection();
        // var_dump($_POST['no_sample']);
        // var_dump($kon);
        if($kon == true){
            var_dump("masuk");
            $client = new Client();
            $guzzle = $client->request('POST', 'https://apps.intilab.com/eng/backend/public/default/api/addDataUdaraApi',
                [
                    'headers' => [ 'Content-Type' => 'application/json' ],
                    'body' => json_encode([
                        'token' => $_SESSION['token'],
                        'no_sample' => $_POST['no_sample'],
                        'id_kat' => $_POST['id_kat'],
                        'keterangan_4' => $_POST['keterangan_4'],
                        'information' => $_POST['information'],
                        'posisi' => $_POST['posisi'],
                        'lat' => $_POST['lat'],
                        'longi' => $_POST['longi'],
                        'jen_frek' => $_POST['jen_frek'],
                        'waktu' => $_POST['waktu'],
                        'sumber_keb' => $_POST['sumber_keb'],
                        'jenis_kat' => $_POST['jenis_kat'],
                        'jenis_durasi' => $_POST['jenis_durasi'],
                        'kebisingan' => $_POST['kebisingan'],
                        'suhu_udara' => $_POST['suhu_udara'],
                        'kelembapan_udara' => $_POST['kelembapan_udara'],
                        'permis' => $_POST['permis'],
                        'foto_lok' => $_POST['foto_lok'],
                        'foto_lain' => $_POST['foto_lain'],
                    ]),
                    // 'http_errors' => false
                ]
            );
            if ($guzzle->getStatusCode() != 200) {
                return json_encode(array());
            } else {
                $return = $guzzle->getBody()->getContents();
                // $res = (array)json_decode($return);
                return $return;
            }
        }else {
            var_dump("gak");
            if(file_exists('file/data_kebisingan.json')){
                $file = file_get_contents('file/data_kebisingan.json');
                if($file){
                    // $data = json_encode($data);
                    $array = [];
                    $old = json_decode($file, true);
                    // $old = array_push($old, array($data));
                    foreach($old as $k => $v){
                        if($v['no_sample'] == $data['no_sample'] && $data['jenis_durasi'] == 'Sesaat'){
                            $response['message'] = 'No Sample Ini Sudah ada';
                        }
                    }
                    $i = 0;
                    foreach($old as $key => $value){
                        $array[$i++] = $value;
                    }
                    $array[$i] = $data;
                    // $array[] = array_push($array, $data);
                    // var_dump($array);
                    $myfile = fopen('file/data_kebisingan.json', "w");
                    fwrite($myfile, json_encode($array, JSON_PRETTY_PRINT));
                    fclose($myfile);
                }else {
                    $array = [0 => $data];
                    $myfile = fopen('file/data_kebisingan.json', "w");
                    fwrite($myfile, json_encode($array, JSON_PRETTY_PRINT));
                    fclose($myfile);
                }
            }else {
                // var_dump('gak_masuk');
                $array = [0 => $data];
                file_put_contents('file/data_kebisingan.json', json_encode($array, JSON_PRETTY_PRINT));
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
                    $guzzle = $client->request('POST', 'https://apps.intilab.com/eng/backend/public/default/api/addDataUdaraApi',
                        [
                            'headers' => [ 'Content-Type' => 'application/json' ],
                            'body' => json_encode([
                                'token' => $_SESSION['token'],
                                'no_sample' =>$value['no_sample'],
                                'id_kat' =>$value['id_kat'],
                                'keterangan_4' =>$value['keterangan_4'],
                                'information' =>$value['information'],
                                'posisi' =>$value['posisi'],
                                'lat' =>$value['lat'],
                                'longi' =>$value['longi'],
                                'jen_frek' =>$value['jen_frek'],
                                'waktu' =>$value['waktu'],
                                'sumber_keb' =>$value['sumber_keb'],
                                'jenis_kat' =>$value['jenis_kat'],
                                'jenis_durasi' =>$value['jenis_durasi'],
                                'kebisingan' =>$value['kebisingan'],
                                'suhu_udara' =>$value['suhu_udara'],
                                'kelembapan_udara' =>$value['kelembapan_udara'],
                                'permis' =>$value['permis'],
                                'foto_lok' =>$value['foto_lok'],
                                'foto_lain' =>$value['foto_lain'],
                            ]),
                            'http_errors' => false
                        ]
                    );
                    if ($guzzle->getStatusCode() != 200) {
                        return json_encode(array());
                    } else {
                        unset($total[$key]);
                        $json = json_encode($total, JSON_PRETTY_PRINT);
                        file_put_contents('file/data_kebisingan.json', $json);
                        $return = $guzzle->getBody()->getContents();
                        return $return;
                    }
                }
            }else {
                // $total = 0;
            }
        }else {
            // $total = 0;
        }
    }
}