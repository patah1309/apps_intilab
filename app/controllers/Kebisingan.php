<?php

class Kebisingan extends Controller {
	public function __construct()
	{	
        date_default_timezone_set('Asia/Jakarta');

		if($_SESSION['session_login'] != 'sudah_login') {
			Flasher::setMessage('Login','Tidak ditemukan.','danger');
			header('location: '. base_url . '/login');
			exit;
		} else {
			if(date('Y-m-d H:i:s') == $_SESSION['expired_at']){
				Flasher::setMessage('Login','Tidak ditemukan.','danger');
				header('location: '. base_url . '/login');
				exit;
			}
		}
	} 
	public function index()
	{
		if($_SESSION['versi'] == $this->versi()){
            
            $date = DATE('H:i:s');
            if($date > '01:00:00' && $date < '10:00:00'){
                $status = 'Selamat Pagi';
            } else if ($date > '10:00:01' && $date < '15:00:00'){
                $status = 'Selamat Siang';
            } else if ($date > '15:00:01' && $date < '18:00:00'){
                $status = 'Selamat Sore';
            } else {
                $status = 'Selamat Malam';
            }


			$data['title'] = 'APPS INTILAB';
			// $val = $this->model('UserModel')->getUserById();
			$data['nama'] = $_SESSION['name'];
            $data['salam'] = $status;
			// $data['koneksi'] = $this->connection();
			$data['total_data'] = $this->model('KebisinganModel')->getJsonData();
			$this->view('templates/header', $data);
			$this->view('templates/sidebar', $data);
			$this->view('kebisingan/index', $data);
			$this->view('templates/footer');
		}else {
			session_start();
			session_destroy();
			header('location: '. base_url . '/login');
		}
		
	}

    public function add_data(){
        $data['title'] = 'APPS INTILAB';
		$data['token'] = $_SESSION['token'];
        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('kebisingan/input', $data);
        $this->view('templates/footer');
    }

	public function getSampel(){
		$no_sample = $_POST['no_sample'];
		$val = $this->model('KebisinganModel')->GetData($no_sample);
		echo $val;
	}

	public function saveData(){
		var_dump('test');
		if ($_POST['jenis_durasi'] == "24 Jam" || $_POST['jenis_durasi'] == '8 Jam') {
			$jendur = $_POST['jenis_durasi'] . '-' . json_encode($_POST['durasi_sampl']);
		} else {
			$jendur = $_POST['jenis_durasi'];
		}
		$data = array(
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
			'jenis_durasi' => $jendur,
			'kebisingan' => $_POST['kebisingan'],
			'suhu_udara' => $_POST['suhu_udara'],
			'kelembapan_udara' => $_POST['kelembapan_udara'],
			'permis' => $_POST['permis'],
			'foto_lok' => $_POST['foto_lok'],
			'foto_lain' => $_POST['foto_lain'],
			'is_sync' => '0');
		$kon = $this->connection();
		$save = $this->model('KebisinganModel')->saveDataUdara($data, $kon, $_POST);
		// echo $save;
		// var_dump($save['message'], $save['status']);
		Flasher::setMessage($save['message'],'','success');
		header('location: '. base_url . '/kebisingan');
		// if($save['message'] == 'No Sample Ini Sudah ada'){
		// 	Flasher::setMessage($save['message'],'',$save['status']);
		// 	header('location: '. base_url . '/kebisingan');
		// }else {
		// 	Flasher::setMessage($save['message'],'',$save['status']);
		// 	header(' : '. base_url . '/kebisingan');
		// }
	}

	public function upload_data_to_server(){
		$data = $this->model('KebisinganModel')->syncronize();
		echo $data;
	}

}