<?php

class Emisi extends Controller {
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
			$this->view('emisi/index', $data);
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
		// $data['data'] = [];
        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('emisi/scanQr', $data);
        $this->view('templates/footer');
    }
}