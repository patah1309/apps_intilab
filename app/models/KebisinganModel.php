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
        if($kon == true){
            // var_dump($data, $kon);
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
            if(file_exists('file/data_kebisingan.json')){
                $file = file_get_contents('file/data_kebisingan.json');
                if($file){

                    // $data = json_encode($data);
                    $array = [];
                    $old = json_decode($file, true);
                    // $old = array_push($old, array($data));
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
                file_put_contents('file/data_kebisingan.json', json_encode($array));
            }
        }
    }
}